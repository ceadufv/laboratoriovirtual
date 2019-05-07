LabEspectrofotometro = function () {
	this._data = (arguments.length)?arguments[0]:{
		lampada: {
			deuterio: false,
			tungstenio: false
		}
	};
    this._status = 0;
    this._callback = function () {};
}

LabEspectrofotometro.prototype.status = function () {
    var args = arguments;
    if (args.length > 0) {
        this._status = args[0];
        return this;
    } else {
        return this._status;
    }
}

LabEspectrofotometro.prototype.lampada = function (id, value) {
	if (!this._data) {
		this._data.lampada = {};
	}
	this._data.lampada[id] = value;
	return this;
}

LabEspectrofotometro.prototype.done = function () {
    if (arguments.length > 0)
        this._callback = arguments[0];
    else
        this._callback();
}

LabEspectrofotometro.prototype.intensidadeFonte = function () {
	var deuterio = this._data.lampada.deuterio;
	var tungstenio = this._data.lampada.tungstenio;
	var result = [];

   	// Tungstenio
    var intensidadefonteVisivel = this._data.intensidadeFonte.intensidadefonteVisivel;
    // Deuterio
    var intensidadefonteUV = this._data.intensidadeFonte.intensidadefonteUV;
    // As duas
    var intensidadefonteUVeVisivel = this._data.intensidadeFonte.intensidadefonteUVeVisivel;

	if (!deuterio && tungstenio)
		result = intensidadefonteVisivel;

	if (deuterio && !tungstenio)
		result = intensidadefonteUV;

	if (deuterio && tungstenio)
		result = intensidadefonteUVeVisivel;

	return result;
}

LabEspectrofotometro.prototype.medir = function medirabs(solucao) {
    var raiz = '../../';
	var mc = LabPhmetro.mc;
	var arquivos = [];
    var $this = this;

	function preloader(f) {
		$.ajax({
			url: 'data.php',
			method: 'post',
			data: {
				action: 'espectrofotometro',
				data: true
			}
		}).done(function (data) {
			$this._data.intensidadeFonte = data;
			f();
		})
	}

    // Criar array de corte
    function slit(dados, limiteinferior, limitesuperior){
        var vetor = [];
        for (var i = 0; i< dados.length; i++){ 
            if (dados[i].l > limiteinferior && dados[i].l < limitesuperior){
                vetor.push(1)
            }
            else{
                vetor.push(0)
            }
        }
        return vetor;
    }

    // Criar array com todos os comprimentos de onda
    function separarComprimentos(dados){
        var vetor = [];
        for (var i = 0; i< dados.length; i++){ 
                vetor.push(dados[i].l)
        }
        return vetor;
    }

    // Criar array com todos as absortividades
    function separarAbsortividade(dados){
        var vetor = [];
        for (var i = 0; i< dados.length; i++){ 
                vetor.push(dados[i].I)
        }
        return vetor;
    }

    // Fazer somatório de acordo com os limites
    function somatorio(vetor){
        var soma = 0;
        for(var i=0 ;i < vetor.length; i++){
        	soma = soma + vetor[i]
        }
        return soma;
    }

    function Espectrofotometro(){
		// Atribui de acordo com qual lampada está ligada
        var intensidadefonte = $this.intensidadeFonte();

        // Define os limites
        var slitS = 1; // tamanho da fenda
        var Lmed = 400; // valor selecionado no espectrofotometro
        
        var limS = Lmed + slitS/2; 
        var limI = Lmed - slitS/2; 

        var comprimentos = separarComprimentos(intensidadefonte)

        var fslit = slit(intensidadefonte, limI, limS)

        var fMONO = 1;
        var fSS = 1;
        var fFiltro = 1;
        var Lcorte = 370; // Pode ser 370nm para cubeta de vidro e 160nm cubeta de quartzo
        var d = 0.4;
        var f = 5;
        var fCubeta = [];
        for (var i = 0; i< comprimentos.length; i++){ 
            fCubeta.push(1/(1+Math.pow(10, (Math.pow((Math.abs(Lcorte - comprimentos[i])), d)/f))));
        }


        var ftotal = [];
        for (var i = 0; i< comprimentos.length; i++){ 
            ftotal.push(fMONO*fSS*fFiltro*fCubeta[i]);
        }

        var c = solucao.concentracaoEstoque();
        //var epslon = data.solucao.epslon();
        //var c = [0.0001, 0.0005];

        //var eps = data.solucao.epslon();
        var epslon = solucao.absortividade();

        var fsolucao = [];
        for (var i = 0; i< intensidadefonte.length; i++){ 
            var soma = 0;

            for (var j = 0 ; j < c.length ; j++) {
                soma += epslon[j][i]*c[j];
            }

            fsolucao.push(Math.pow(10, -1 * (soma))); 
        }
        //console.log('fsolução:', fsolucao)

        var Idc = Math.pow(10, -3) + mc(5* Math.pow(10, -4));
        var Ilef = 0.004; // intensidade da luz espúria
        var status = $this.status(); // igual a 0 ou 1 dependendo se está aberto ou fechado
        var Ifea = 3; // itensidade da luz se o compartimento estiver fechado
        var le = 0.2*Ilef 
        var Ile = Ilef + status*Ifea + mc(le);
    
        
        //console.log('ILE:', Ile)
        //console.log('IDC:', Idc)

        var intensidade0 = [];
        for (var i = 0; i< intensidadefonte.length; i++){ 
            intensidade0.push(fslit[i]*ftotal[i] + Ile + Idc);
        }
        //console.log('intensidade0:', intensidade0)

        var intensidade = [];
        for (var i = 0; i< intensidadefonte.length; i++){ 
            intensidade.push(fslit[i]*ftotal[i]*fsolucao[i] + Ile + Idc);
        }
        //console.log('intensidade:' , intensidade)

        var somaI0 = somatorio(intensidade0); 
        //console.log('somaI0: ', somaI0)


        var somaI = somatorio(intensidade); 
        //console.log('somaI: ', somaI)

        var Tmed = 100 * somaI/ somaI0; 
        var Amed = 2 - Math.log10(Tmed);

        var Tmed0 = 100 * somaI0/ somaI0; 
        var Amed0 = 2 - Math.log10(Tmed);

        //console.log('Tmed:', Tmed);
        //console.log('Amed:', Amed);

        return { Tmed: Tmed, Amed: Amed };
        //return [[Amed0, Tmed0],[Amed, Tmed]];
    }

    preloader(function () {
        $this._callback(Espectrofotometro());
    	//if (data.funcao) data.funcao(rs)
    });

    return this;
}

function espectrofotometro() {
	return new LabEspectrofotometro();
}