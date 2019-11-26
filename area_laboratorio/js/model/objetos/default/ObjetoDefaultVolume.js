class ObjetoDefaultVolume extends ObjetoDefault {
    ambientado = false;
    volume_atual = 0;
    volume_max = 0;
    lavado = false;
    /**
    composicao[0].itens = []
    composicao[0].volume = 0.8
    */
    composicao = [];

    constructor(data) {
        super(data);
    }

    getComposicaoSimples() {
        return this.composicao[0];
    }

    padronizarComposicao(composicao, volume_atual) {
        var nova_composicao = [];

        if (composicao.length == 0)
            return nova_composicao;


        if (composicao[0].itens) {
            return composicao;
        } else {
            if (composicao)
                nova_composicao.push({ 'itens': composicao, 'volume': volume_atual });
        }
        return nova_composicao;
    }

    esvaziarVolume() {
        this.volume_atual = 0;
        this.lavado = false;
        this.ambientado = false;
        this.composicao = [];
        this.changeTexture();
    }

    removerVolume(volume) {
        var novo_volume = parseFloat(parseFloat(this.volume_atual) - parseFloat(volume));
        this.volume_atual = novo_volume.toFixed(4);
        this.changeTexture();
        this.lavado = false;
        this.removerVolumeSolucao(volume);
    }

    adicionarVolume(volume_colocado) {
        this.lavado = false;
        var novo_volume = parseFloat(parseFloat(this.volume_atual) + parseFloat(volume_colocado));
        this.volume_atual = novo_volume.toFixed(4);
        this.changeTexture();
    }

    /** mistura e atualiza o volume da solucao de acordo com o volume atual */
    updateVolumeSolucao() {
        this.misturar();
        if (this.composicao[0])
            this.composicao[0].volume = parseFloat(this.volume_atual);
    }

    /** mistura e remove o volume passado */
    removerVolumeSolucao(volume) {
        if (this.volume_atual <= 0) {
            this.composicao = this.padronizarComposicao([], 0);
            return;
        }

        this.misturar();
        if (this.composicao[0])
            this.composicao[0].volume = parseFloat(this.composicao[0].volume) - parseFloat(volume);
    }

    /**
     * 
     * @param {*} composicao {itens = [{id: "1", nome: "Ácido Forte", concentracao: 34.70970000000001}], volume = 0.8}
     * 
    */
    addComposicao(composicao) {
        this.composicao.push(composicao);
        this.misturar();
        this.balancearVolume();
    }

    /**
     * atualiza o volume atual de acordo com a composicao
     */
    balancearVolume() {
        if (this.composicao.length > 0)
            this.volume_atual = this.composicao[0].volume;
        else
            this.volume_atual = 0;
    }

    volumeAceito() {
        var vol_falta = parseFloat(parseFloat(this.volume_max) - parseFloat(this.volume_atual));
        return vol_falta.toFixed(2);
    }

    changeTexture() {
    }

    /** Mistura 2 composicoes ou mais */
    misturar() {
        this.parseFloatComposicao();
        var composicoes = this.composicao;
        var novaComposicao = null;
        console.log(composicoes);
        if (composicoes.length) {
            if (composicoes.length > 1)
                novaComposicao = MisturaSolucoes.misturarSolucoes(composicoes[0], composicoes[1]);
            else
                novaComposicao = composicoes[0];
        } else {

        }

        this.composicao = [];
        if (novaComposicao)
            this.composicao.push(novaComposicao);

        console.log('misturar().novaComposicao', novaComposicao);
    }

    /**
     * passa todos numeros para float
     */
    parseFloatComposicao() {
        var composicao = this.composicao;
        for (let i = 0; i < composicao.length; i++) {
            composicao[i].volume = parseFloat(composicao[i].volume);
            for (let j = 0; j < composicao[i].itens; j++) {
                composicao[i].itens[j].concentracao = parseFloat(composicao[i].itens[j].concentracao);
            }
        }
    }

    textComposicao() {
        const formatter = new Intl.NumberFormat('pt-br', {
            minimumFractionDigits: 2
        })

        var txt = [];
        if (this.volume_max)
            txt.push("Volume Máximo: " + formatter.format(this.volume_max) + ' mL');

        txt.push("----------");
        txt.push("Volume Atual: " + formatter.format(this.volume_atual) + ' mL');

        if (this.ambientado)
            txt.push("Ambientado: sim");
        else {
            txt.push("Ambientado: não");
        }

        if (this.lavado)
            txt.push("Lavado: sim");
        else {
            txt.push("Lavado: não");
        }

        var composicoes = this.composicao;
        if (this.composicao.length != 0) {
            if (composicoes.length) {
                txt.push("----------");
                txt.push("Composições");
                for (let i = 0; i < composicoes.length; i++) {
                    txt.push("----------");
                    txt.push("Número " + (i + 1));
                    txt.push("nome | concentração");
                    for (let j = 0; j < composicoes[i].itens.length; j++) {
                        txt.push(composicoes[i].itens[j].nome + " | " + formatter.format(composicoes[i].itens[j].concentracao) + ' mol/L');
                    }
                    txt.push("Volume: " + formatter.format(composicoes[i].volume) + ' mL');
                }
                txt.push("----------");
            }
        }
        return txt;
    }

}