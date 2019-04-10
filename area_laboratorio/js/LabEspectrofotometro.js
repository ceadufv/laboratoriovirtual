LabEspectrofotometro = function (data) {
}

LabEspectrofotometro.medirabs = function medirabs(data) {
    var raiz = (arguments.length > 1)?arguments[1]:'';
	var mc = LabPhmetro.mc;
	var arquivos = [];

	function preloader(f) {
	    abrirArquivos([
	      {id: 'intensidadefonteVisivel', url: raiz+'js/rotinas/intensidadefonteVisivel.txt'},
	      {id: 'intensidadefonteUV', url: raiz+'js/rotinas/intensidadefonteUV.txt'},
	      {id: 'intensidadefonteUVeVisivel', url: raiz+'js/rotinas/intensidadefonteUVeVisivel.txt'},
	      {id: 'azulacido', url: raiz+'js/rotinas/azulacido.txt'},
	      {id: 'azulbasico', url: raiz+'js/rotinas/azulbasico.txt'},
	    ], function (a) {
	        arquivos = a;
	        f();
	    } );    
	}

	function abrirArquivos(o, f) {
	    var total = o.length;
	    var loaded = 0;
	    var result = {};

	    for (var i = 0 ; i < o.length ; i++) {

	        jQuery.ajax({
	            url: o[i].url+'?'+i
	        }).done(function (data) {
	            var n = parseInt(this.url.split('?').pop() );
	            var id = o[n].id;
	            result[id] = data;
	            loaded++;
	        })
	    }

	    var interval = setInterval(function () {
	        if (loaded == total) {
	            clearInterval(interval);
	            f(result);
	        }
	    });
	}

    function lerArquivo(data) {
    	var lines = data.split(/\r?\n/);
        var res = [];

        for(var i = 0; i < lines.length; i++){
            if (lines[i].indexOf('\t') == -1) continue;
            var s = lines[i].split('\t');
            res.push({l: parseFloat(s[0]), I: parseFloat(s[1])});
            
        }

        return res;
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

        var intensidadefonteVisivel = lerArquivo(arquivos.intensidadefonteVisivel);
        var intensidadefonteUV = lerArquivo(arquivos.intensidadefonteUV);
        var intensidadefonteUVeVisivel = lerArquivo(arquivos.intensidadefonteUVeVisivel);

        var azulacido = lerArquivo(arquivos.azulacido);
        //console.log('azulacido ', azulacido)

        var azulbasico = lerArquivo(arquivos.azulbasico);

        // Atribui de acordo com qual lampada está ligada
        var intensidadefonte = intensidadefonteVisivel;

        // Define os limites
        var slitS = 1; // tamanho da fenda
        var Lmed = 400; // valor selecionado no espectrofotometro
        
        var limS = Lmed + slitS/2; 
        var limI = Lmed - slitS/2; 
        //console.log ('limI: ', limI)
        //console.log ('limS: ', limS)

        var comprimentos = separarComprimentos(intensidadefonte)

        var fslit = slit(intensidadefonte, limI, limS)
        //console.log('fslit: ', fslit)

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
       //  console.log('fCubeta: ', fCubeta);

       //  console.log(Math.pow((370-371),0.5))

       // console.log(1/(1+Math.pow(10, (Math.pow(Math.abs((370 - 371)), d)/f))))


        var ftotal = [];
        for (var i = 0; i< comprimentos.length; i++){ 
            ftotal.push(fMONO*fSS*fFiltro*fCubeta[i]);
        }

        var c = [0.0001, 0.0005];
        var epslon = [separarAbsortividade(azulacido), separarAbsortividade(azulbasico)];

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
        var status = data.status; // igual a 0 ou 1 dependendo se está aberto ou fechado
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

        console.log('Tmed:', Tmed);
        console.log('Amed:', Amed);

        return [[Amed0, Tmed0],[Amed, Tmed]];
    }



    preloader(function () {
    	var rs = Espectrofotometro();
    	if (data.funcao) data.funcao(rs)
    });
}

//LabEspectrofotometro.medirabs({});



//     // Objeto contendo a solucao
//     this._solucao;
//     // this._desvioPadrao = data.desvioPadrao;
// }

// LabPhmetro.prototype.solucao = function () {
//     switch (arguments.length) {
//         case 0:
//             return this._solucao;
//         break;
//         case 1:
//             this._solucao = arguments[0];
//         break;
//     }
//     return this;
// }

// // LabPhmetro.prototype.desvioPadrao = function () {
// //     switch (arguments.length) {
// //         case 0:
// //             return this._desvioPadrao;
// //         break;
// //         case 1:
// //             this._desvioPadrao = arguments[0];
// //         break;
// //     }
// //     return this;
// }

