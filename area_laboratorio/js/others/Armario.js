class Armario {

    static updateArmarioLugaresDisponiveis() {
        var selecionados = Armario.getItensSelecionadosArmario();
        var drops = DropZones.getZonesLivres();
        var qtd = drops.length - selecionados.length;
        var txt = 'lugares restantes na bancada';
        if(qtd < 1){
            txt = 'lugar restante na bancada';
        }
        $('.armario-disponiveis').text('('+qtd+' '+txt+')');
    }

    static armarioAtualizarSelecionados() {
        var selecionados = Armario.getItensSelecionadosArmario();
        var counter = selecionados.length;
        // Atualiza a indicacao de objetos selecionados
        var txt = counter + ' ';
        if (counter == 1)
            txt += 'selecionado';
        else
            txt += 'selecionados';
        $('.armario-contador').text(txt);
    }

    static selecionarItem(element) {
        if ($(element).hasClass('objeto-selecionado')) {
            $(element).removeClass('objeto-selecionado');
        } else {
            $(element).addClass('objeto-selecionado');
        }

        // Atualiza na tela o numero de objetos selecionados
        Armario.armarioAtualizarSelecionados();

        //atualiza quantidade de lugares disponiveis
        Armario.updateArmarioLugaresDisponiveis();
    }

    static limparSelecaoArmario() {
        $('button[data-id]').each(function () {
            $(this).removeClass('objeto-selecionado');
        });

        $('.armario-lotado').hide();
        $('.armario-contador').text('0 selecionados');
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

    // Adiciona a bancada os objetos selecionados
    static addItensSelecionadosScene() {
        console.log('Armario.addScene', 'Armario');

        var selecionados = Armario.getItensSelecionadosArmario();
        for (var i = 0; i < selecionados.length; i++) {
            var item_class = null;
            var item_atual = selecionados[i];
            var arg = DropZones.getOneDropZoneLivre();
            if (!arg) {
                alert('Não há espaço disponível na bancada')
                return;
            }

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
        $('#armario').modal('hide');
    }

    /** pega os itens selecionados no armario */
    static getItensSelecionadosArmario() {
        var result = [];
        $('#armario .objeto-selecionado').each(function () {
            var dados = JSON.parse($(this).attr('dados_json'));
            dados.id = $(this).attr('data-id');
            dados.conceito = $(this).attr('data-type');
            result.push(dados);
        });
        return result;
    }
}