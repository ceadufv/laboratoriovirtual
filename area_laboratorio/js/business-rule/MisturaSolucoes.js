class MisturaSolucoes {
    /**
     * @verificada dia 31/10/2019
     * @author wellerson
    * @parametros de entrada solucao
       sol1.itens = []
       sol1.itens[0] = {id: "1", nome: "Ácido Forte", concentracao: "0.1"}
       sol1.itens[1] = {id: "15", nome: "Benzoato", concentracao: "0.1"}
       sol1.volume = 0.8
       *MisturaSolucoes.misturarSolucoes(sol1, sol2);
       * @param {Object} sol1 
       * @param {Object} sol2
       * @returns {Object} nova solucao
       */
    static misturarSolucoes(sol1, sol2) {
        var novaSolucao = { itens: [], volume: 0 };
        novaSolucao = this.calcNovaConcentracao(novaSolucao, sol1);
        novaSolucao = this.calcNovaConcentracao(novaSolucao, sol2);
        novaSolucao.volume = (sol1.volume) + (sol2.volume);
        return novaSolucao;
    }

    /** calcula a nova concentracao da solucao
     * @verificada dia 31/10/2019
     * @author wellerson
     * @param {object} novaSolucao quem vai receber a nova solucao
     * @param {object} solucao
     * @returns {object} novaSolucao
     */
    static calcNovaConcentracao(novaSolucao, solucao) {
        for (let i = 0; i < solucao.itens.length; i++) {
            let novaconcentracao = (solucao.itens[i].concentracao) * (solucao.volume);
            let indice = this.verificaExisteItem(novaSolucao, solucao.itens[i]);
            if (indice != -1) {
                //recalcula o item
                novaSolucao.itens[indice].concentracao = (novaSolucao.itens[indice].concentracao) + novaconcentracao;
            } else {
                //adiciona o novo item
                novaSolucao.itens.push({ 'id': solucao.itens[i].id, 'nome': solucao.itens[i].nome, 'concentracao': novaconcentracao });
            }
        }
        return novaSolucao;
    }

    /** verifica já existe esse item no array
     * se ja existir retorna o indice / caso nao retorna -1
     * @verificada dia 31/10/2019
     * @author wellerson
     */
    static verificaExisteItem(novaSolucao, item) {
        for (let j = 0; j < novaSolucao.itens.length; j++) {
            if (novaSolucao.itens[j].nome == item.nome) {
                return j;
            }
        }
        return -1;
    }
}