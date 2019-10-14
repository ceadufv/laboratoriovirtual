class Armario {
    static limparSelecaoArmario() {
        $('#armario .number-input-objeto').each(function () {
            $(this).val('0');
        });
        Armario.updateInterface();
        return true;
    }

    static updateInterface() {
        // Atualiza na tela o numero de objetos selecionados
        Armario.armarioAtualizarSelecionados();

        //atualiza quantidade de lugares disponiveis
        Armario.updateArmarioLugaresDisponiveis();
    }

    static updateArmarioLugaresDisponiveis() {
        var counter = Armario.calcularQuantidadeSelecionada();
        var drops = DropZones.getZonesLivres();
        var qtd = drops.length - counter;
        var txt = 'lugares restantes na bancada';
        if (qtd < 1) {
            txt = 'lugar restante na bancada';
        }
        $('.armario-disponiveis').text('(' + qtd + ' ' + txt + ')');
    }

    static armarioAtualizarSelecionados() {
        var counter = Armario.calcularQuantidadeSelecionada();
        // Atualiza a indicacao de objetos selecionados
        var txt = counter + ' ';
        if (counter == 1)
            txt += 'selecionado';
        else
            txt += 'selecionados';
        $('.armario-contador').text(txt);
    }

    static calcularQuantidadeSelecionada() {
        var selecionados = Armario.getItensSelecionadosArmario();
        var counter = 0;
        for (let i = 0; i < selecionados.length; i++) {
            counter += parseInt(selecionados[i].sele_qtd);
        }
        return counter;
    }

    static abrirArmario(a) {
        Laboratorio.pause();

        // Limpa a selecao atual nos armarios, para comodidade do usuario
        Armario.limparSelecaoArmario();

        switch (a) {
            case "armario_solucoes":
                $('#solucoes-tab').tab('show');
                break;
            case "armario_vidrarias":
                $('#vidrarias-tab').tab('show');
                break;
        }

        // Atualiza a indicacao na GUI de que nao ha nada selecionado no momento
        //armarioAtualizarSelecionados(0);
        $('#armario').modal('show');
    }

    static fecharArmario() {
        Laboratorio.resume();
        $('#armario').modal('hide');
    }

    static updateMaxItem(ele){
        //setando o input para maximo que se pode pegar do item
        $(ele).attr('max', $(ele).attr('max') - 1);
    }

    // Adiciona a bancada os objetos selecionados
    static addItensSelecionadosScene() {
        console.log('Armario.addScene', 'Armario');

        var selecionados = Armario.getItensSelecionadosArmario();
        for (var i = 0; i < selecionados.length; i++) {
            var item_class = null;
            var item_atual = selecionados[i];

            for (var j = 0; j < item_atual.sele_qtd; j++) {

                var arg = DropZones.getOneDropZoneLivre();
                if (!arg) {
                    alert('Não há espaço disponível na bancada')
                    return;
                }
                
                //update max de item
                this.updateMaxItem(item_atual.this_ele);
                delete item_atual.this_ele;
                
                item_atual.x = arg.x;
                item_atual.y = arg.y;

                switch (item_atual.conceito) {
                    case 'solucao':
                        item_class = new Solucao(item_atual);
                        break;

                    case 'balao':
                        item_class = new Balao(item_atual);
                        break;

                    case 'micropipeta':
                        item_class = new Micropipeta(item_atual);
                        break;

                    case 'bequer':
                        item_class = new Bequer(item_atual);
                        break;

                    case 'pipeta':
                        item_class = new Pipeta(item_atual);
                        break;

                    case 'cubeta':
                        item_class = new Cubeta(item_atual);
                        break;

                    case 'pipetador':
                        item_class = new Pipetador(item_atual);
                        break;

                    case 'micropipeta':
                        item_class = new Micropipeta(item_atual);
                        break;

                    default:
                        alert('Objeto Com Erro ou não encontrado, ' + item_atual.conceito);
                        item_class = null;
                        break;

                }

                if (item_class) {
                    console.warn(item_class, item_atual);
                    SceneObjectsSLab.add(item_class);
                }
            }
        }
        $('#armario').modal('hide');
    }

    /** pega os itens selecionados no armario */
    static getItensSelecionadosArmario() {
        console.log('getItensSelecionadosArmario');
        var result = [];
        $('#armario .number-input-objeto').each(function () {
            var sele_qtd = $(this).val();
            if (sele_qtd > 0) {
                var dados = JSON.parse($(this).attr('dados_json'));
                dados.id = $(this).attr('data-id');
                dados.conceito = $(this).attr('data-type');
                dados.sele_qtd = sele_qtd;
                dados.this_ele = this,
                    result.push(dados);
            }
        });
        console.log(result);
        return result;
    }
}