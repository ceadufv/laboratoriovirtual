class Armario {

    /* 
    Esconde todos objetos que não existe mais quantidade para pegar
    quantidade atual/max = 0
    Armario.hideEmpty();
    */
    static hideQdtEmpty() {
        $('#armario .number-input-objeto').each(function () {
            var max = $(this).attr('max');
            if (max <= 0) {
                $(this).closest('.opcao').append('<small>Não disponível</small>');
                $(this).closest('.opcao').addClass('opcao-disabled');
                $(this).closest('.number-spinner').remove();
            }
        });
    }

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
        Armario.hideQdtEmpty();
        // Limpa a selecao atual nos armarios
        Armario.limparSelecaoArmario();
        $('#armario').modal('show');
    }

    static fecharArmario() {
        Laboratorio.resume();
        $('#armario').modal('hide');
    }

    static updateMaxItem(ele, qtd) {
        //setando o input para maximo que se pode pegar do item
        $(ele).attr('max', $(ele).attr('max') - qtd);
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
                this.updateMaxItem(item_atual.this_ele, 1);
                console.log('this.updateMaxItem');

                item_atual.x = arg.x;
                item_atual.y = arg.y;
                ConceptCreate.criar(item_atual.conceito, item_atual);

            }
            delete item_atual.this_ele;
        }
        $('#armario').modal('hide');
        PRATICA_POPOVER.toFront(); //manda popup pra frente
    }
}