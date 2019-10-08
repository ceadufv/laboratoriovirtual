
class ArmarioTabs {
    static construirItem(tab, item) {
        Debug.log('ArmarioTabs.construirItem', 'ArmarioTabs');
        Debug.log(item, 'ArmarioTabs');
        
        var botao, class_opcao;
        if (item.disponivel == 'N') {
            botao = '';
            class_opcao = 'opcao-disabled';
        } else {
            botao = '<button data-type="' + item.conceito + '" data-id="' + item.id + '" type="button" class="btn btn-dark m-3 botao" onClick="Armario.selecionarItem(this);">Selecionar</button>';
            class_opcao = '';
        }

        // Se for cubeta, no armário ela aparece maior (exceção)
        if (item.conceito == 'cubeta') {
            $('#tab_' + tab + ' .caixas')
                .append(
                    '<label class="opcao ' + class_opcao + '" data-id="' + item.id + '">' +
                    '<input type="checkbox" style="display:none" value="' + item.id + '" />' +
                    '<p>' + item.nome + '</p>' +
                    '<img src="' + URL_SITE + 'area_laboratorio/assets/objetos/cubeta-armario.png" height="120px">' +
                    botao +
                    '</label>'
                );
        } else {
            $('#tab_' + tab + ' .caixas')
                .append(
                    '<label disabled class="opcao ' + class_opcao + '" data-id="' + item.id + '">' +
                    '<input type="checkbox" style="display:none" value="' + item.id + '" />' +
                    '<p>' + item.nome + '</p>' +
                    '<img src="' + URL_SITE + 'area_laboratorio/assets/objetos/' + item.conceito + '.png" height="120px">' +
                    botao +
                    '</label>'
                );
        }
    }

    static construirVidraria(conceito, nome, item) {
        item.conceito = conceito;
        item.nome = nome;
        //Adicionar vidrarias tab
        ArmarioTabs.construirItem('vidrarias', item)
    }

    static construirSolucao(conceito, nome, item) {
        item.conceito = conceito;
        item.nome = nome;

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
            dataArmario.push(ArmarioTabs.construirVidraria('balao', 'Balão', dados_balao[i]));

        for (var i = 0; i < dados_bequer.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('bequer', 'Béquer', dados_bequer[i]));

        for (var i = 0; i < dados_pipeta.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('pipeta', 'Pipeta', dados_pipeta[i]));

        for (var i = 0; i < dados_cubeta.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('cubeta', 'Cubeta', dados_cubeta[i]));

        for (var i = 0; i < dados_micropipeta.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('micropipeta', 'Micropipeta', dados_micropipeta[i]));

        for (var i = 0; i < dados_pipetador.length; i++)
            dataArmario.push(ArmarioTabs.construirVidraria('pipetador', 'Pipetador', dados_pipetador[i]));

        for (var i = 0; i < dados_armario_solucoes.length; i++)
            dataArmario.push(ArmarioTabs.construirSolucao('frasco_estoque', 'frasco_estoque', dados_armario_solucoes[i]));
    }
}