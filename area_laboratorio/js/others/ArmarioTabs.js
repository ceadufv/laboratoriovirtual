
class ArmarioTabs {
    static construirItem(tab, item) {
        console.log('ArmarioTabs.construirItem', 'ArmarioTabs');
        console.log(item, 'ArmarioTabs');


        var dados_json = JSON.stringify(item);

        var botao = '';
        var class_opcao = '';
        var botao_qtd = '';
        if (item.disponivel == 'N') {
            botao = '';
            class_opcao = 'opcao-disabled';
        } else {
            botao = '<button ' + "dados_json='" + dados_json + "'" + ' data-type="' + item.conceito + '" data-id="' + item.id + '" type="button" class="btn btn-primary botao-elmentos" onClick="Armario.selecionarItem(this);">Selecionar</button>';
            botao_qtd = '<div class="s-quantidade"><small>Quantidade</small><br /><input type="number" value="0" max="'+item.qtd_maxima+'" min="0" /></div>';
            class_opcao = '';
        }

        $('#tab_' + tab + ' .caixas')
            .append(
                '<label disabled class="opcao ' + class_opcao + '" data-id="' + item.id + '">' +
                '<p>' + item.nome + '</p>' +
                '<img src="' + URL_SITE + 'area_laboratorio/assets/objetos/' + item.conceito + '.png" height="120px">' +
                botao +
                botao_qtd +
                '</label>'
            );
    }

    static construirVidraria(conceito, item) {
        item.conceito = conceito;
        //Adicionar vidrarias tab
        ArmarioTabs.construirItem('vidrarias', item)
    }

    static construirSolucao(conceito, item) {
        item.conceito = conceito;
        //Adicionar solucao tab
        ArmarioTabs.construirItem('solucoes', item)
    }

    static construirModal(data) {

        var dataArmario = [];
        var dados_armario_solucoes = data.data.armario_solucoes;
        var dados_armario_vidrarias = data.data.armario_vidrarias;
        var dados_balao = data.data.armario_vidrarias.balao;
        var dados_bequer = data.data.armario_vidrarias.bequer;
        var dados_pipeta = data.data.armario_vidrarias.pipeta;
        var dados_cubeta = data.data.armario_vidrarias.cubeta;
        var dados_pipetador = data.data.armario_vidrarias.pipetador;
        var dados_micropipeta = data.data.armario_vidrarias.micropipeta;

        for (var i = 0; i < dados_balao.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('balao', dados_balao[i]));

        for (var i = 0; i < dados_bequer.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('bequer', dados_bequer[i]));

        for (var i = 0; i < dados_pipeta.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('pipeta', dados_pipeta[i]));

        for (var i = 0; i < dados_cubeta.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('cubeta', dados_cubeta[i]));

        for (var i = 0; i < dados_micropipeta.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('micropipeta', dados_micropipeta[i]));

        for (var i = 0; i < dados_pipetador.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('pipetador', dados_pipetador[i]));

        for (var i = 0; i < dados_armario_solucoes.length; i++)
            dataArmario.push(ArmarioTabs.construirSolucao('solucao', dados_armario_solucoes[i]));
    }
}