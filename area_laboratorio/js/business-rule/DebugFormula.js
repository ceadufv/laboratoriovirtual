class DebugFormula {
    /**
     * função para debugar a função MC
     * @param {number} sd é o desvio padrão
     * @param {number} total_g total de numeros gerados
     * DebugFormula.debugMC(1.5);
     */
    static debugMC(sd, total_g = 2000) {
        var maior = -1000000000;
        var menor = 9999999999;
        var num = 0;
        for (let i = 0; i < total_g; i++) {
            num = QuimicaFormulas.MC(sd)
            if (num < menor) {
                menor = num;
            }

            if (num > maior) {
                maior = num;
            }
            console.log(num);
        }
        console.log('Numeros gerados', 'Maior: ', maior, ' Menor', menor);
    }


    /**
     * função para debugar a função misturarSolucoes
     * DebugFormula.debugMisturarSolucoes();
     */
    static debugMisturarSolucoes() {
        var sol1 = {
            itens: [
                { id: "1", nome: "Ácido Forte", concentracao: "0.1" },
                { id: "15", nome: "Benzoato", concentracao: "0.1" },
                { id: "13", nome: "Anilínio", concentracao: "0.1" },
                { id: "1", nome: "Ácido Forte", concentracao: "0.2" }],
            volume: 5
        }

        var sol2 = {
            itens: [
                { id: "1", nome: "Ácido Forte", concentracao: "0.1" },
                { id: "15", nome: "Benzoato", concentracao: "0.1" },
                { id: "13", nome: "Anilínio", concentracao: "0.1" },
                { id: "1", nome: "Ácido Forte", concentracao: "0.2" }],
            volume: 2
        }
        console.log('entrada', sol1, sol2);
        var nova_solucao = MisturaSolucoes.misturarSolucoes(sol1, sol2);
        console.log(nova_solucao);
        return nova_solucao;
    }


    /** calcula um PH 
     * DebugFormula.debugCalculoPH();
     */
    static debugCalculoPH() {
        var solucoes_itens = [
            { pkw: 14, pk: [9.24], qc: 0, r: 1, c: 0.01, qMax: 1 },
            { pkw: 14, pk: [4.76], qc: 0, r: 1, c: 0.01, qMax: 0 },
        ];
        return QuimicaPH.procurarPH(solucoes_itens);
    }
}