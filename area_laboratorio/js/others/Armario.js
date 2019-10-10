class Armario {

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
    }

    static limparSelecaoArmario() {
        $('button[data-id]').each(function () {
            $(this).removeClass('objeto-selecionado');
        });

        $('.armario-lotado').hide();
        $('.armario-contador').text('0 selecionados');
    }

    static abrirArmario(a) {
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
        $('#armario').modal('hide');
    }

    // Adiciona a bancada os objetos selecionados
    static addItensSelecionadosScene() {
        console.log('Armario.addScene', 'Armario');

        var selecionados = Armario.getItensSelecionadosArmario();
        for (var i = 0; i < selecionados.length; i++) {

            var arg = DropZones.getOneDropZoneLivre();
            if(!arg){
                alert('Não há espaço disponível na bancada')
                return;
            }
            switch (selecionados[i].conceito) {
                case 'frasco_estoque':
                    var item = new Solucao(arg);
                    console.error('Solucao', 'Armario');
                    console.error(item, 'Armario');
                    SceneObjectsSLab.add(item);
                    break;

                default:
                    var item = new Pisseta(arg);
                    console.error('Pipeta', 'Armario');
                    console.error(item, 'Armario');
                    SceneObjectsSLab.add(item);
                    break;

            }
        }
        $('#armario').modal('hide');
    }

    /** pega os itens selecionados no armario */
    static getItensSelecionadosArmario() {
        var result = [];
        $('#armario .objeto-selecionado').each(function () {
            result.push({
                id: $(this).attr('data-id'),
                conceito: $(this).attr('data-type'),
            });
        });
        return result;
    }
}