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

LabEspectrofotometro.prototype.comprimentoMedio = function () {
    var args = arguments;
    if (args.length > 0) {
        this._comprimentoMedio = args[0];
        return this;
    } else {
        return this._comprimentoMedio;
    }
}

LabEspectrofotometro.prototype.cubeta = function () {
    var args = arguments;
    if (args.length > 0) {
        this._cubeta = args[0];
        return this;
    } else {
        return this._cubeta;
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
/*
LabEspectrofotometro.prototype.intensBranco = function (){
    var branco = this._data.intensBranco.branco;
    return branco;
}*/

LabEspectrofotometro.prototype.medir = function medirabs(solucao) {
    var raiz = '../';
    var mc = LabPhmetro.mc;
    var arquivos = [];
    var $this = this;

    function preloader(f) {
        $.ajax({
            url: 'js/testes/data.php',
            method: 'post',
            data: {
                action: 'espectrofotometro',
                data: true
            }
        }).done(function (data) {
            // 
            $this._data.intensidadeFonte = data;
            //$this._data.intensBranco = data;
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
        //console.log(intensidadefonte)
        
        // Define os limites
        var slitS = 1; // tamanho da fenda
        var Lmed = $this.comprimentoMedio();
        //console.log('LEMD', Lmed)  // valor selecionado no espectrofotometro
        
        var limS = Lmed + slitS/2; 
        var limI = Lmed - slitS/2; 

        //console.log(limS, limI)

        var comprimentos = separarComprimentos(intensidadefonte)
        var intensfonte = separarAbsortividade(intensidadefonte)

        console.log(comprimentos);
        //console.log('comprimentos',comprimentos)
        //console.log('INTEN',intensfonte)

        var fslit = slit(intensidadefonte, limI, limS)
        //console.log(fslit)

        var fMONO = 1;
        var fSS = 1;
        var fFiltro = 1;
        var Lcubeta = $this.cubeta()// Pode ser 370nm para cubeta de vidro e 160nm cubeta de quartzo
        //console.log('Lcubeta', Lcubeta)

        if (Lcubeta == 370){
            var Lcorte = 370;
            var d = 0.2;
            var f = 3;
            var offset = -0.1;
        }
        else {
            var Lcorte = 380;
            var d = 0.2;
            var f = -2.8;
            var offset =-0.05;
        }
        
        var delta = [];
        for (var i = 0; i< comprimentos.length; i++){ 
            delta.push( Lcorte-comprimentos[i] )
        }

        var exponen = [];
        for (var i = 0; i< comprimentos.length; i++){ 
            if (delta[i] >= 0) {
                exponen.push( Math.pow(delta[i],d) )
            } else {
                exponen.push( -1 * Math.pow( -delta[i],d) )
            
            }
        }
        //console.log('exponen', exponen)

        var fCubeta = [];
        for (var i = 0; i< comprimentos.length; i++){ 
            fCubeta.push( 1/ (1+ Math.pow(10, (exponen[i]/f))) + offset )
        }
        //console.log('fCubeta', fCubeta)

        var ftotal = [];
        for (var i = 0; i< comprimentos.length; i++){ 
            ftotal.push(fMONO*fSS*fFiltro*fCubeta[i]);
        }
        //console.log('ftotal', ftotal)

        var c = solucao.concentracaoEstoque();
        //console.log('c', c)
        //var epslon = data.solucao.epslon();
        //var c = [0.0001, 0.0005];

        //var eps = data.solucao.epslon();
        var epslon = solucao.absortividade();
        //console.log('epslon', epslon)

        var fsolucao = [];
        var soma = 0;
        for (var i = 0; i< intensidadefonte.length; i++){ 
            for (var j = 0 ; j < c.length ; j++) {
                soma = soma + epslon[j][i]*c[j]*fslit[i];
            }
            //console.log('soma', soma)

            fsolucao.push(Math.pow(10, -1 * (soma))); 
        }
        //console.log('fsolução:', fsolucao)

        var Idc = Math.pow(10, -3) + mc(5* Math.pow(10, -4));
        var Ilef = 0.004; // intensidade da luz espúria
        var status = $this.status(); // igual a 0 ou 1 dependendo se está aberto ou fechado
        //console.log('status', status)
        var Ifea = 3; // itensidade da luz se o compartimento estiver aberto (aberto=1, fechado =0)
        var le = 0.2*Ilef 
        var Ile = Ilef + status*Ifea + mc(le);        
        //console.log('ILE:', Ile)
        //console.log('IDC:', Idc)

        // BRANCO
        // Abre o arquivo de intensidade do branco
        /*var branco = $this.intensBranco();
        var cbranco = 0.0000001;
        var epslonbranco = separarAbsortividade(branco);
        console.log(epslonbranco)

        var fbranco = [];
        var soma = 0;
        for (var i = 0; i < epslonbranco.length; i++){ 
            soma = soma + epslonbranco[i]*cbranco*fslit[i];
            fbranco.push(Math.pow(10, -1 * (soma))); 
        }
        console.log(fbranco)*/


        /*var intensidade0 = [];
        for (var i = 0; i<intensidadefonte.length; i++){
            intensidade0.push(intensfonte[i]*fslit[i]*ftotal[i] + Ile + Idc);
        }
        //console.log('intensidade0:', intensidade0)*/

        var intensidade = [];
        for (var i = 0; i< intensidadefonte.length; i++){ 
            intensidade.push(intensfonte[i]*fslit[i]*ftotal[i]*fsolucao[i] + Ile + Idc);
        }
        //console.log('intensidade:' , intensidade)

        var somaI = somatorio(intensidade); 
        //console.log('somaI: ', somaI)

        /*var intensidadebranco = [];
        for (var i = 0; i< intensidadefonte.length; i++){ 
            intensidadebranco.push(intensfonte[i]*fslit[i]*ftotal[i]*fbranco[i] + Ile + Idc);
        }
        console.log('intensidadebranco:' , intensidadebranco)*/

        /*var delta = [];
        for (var i = 0; i< intensidadefonte.length; i++){ 
            delta.push(-1*(intensidade[i] - intensidadebranco[i]));
        }
        console.log('delta:',delta)*/

        /*var somaI0 = somatorio(intensidadebranco); 
        console.log('somaI0: ', somaI0)

        var somaI = somatorio(intensidade); 
        console.log('somaI: ', somaI)

        var Tmed = 100 * somaI/ somaI0; 
        //var Amed = 2 - Math.log10(Tmed);

        //console.log('Tmed:', Tmed);
        //console.log('Amed:', Amed);*/

        return somaI;
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