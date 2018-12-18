<!DOCTYPE html>
<html lang="en"> 
<head> 
    <meta charset="UTF-8" />
    <title>Treinamento Phaser</title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <style type="text/css">
        body {
            margin: 0;
        }
    </style>
</head>
<body>


<script type="text/javascript">
/*

*/
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
        //console.log(k, nAD)
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
    json2.obj2[0].pH = pHcalculado
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
        var El = calculoPotencial();
        //console.log(El)
        var t = data.tempo;// tempo de contato do eletrodo com a solução?
        var tmax = 20 + mc(0.05);
        var desvio = mc(json1.obj1[0].desvioPadrao);
        var t95 = tmax/Math.abs(El);
        var k = Math.log(0.05)/t95;
        var Edisplay = El * ( 1 - Math.exp(k*t) ) + desvio;
        console.log(Edisplay)

        return Edisplay;

    }

    return { 
        potencialDisplay: potencialDisplay(),
        pHDisplay: pHcalculado
    }
}


//Dados do obj1 (pHmetro)
var json1 = {
    obj1: [
        { "desvioPadrao": 0.02}
    ]
};

//Dados do obj2 (bequer solução)
var json2 = {
    obj2: [
        { "id":1, "substancias": ["Amônia"], "concentracoes": [0.01], "volumeTotal": 1000, "pH":0 },
        { "id":2, "substancias": ["Ácido Forte"], "concentracoes": [0.1], "volumeTotal": 1000  },
        { "id":3, "substancias": ["Acetato"], "concentracoes": [0.01], "volumeTotal": 1000 },
        { "id":4, "substancias": ["Base Forte"], "concentracoes": [0.1], "volumeTotal": 1000 },
    ]
};


var objetoDados = function (cargaMax, npK, carga, vetorpKa) {
    this.cargaMax = cargaMax;
    this.npK = npK;
    this.carga = carga;
    this.vetorpKa = vetorpKa;
}

function dados(nome) {
    /*var val = _dados[nome].data;
    return new objetoDados(val[0], val[1], val[2], val[3]);
    
    console.log('OLAR',val)*/
    //return new objetoDados();
    switch (nome) {
        case "Ácido Forte": return new objetoDados(0, 1, 0, [-7]); break;
        case "Base Forte": return new objetoDados(0, 1, -1, [14]); break;
        case "Acetato": return new objetoDados(0, 1, -1, [4.76]); break;
        case "Ácido Acético": return new objetoDados(0, 1, 0, [4.76]); break;
        case "Prata I": return new objetoDados(1, 2, 1, [12, 12.01]); break;
        case "Prata III": return new objetoDados(3, 5, 3, [5.02, 5.355, 5.69, 8.34, 10.91]); break;
        case "Alanina 1-": return new objetoDados(1, 2, -1, [2.348, 9.867]); break;
        case "Alanina-H": return new objetoDados(1, 2, 0, [2.348, 9.867]); break;
        case "Alanina-H2": return new objetoDados(1, 2, 1, [2.348, 9.867]); break;
        case "Amônia": return new objetoDados(1, 1, 0, [9.24]); break;
        case "Amônio": return new objetoDados(1, 1, 1, [9.24]); break;
        case "Anilina": return new objetoDados(1, 1, 0, [4.66]); break;
        case "Anilínio": return new objetoDados(1, 1, 1, [4.66]); break;
        case "Bário 2+": return new objetoDados(2, 2, 2, [13.36, 24.36]); break;
        case "Benzoato": return new objetoDados(0, 1, -1, [4.202]); break;
        case "Ácido Benzóico": return new objetoDados(0, 1, 0, [4.202]); break;
        case "Bicarbonato": return new objetoDados(0, 2, -1, [6.37, 10.32]); break;
        case "Borato": return new objetoDados(0, 1, -1, [9.234]); break;
        case "Ácido Bórico": return new objetoDados(0, 1, 0, [9.234]); break;
        case "Cálcio 2+": return new objetoDados(2, 2, 2, [12.67, 14]); break;
        case "Cafeina": return new objetoDados(1, 1, 1, [0.5]); break;
        case "Carbonato": return new objetoDados(0, 2, -2, [6.37, 10.32]); break;
        case "Ácido Carbônico": return new objetoDados(0, 2, 0, [6.37, 10.32]); break;
        case "Cádmio II": return new objetoDados(2, 4, 2, [10.08, 10.27, 12.95, 14.05]); break;
        case "Citrato 3-": return new objetoDados(0, 3, -3, [3.128, 4.762, 6.396]); break;
        case "Citrato-H": return new objetoDados(0, 3, -2, [3.128, 4.762, 6.396]); break;
        case "Citrato-H2": return new objetoDados(0, 3, -1, [3.128, 4.762, 6.396]); break;
        case "Ácido Cítrico": return new objetoDados(0, 3, 0, [3.128, 4.762, 6.396]); break;
        case "Cromo III": return new objetoDados(3, 4, 3, [4, 5.62, 7.13, 11.02]); break;
        case "Cromato-H2": return new objetoDados(0, 2, 0, [-0.2, 6.5]); break;
        case "Cromato-H": return new objetoDados(0, 2, -1, [-0.2, 6.51]); break;
        case "Cromato 2-": return new objetoDados(0, 2, -2, [-0.2, 6.51]); break;
        case "Cobre II": return new objetoDados(2, 4, 2, [7, 7.32, 10.68, 12.5]); break;
        case "Dietilamina": return new objetoDados(1, 1, 0, [11.11]); break;
        case "Dietilamônio": return new objetoDados(1, 1, 1, [11.11]); break;
        case "Dimetilamina": return new objetoDados(1, 1, 0, [10.72]); break;
        case "Dimetilamônio": return new objetoDados(1, 1, 1, [10.72]); break;
        case "EDTA 4-": return new objetoDados(0, 4, -4, [2, 2.678, 6.161, 10.26]); break;
        case "EDTA 3-": return new objetoDados(0, 4, -3, [2, 2.678, 6.161, 10.26]); break;
        case "EDTA 2-": return new objetoDados(0, 4, -2, [2, 2.678, 6.161, 10.26]); break;
        case "EDTA 1-": return new objetoDados(0, 4, -1, [2, 2.678, 6.161, 10.26]); break;
        case "EDTA": return new objetoDados(0, 4, 0, [2, 2.678, 6.161, 10.26]); break;
        case "Etilamina": return new objetoDados(1, 1, 0, [10.75]); break;
        case "Etilamônio": return new objetoDados(1, 1, 1, [10.75]); break;
        case "Ferro III": return new objetoDados(3, 4, 3, [2.19, 3.48, 5.69, 9.6]); break;
        case "Fenol": return new objetoDados(0, 1, 0, [9.89]); break;
        case "Fenolato": return new objetoDados(0, 1, -1, [9.89]); break;
        case "Fluoreto": return new objetoDados(0, 1, -1, [3.18]); break;
        case "Ácido Fluorídrico": return new objetoDados(0, 1, 0, [3.18]); break;
        case "Formiato": return new objetoDados(0, 1, -1, [3.760]); break;
        case "Ácido Fórmico": return new objetoDados(0, 1, 0, [3.760]); break;
        case "Hidrogenofosfato": return new objetoDados(0, 3, -2, [1.959, 7.125, 12.23]); break;
        case "Fosfato": return new objetoDados(0, 3, -3, [1.959, 7.125, 12.23]); break;
        case "Diidrogenofosfato": return new objetoDados(0, 3, -1, [1.959, 7.125, 12.23]); break;
        case "Ácido Fosfórico": return new objetoDados(0, 3, 0, [1.959, 7.125, 12.23]); break;
        case "Ftalato 2-": return new objetoDados(0, 2, -2, [2.950, 5.408]); break;
        case "Ftalato 1-": return new objetoDados(0, 2, -1, [2.950, 5.408]); break;
        case "Ácido Ftálico": return new objetoDados(0, 2, 0, [2.950, 5.408]); break;
        case "Glicina": return new objetoDados(1, 2, -1, [2.350, 9.778]); break;
        case "Glicina-H": return new objetoDados(1, 2, 0, [2.350, 9.778]); break;
        case "Glicina-H2": return new objetoDados(1, 2, 1, [2.350, 9.778]); break;
        case "Glifosfato": return new objetoDados(1, 4, -3, [1, 2.6, 5.6, 10.6]); break;
        case "Glifosfato-H": return new objetoDados(1, 4, -2, [1, 2.6, 5.6, 10.6]); break;
        case "Glifosfato-H2": return new objetoDados(1, 4, -1, [1, 2.6, 5.6, 10.6]); break;
        case "Glifosfato-H3": return new objetoDados(1, 4, 0, [1, 2.6, 5.6, 10.6]); break;
        case "Glifosfato-H4": return new objetoDados(1, 4, 1, [1, 2.6, 5.6, 10.6]); break;
        case "Guanidina": return new objetoDados(1, 1, 0, [13.540]); break;
        case "Guanidina-H": return new objetoDados(1, 1, 1, [13.540]); break;
        case "Hidroxilamina": return new objetoDados(1, 1, 0, [6.04]); break;
        case "Hidroxilamônio": return new objetoDados(1, 1, 1, [6.04]); break;
        case "Histidina": return new objetoDados(2, 3, 0, [1.7, 6.02, 9.08]); break;
        case "Histidina-H": return new objetoDados(2, 3, 1, [1.7, 6.02, 9.08]); break;
        case "Histidina-H2": return new objetoDados(2, 3, 2, [1.7, 6.02, 9.08]); break;
        case "Hássio 1-": return new objetoDados(0, 2, -1, [7, 15]); break;
        case "Metilamina": return new objetoDados(1, 1, 0, [10.7]); break;
        case "Metilamônio": return new objetoDados(1, 1, 1, [10.7]); break;
        case "Magnésio 2+": return new objetoDados(2, 2, 2, [11.44, 16.86]); break;
        case "Níquel II": return new objetoDados(2, 3, 2, [9.03, 10.42, 15.28]); break;
        case "Nitrito": return new objetoDados(0, 1, -1, [3.292]); break;
        case "Ácido Nitroso": return new objetoDados(0, 1, 0, [3.292]); break;
        case "Hidrogenooxalato": return new objetoDados(0, 2, -1, [1.271, 4.266]); break;
        case "Oxalato": return new objetoDados(0, 2, -2, [1.271, 4.266]); break;
        case "Ácido Oxálico": return new objetoDados(0, 2, 0, [1.271, 4.266]); break;
        case "Chumbo 2+": return new objetoDados(2, 4, 2, [7.71, 9.41, 10.94, 11.64]); break;
        case "Piridina": return new objetoDados(1, 1, 0, [5.15]); break;
        case "Piridínio": return new objetoDados(1, 1, 1, [5.15]); break;
        case "Enxofre 2-": return new objetoDados(0, 2, -2, [7, 15]); break;
        case "Salicilato": return new objetoDados(0, 1, -1, [2.98]); break;
        case "Ácido Acetilsalicílico": return new objetoDados(0, 1, 0, [2.98]); break;
        case "Hidrogenosulfato": return new objetoDados(0, 2, -1, [-3, 1.92082]); break;
        case "Sulfato": return new objetoDados(0, 2, -2, [-3, 1.92082]); break;
        case "Ácido Sulfídrico": return new objetoDados(0, 2, 0, [7, 15]); break;
        case "Ácido Sulfúrico": return new objetoDados(0, 2, 0, [-3, 1.92082]); break;
        case "Tartarato": return new objetoDados(0, 2, -2, [3.03, 4.54]); break;
        case "Ácido Tartárico": return new objetoDados(0, 2, 0, [3.03, 4.54]); break;
        case "Hidrogenotartarato": return new objetoDados(0, 2, -1, [3.03, 4.54]); break;
        case "Trietilamina": return new objetoDados(1, 1, 0, [10.762]); break;
        case "Trietilamônio": return new objetoDados(1, 1, 1, [10.762]); break;
        case "Tris": return new objetoDados(1, 1, 0, [8.075]); break;
        case "Tris-H": return new objetoDados(1, 1, 1, [8.075]); break;
        case "Zinco II": return new objetoDados(2, 4, 2, [9.6, 7.1, 11.6, 10.48]); break;
    }
    
}

console.log(pHmetro({ origem:json1, destino:json2, tempo:100 }));

</script>

