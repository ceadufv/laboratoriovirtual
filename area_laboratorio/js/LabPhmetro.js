
LabPhmetro = function ( data ) {
    console.log('Novo pHmetro')

    // Objeto contendo a solucao
    this._solucao;
    this._desvioPadrao = data.desvioPadrao;
    this._vars = {};

    // 
    var a = this;
}

LabPhmetro._loop = function () { 
    var busca = LabUtils.buscarPorConceito('phmetro');

    if (!busca.length) return false;

    var handlerPhmetro = busca[0];
    handlerPhmetro.data('pHmodo').text = 'pH';

    var variacao = 0.2;
    var d = (Math.random() * variacao);

    handlerPhmetro.data('pHvisor').text = (7 + d-variacao/2).toFixed(3);

};

setInterval(function () {
    LabPhmetro._loop();
}, 1000);

LabPhmetro.prototype.solucao = function () {
    switch (arguments.length) {
        case 0:
            return this._solucao;
        break;
        case 1:
            this._solucao = arguments[0];
        break;
    }
    return this;
}

LabPhmetro.prototype.desvioPadrao = function () {
    switch (arguments.length) {
        case 0:
            return this._desvioPadrao;
        break;
        case 1:
            this._desvioPadrao = arguments[0];
        break;
    }
    return this;
}

LabPhmetro.mc = function (sd) {
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

LabPhmetro.prototype.novoMedirpH = function (tempo) {
    if (tempo < 10) {
        var m = this.MedirpH(tempo);
        this._vars = m.vars;

        /// console.log(m);

        //m.pHDisplay = 0;
    } else {
        var t = tempo;
        var da = this._vars;
        //console.log(da)

        var E = da.E;
        var desvio = 0.99;
        var Eant = E + desvio/2;
        var k = da.k;
        var Edisplay = E - (E - Eant)*Math.exp(k*t) + desvio;

        var fTcal = da.fTcal;
        var Ecal = da.Ecal;
        var feletrodo = da.feletrodo;
        var Scal = da.Scal;
        function getRandomArbitrary(min, max) { return Math.random() * (max - min) + min; }
        var pHDisplay = ((Edisplay - Ecal)/ (Scal*fTcal) ) - getRandomArbitrary(0.001, 0.01)

        //console.log('~',pHDisplay)

        m = {
            potencialDisplay: Edisplay,
            pHDisplay: pHDisplay
        };
    }

    return m;
}



LabPhmetro.prototype.MedirpH = function ( tempo ) {

    var solucao = this._solucao.content();

    // Dados do obj1 (pHmetro)
    var json1 = {
        obj1: [
            { "desvioPadrao": this.desvioPadrao() }
        ]
    };   

    var json2 = {
        obj2: []
    };

    for (var i = 0 ; i < solucao.length ; i++) {
        var o = { substancias:[], concentracoes:[], volumeTotal: solucao[i].volume() };
        for (var j = 0 ; j < solucao[i].data().length ; j++) {
            o.substancias[j] = solucao[i].data(j).reagente();
            o.concentracoes[j] = solucao[i].data(j).concentracao();
/*
            if (!isNaN( solucao[i].pH() ))
                o.pH = solucao[i].pH();
*/                
        }
        json2.obj2.push(o);
    }

    var data = { origem:json1, destino:json2, tempo:tempo };

    function pHmetro(data) {

        var json1 = data.origem;
        var json2 = data.destino; 

    //*

    /*
    Esta função é uma auxiliar para outras. Ela recebe parâmetros gerais de um sistema e faz o cálculo para uma determinada substância neste sistema.
    As variáveis q0 e numpKa são arrays passados por outra função.
    A variável somapKa é uma matriz de somatórios passada por outra função.
    A variável pH é um número real.
    A variável j é um inteiro e representa a posição da substância de interesse nos arrays que descrevem o sistema.
    */

        function cargaefetiva(pH, q0, somapKa, numpKa, j) {
            
            var termo0 = 1
            var alfai = 0;
            for (var i = 1; i <= numpKa[j - 1]; i++) {
                termo0 = termo0 + Math.pow(10, i * pH - somapKa[i - 1][j - 1]);
            }
            var alfa0 = 1 / termo0;
            var qef1 = alfa0 * q0[j - 1];
            for (var i = 1; i <= numpKa[j - 1]; i++) {
                alfai = Math.pow(10, i * pH - somapKa[i - 1][j - 1]) / termo0;
                qef1 = alfai * (q0[j - 1] - 1) + qef1;
            }
            
            return qef1;
        }

        function wat(pH, pKw, Hfi) {
            
            if(IsMissing(Hfi)){
                 Hfi = 0
            }
            return Math.pow(10,(-pH + Hfi)) - Math.pow(10,pH-pKw + Hfi);

        }

        function IsMissing(arg){
            if(!arg || arg == "" || arg == undefined || arg.length <= 0){
                return true;
            }else {
                return false;
            }
        }

        var mc = LabPhmetro.mc;

    //*

        function pHsol2(nAD, pKw, q0, carga, numpKa, conc, dados) {
            var somapKa = [];
            for (var i = 0; i < 20; i++) {
                somapKa[i] = [];
                for (var j = 0; j < 20; j++) {
                    somapKa[i][j] = 0
                }
            }
            

            for (var i = 1; i <= nAD; i++) {
                somapKa[1 - 1][i - 1] = dados[1 - 1][i - 1];
                for (var j = 2; j <= numpKa[i - 1]; j++) {
                    somapKa[j - 1][i - 1] = dados[j - 1][i - 1] + somapKa[j - 2][i - 1];
                }
            }


            var dif = 1;
            var pH = -2;
            var acresc = 1;
            var q = 0;

            while (Math.abs(dif) > 0.00000001) {
                dif = wat(pH, pKw);
                for (var i = 1; i <= nAD; i++) {
                    q = cargaefetiva(pH, q0, somapKa, numpKa, i);
                    dif = (q - carga[i - 1]) * conc[i - 1] + dif;
                }
                if (dif > 0) {
                    pH = pH + acresc;
                } else if (dif < 0) {
                    acresc = acresc / 2;
                    pH = pH - acresc;
                } else {
                    return pH;
                }
            }

            return pH;


        }   
                
        // Função Calculo pH
        
        var nAD, tipo, q0, carga, numpKa, conc, dado;

        for (var k = 0 ; k <json2.obj2.length ; k++) {
            var nAD = json2.obj2[k].substancias.length;
            
            //console.log(nAD, a.solucao.data(k));

            var tipo = json2.obj2[k].substancias;//não funciona se colocar json.obj1[i].substancias
            var q0 = [];
            var carga = [];
            var numpKa = [];
            var conc = json2.obj2[k].concentracoes;
            var dado = [];
            for (var i = 0; i < 20; i++) {
                dado[i] = [];
                for (var j = 0 ; j < 20 ; j++){ 
                    dado[i][j] = 0;
                }
            }

        }



        // Prepara a matriz com os valores de pKa em colunas
        // dado = [[valores de pKa1 de todos os componentes], [valores de pKa2 de todos os componentes], ...]
        for (var i = 0; i < nAD; i++) {
            dado[0][i] = dados(tipo[i]).vetorpKa[0];
            q0[i] = dados(tipo[i]).cargaMax;
            carga[i] = dados(tipo[i]).carga;
            numpKa[i] = dados(tipo[i]).npK;
            for (var j = 1; j < numpKa[i]; j++) {
                dado[j][i] = dados(tipo[i]).vetorpKa[j];
            }
        }
        var sd = json1.obj1[0].desvioPadrao;
        // console.log(sd)
        var pHcalculado = pHsol2(nAD, 14, q0, carga, numpKa, conc, dado);
        //console.log(pHcalculado)
        // json2.obj2[0].pH = pHcalculado
        // console.log(json2.obj2[0])

        // calculoph(phmetro,bequerph);

        //Função para medir o potencial a partir do pH calculado anteriormente

        function calculoPotencial () {
            S = - 59.16;
            var fa = 0.98 + mc(0.01);
            var fb = 0.98 + mc(0.01) ;
            var Ein0 = 650 + mc(10);
            var Ere0 = 220 +mc(10);
            var Ja = 10 + mc(10) ;
            var Jb = -200 + mc(10);
            var pH = pHcalculado; //pH da solução
            var pKw = 14;
            var T = 25 + mc(0.2); // temperatura do laboratorio (a principio constante - fixa 25)
            var Tt = 25;
            var pHtrans = 6.8;
            var exp = 0.2;

            var fT = (T+273.15)/(Tt+273.15);
            var Ere = Ere0 + Ja*Math.pow(10, -pH) + Jb*Math.pow(10, (pH - pKw));
            var fatoracido = 1/(1+Math.pow(10, ((pH-pHtrans)*exp)));
            var fatorbasico = fatoracido*Math.pow(10, ((pH-pHtrans)*exp));

            var Ein = (Ein0 + fT*S*pH*fatoracido)*fa + fT*S*pH*fatorbasico*fb;
            var El = Ein - Ere;
            return El;
        }

        
        //calculoPotencial();
        //console.log(calculoPotencial())   

        // Função para exibir o potencial na tela
        function potencialDisplay(){
            var args = arguments;

            var Tcal = 25;
            var T = 25;
            var tmax = 20;
            if (args.length == 0) {
                var E = calculoPotencial();
                var desvio = mc(0.05);
                var Eant = E + desvio/2
                var t = data.tempo;
                var t95 = tmax/Math.abs(Eant - E);
                var k = Math.log(0.05)/t95;

                var fTcal = (T+273.15)/(Tcal+273.15);
                var Ecal = 380 + mc(20);
                var feletrodo = 0.95 + mc(0.02)
                var Scal = - 59.16 * feletrodo;

            } else {
                var da = args[0];
                
                var E = da.E;
                var desvio = da.desvio;
                var Eant = da.Eant;
                var k = da.k;

                var fTcal = (T+273.15)/(Tcal+273.15);
                var Ecal = 380 + mc(20);
                var feletrodo = 0.95 + mc(0.02)
                var Scal = - 59.16 * feletrodo;

                /*var fTcal = da.fTcal;
                var Ecal = da.Ecal;
                var feletrodo = da.feletrodo;
                var Scal = da.Scal;*/

            }

            var Edisplay = E - (E - Eant)*Math.exp(k*t) + desvio;
            var pHDisplay = (Edisplay - Ecal)/ Scal*fTcal

            return {
                E: E,
                desvio: desvio,
                Eant: Eant,
                k: k,
                Edisplay: Edisplay,

                fTcal: fTcal,
                Ecal: Ecal,
                feletrodo: feletrodo,
                Scal: Scal,
                pHDisplay: pHDisplay
            };

        }


        var ttt = potencialDisplay();

        return { 
            potencialDisplay: ttt.Edisplay,
            pHDisplay: ttt.pHDisplay,
            vars: {
                E: ttt.E,
                Eant: ttt.Eant,
                desvio: ttt.desvio,
                k: ttt.k,

                fTcal: ttt.fTcal,
                Ecal: ttt.Ecal,
                feletrodo: ttt.feletrodo,
                Scal: ttt.Scal
            }
        }
    }

    var objetoDados = function (cargaMax, npK, carga, vetorpKa) {
        this.cargaMax = cargaMax;
        this.npK = npK;
        this.carga = carga;
        this.vetorpKa = vetorpKa;
    }


    function dados(o) {
        return {
            cargaMax: o.cargaMax(),
            npK: o.npK(),
            carga: o.carga(),
            vetorpKa: o.vetorpKa()
        };
    }        

    return pHmetro(data);
}