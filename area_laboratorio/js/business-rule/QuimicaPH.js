class QuimicaPH {
    /**
     * @author wellerson
     * Potencial elétrico
     * @param {*} eIN 400mV
     * @param {*} eREF -220mV
     * @param {*} Tt temperatura
     * @param {*} fa 1
     * @param {*} fb 0
     * @param {*} ja 0
     * @param {*} jb 0
     * @param {*} pkw 14
     * @param {number} pH inteiro
     * @examples
     QuimicaPH.eCalc(400, -220, 24, 1, 0, 0, 0, 14, 7);
     */
    static eCalc(eIN, eREF, Tt, fa, fb, ja, jb, pkw, pH) {
        return (eIN - eREF) - (59.16 / 298.16) * (Tt + 273.15) * (fa * pH - fb * (pH - pkw)) + ja + jb;
    }

    /**
      * @author Wellerson / Marcelo
      * @param {Int} indice
      * @param {Array} pk
      * @examples
      *   //entrada
          var indice = 2;
         var pk = [5.02, 5.355, 5.69, 8.34, 10.91];
         QuimicaPH.somatorioPk(indice, pk)
     */

    static somatorioPk(indice, pk) {
        var soma = 0;
        for (let i = 0; i <= indice; i++) {
            if (pk[i])
                soma += pk[i];
        }
        return parseFloat(soma);
    }

    /**
     * @author Wellerson / Marcelo
     * @param {Int} pH
     * @param {Array} pk
     * @examples
     *   //entrada
         var pH = 14;
        var pk = [5.02, 5.355, 5.69, 8.34, 10.91];
        var valoalfa = QuimicaPH.alfa0(pH, pk);
    */
    static alfa0(pH, pk) {
        var somatorio = 0;
        for (let i = 0; i < 1; i++) {
            somatorio += Math.pow(10, (i + 1) * pH - QuimicaPH.somatorioPk(0, pk));
        }
        var valorA = 1 / (1 + somatorio);
        return valorA;
    }

    /**
      * @author Wellerson / Marcelo
      * @param {Int} indice
      * @param {Int} pH
      * @param {Array} pk
      * @examples
      *   //entrada
          var pH = 14;
          var pk = [5.02, 5.355, 5.69, 8.34, 10.91];
          var NP = 2;
          var indice = 3;
          var valoalfa = QuimicaPH.alfa(indice, pH, pk);
      */
    static alfa(indice, pH, pk) {
        var alfa0V = QuimicaPH.alfa0(pH, pk);

        //se alfa0
        if (indice == 0) {
            return parseFloat(alfa0V.toFixed(9));
        }

        let alfav = alfa0V * Math.pow(10, (indice * pH - QuimicaPH.somatorioPk(indice, pk)));
        return parseFloat(alfav);
    }

    /**
     * @author Wellerson / Marcelo
     * @param {Number} pH
     * @param {Number} pKw
     * @example
        var pH = 2;
        var pKw = 14;
        QuimicaPH.wat(pH, pKw);
    */
    static wat(pH, pKw) {
        var watV = Math.pow(10, -pH) - Math.pow(10, pH - pKw);
        return (watV);
    }

    /**
      * @author Wellerson / Marcelo
      * @param {Number} MAX
      * @param {Int} pH
      * @param {Array} pk
      * @examples
       var qef_v = QuimicaPH.qef(4, [4.76], 0);
      */
    static qef(pH, pk, MAX) {
        var alfai;
        var qef_somatorio = 0;
        for (let i = 0; i < pk.length + 1; i++) {
            alfai = QuimicaPH.alfa(i, pH, pk);
            qef_somatorio += (MAX - i) * alfai;
        }
        return qef_somatorio;
    }

    /**
     * Testado
     * 
      var qef_v = QuimicaPH.qef(4,[4.76],0);
      var qc = 0;
      var r = 1;
      var c = 0.01;
      QuimicaPH.func_Qi(qef_v, qc, r, c);
     * */

    static func_Qi(qef_v, qc, r, c) {
        return (r * qc + qef_v) * c;
    }

    /**
     * @example
    var qef_v = QuimicaPH.qef(4, [4.76], 0);
    var qc = 0;
    var r = 1;
    var c = 0.01;
    var QiV = QuimicaPH.func_Qi(qef_v, qc, r, c);
    
    var watV = QuimicaPH.wat(4, 14);
    var solucaoQi = [QiV];
    console.log('dif',QuimicaPH.dif(watV, solucaoQi));
    */
    static dif(watV, solucaoQi) {
        var soma = 0;
        for (let i = 0; i < solucaoQi.length; i++) {
            soma += solucaoQi[i];
        }
        return soma + watV;
    }

    /**
    * @param {Array} solucoes_itens
    * procura o PH
        var solucoes_itens = [
            {pkw: 14, pk:[9.24], qc: 0, r:1, c: 0.01, qMax: 1},
            {pkw: 14, pk:[4.76], qc: 0, r:1, c: 0.01, qMax: 0},
        ];
        QuimicaPH.procurarPH(solucoes_itens);
    */
    static procurarPH(solucoes_itens, incremento = 0.01) {
        var pH = -2 - incremento;
        var resolucao = 1 * Math.pow(10, -8);
        var count = 3000;
        var dif = 9999;

        while (dif > resolucao) {
            pH = pH + incremento;
            let solucaoQi = [];
            let watV = 0;
            for (let i = 0; i < solucoes_itens.length; i++) {
                var qef_v = QuimicaPH.qef(pH, solucoes_itens[i].pk, solucoes_itens[i].qMax);
                var QiV = QuimicaPH.func_Qi(qef_v, solucoes_itens[i].qc, solucoes_itens[i].r, solucoes_itens[i].c);
                watV = QuimicaPH.wat(pH, solucoes_itens[i].pkw);
                solucaoQi.push(QiV);

                //console.log('Ph', pH, 'Qef', qef_v, 'Qi', QiV, 'watV', watV);
            }

            dif = QuimicaPH.dif(watV, solucaoQi);

            if (pH > 16)
                break;
            if (count < 0) {
                break;
            }
            count--;
        }
        //console.log(pH, dif, resolucao);
        return pH;
    }

}
