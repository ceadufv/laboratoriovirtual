class ConceptCreate {

    //ConceptCreate.criar(conceito, item_atual);
    static criar(conceito, item_atual) {
        var objCreate = null;
        switch (conceito) {
            case 'solucao':
                objCreate = new Frasco(item_atual);
                break;

            case 'frasco':
                objCreate = new Frasco(item_atual);
                break;

            case 'balao':
                objCreate = new Balao(item_atual);
                break;

            case 'micropipeta':
                objCreate = new Micropipeta(item_atual);
                break;

            case 'bequer':
                objCreate = new Bequer(item_atual);
                break;

            case 'bequer_repouso':
                objCreate = new BequerRepouso(item_atual);
                break;

            case 'pipeta':
                objCreate = new Pipeta(item_atual);
                break;

            case 'cubeta':
                objCreate = new Cubeta(item_atual);
                break;

            case 'pipetador':
                objCreate = new Pipetador(item_atual);
                break;

            case 'micropipeta':
                objCreate = new Micropipeta(item_atual);
                break;

            case 'ponteira':
                objCreate = new Ponteira(item_atual);
                break;

            case 'phmetro':
                item_atual.x = 1810;
                item_atual.y = 510;
                objCreate = new Phmetro(item_atual);
                break;

            case 'espectrofotometro':
                item_atual.x = 1498.525;
                item_atual.y = 355.06938;
                objCreate = new Espectrofotometro(item_atual);
                break;
                
            case 'pipeta_pipetador':
                objCreate = new PipetaPipetador(item_atual);
                break;

            case 'pia':
                objCreate = new Pia(item_atual);
                break;
            case 'lenco':
                objCreate = new Lenco(item_atual);
                break;

            case 'pisseta':
                objCreate = new Pisseta(item_atual);
                break;

            case 'descarte':
                objCreate = new Descarte(item_atual);
                break;

            case 'micropipeta_ponteira':
                objCreate = new MicropipetaPonteira(item_atual);
                break;
        }

        if (objCreate) {
            console.warn(objCreate, item_atual);
            SceneObjectsSLab.add(objCreate);
        }else{
            console.error('Objeto Com Erro ou não encontrado', item_atual);
        }

        return objCreate;
    }
}