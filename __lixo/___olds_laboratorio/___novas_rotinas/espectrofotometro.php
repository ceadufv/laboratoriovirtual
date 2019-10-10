<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
var arquivos = [];

function preloader(f) {
    abrirArquivos([
      {id: 'intensidadezero', url: 'data/intensidadezero.txt'},
      {id: 'intensidadefonte', url: 'data/intensidadefonte.txt'},
      {id: 'intensidadebranco', url: 'data/branco.txt'}
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

preloader(function () {

	function mc (sd) {
	        var mc;
	        var i = 0;
	        while (i == 0) {
	            var random1 = 2 * Math.random() - 1;
	            var random2 = 2 * Math.random() - 1;
	            var Sum = random2 * random2 + random1 * random1;
	            if (Sum <= 1) {
	                var M2 = (-2 * Math.log(Sum) / Sum);
	                var M = Math.sqrt(M2);
	                mc = random1 * M * sd;
	                break;
	            }
	        }
	        return mc;
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
        // Criar vetor com as intensidades da fonte
        function criarVetorIfonte(dados){
            var Intfonte = [];
            for (var i = 0; i< dados.length; i++){ 
                    Intfonte.push(dados[i].I)
            }
            return Intfonte;
        }


        // Criar array com as intensidades dentro do limite estabelecido
        function criarIntensidades(dados){
            var intensidades = [];
            for (var i = 0; i< dados.length; i++){ 
                    intensidades.push(dados[i].I) 
            }
            return intensidades;
        }

        // Criar array com todos os comprimentos de onda
        function separarComprimentos(dados){
            var comprimentos = [];
            for (var i = 0; i< dados.length; i++){ 
                    comprimentos.push(dados[i].l)
            }
            return comprimentos;
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

            
            var intensidade_zero = lerArquivo(arquivos.intensidadezero);
            var intensidade_fonte = lerArquivo(arquivos.intensidadefonte);
            var intensidade_branco = lerArquivo(arquivos.intensidadebranco);
            console.log('I0_completo: ', intensidade_zero)
            console.log('Ifonte_completo: ', intensidade_fonte)
            console.log('Ibranco: ', intensidade_branco)


            var comprimentos = separarComprimentos(intensidade_fonte);
            console.log('lambdas_completo: ', comprimentos);

            var Ifonte = criarVetorIfonte(intensidade_fonte)
            console.log('Ifonte:' ,Ifonte)

            var Ibranco = criarIntensidades(intensidade_branco);
            console.log('Ibranco:' ,Ibranco)
            
            // Define os limites
            var slitS = 1; // tamanho da fenda
            var Lmed = 400; // valor selecionado no espectrofotometro
            
            var limS = Lmed + slitS/2; 
            var limI = Lmed - slitS/2; 
            console.log ('limI: ', limI)
            console.log ('limS: ', limS)
            
            I0 = criarIntensidades(intensidade_zero, limI, limS)
            console.log( 'I0: ',I0)
            var somaI0 = somatorio(I0);
            console.log('somaI0: ', somaI0)

        

            // function slitSaida(dados, limiteinferior, limitesuperior){
            //     for (var i = 0; i< dados.length; i++){ 
            //         if (dados[i].l < limitesuperior && dados[i].l > limiteinferior ){
            //             var fSE = 1;
            //         }
            //         else {
            //             var fSE = 0;
            //         }
            //     }
            //     return fSE;
            // }

            // var teste = slitSaida(comprimentos,limI, limS);// funcao
            // console.log(teste)

            var fSE = 1; // sempre está dentro do intervalo?
            var fMONO = 1;
            var fSS = 1;
            var fFiltro = 1;
            var Lcorte = 370; // Pode ser 370nm para cubeta de vidro e 160nm cubeta de quartzo
            var d = 0.4;
            var f = 5;
            var fCubeta = [];
            for (var i = 0; i< comprimentos.length; i++){ 
                fCubeta.push(1/(1+Math.pow(10, (Math.pow(-(Lcorte - comprimentos[i]), d)/f))));// sinal??
            }
            console.log('fCubeta: ', fCubeta);

            var ftotal = [];
            for (var i = 0; i< comprimentos.length; i++){ 
                ftotal.push(fSE*fMONO*fSS*fFiltro*fCubeta[i]);
            }
            console.log('ftotal: ',ftotal);

            
            
            var b=3;
            var somaEpslon = 4;

            var fsolucao = [];
            for (var i = 0; i< Ibranco.length; i++){ 
                fsolucao.push(Ibranco[i]*Math.pow(10, b*somaEpslon)); // definir somaEpslon como soma de epslon vezes concentração --> está no banco de dados
            }
            console.log('fsolução:', fsolucao)

            var Idc = Math.pow(10, -3) + mc(5* Math.pow(10, -4));
            var Ilef = 3; // intensidade da luz espúria
            var status = 0; // igual a 0 ou 1 dependendo se está aberto ou fechado
            var Ifea = 3; // itensidade da luz se o compartimento estiver fechado
            var le = 0.2*Ilef 
            var Ile = Ilef + status*Ifea + mc(le);
            
            console.log('ILE:', Ile)
            console.log('IDC:', Idc)

            
            var intensidade_final = [];
            for (var i = 0; i< Ifonte.length; i++){ 
                intensidade_final.push(Ifonte[i]*ftotal[i]*fsolucao[i] + Ile + Idc);
            }

            var somaI = somatorio(intensidade_final); 
            console.log('somaI: ', somaI)

            var Tmed = 100* somaI/ somaI0; 
            var Amed = 2 - Math.log(Tmed);

            console.log('Tmed:', Tmed);
            console.log('Amed:', Amed);

            return;

        }

        Espectrofotometro();
            
    

  
});
</script>

</body>
</html>