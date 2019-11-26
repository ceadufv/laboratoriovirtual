class ArmarioTabs {
    static construirItem(tab, item) {
        console.log('ArmarioTabs.construirItem', item);

        if (item.qtd_maxima == undefined)
            item.qtd_maxima = 1;

        var dados_json = JSON.stringify(item);

        var botao = '';
        var class_opcao = '';
        var botao_qtd = '';


        if (item.disponivel == 'N') {
            botao = '';
            class_opcao = 'opcao-disabled';
            botao_qtd = '<small>Não disponível</small>';
        } else {
            botao_qtd += '<div class="input-group number-spinner">';
            botao_qtd += '<div>';
            botao_qtd += '<button class="btn btn-default btn-info number-subtract" type="buttom">';
            botao_qtd += '<span><i class="fa far fa-minus"></i></span>';
            botao_qtd += '</button>';
            botao_qtd += '</div>';
            let attr_dados_json = "dados_json='" + dados_json + "'";
            botao_qtd += '<input disabled ' + attr_dados_json + ' data-type="' + item.conceito + '" data-id="' + item.id + '" type="text" class="form-control text-center number-input number-input-objeto" value="0" val-default="' + item.qtd_maxima + '" max="' + item.qtd_maxima + '" min="0" />';
            botao_qtd += '<div>';
            botao_qtd += '<button class="btn btn-default btn-info  number-add">';
            botao_qtd += '<span><i class="fa fas fa-plus"></i></span>';
            botao_qtd += '</button>';
            botao_qtd += '</div>';
            botao_qtd += '</div>'
            class_opcao = '';
        }


        $('#' + tab + '-content .caixas')
            .append(
                '<div class="opcao ' + class_opcao + '" data-id="' + item.id + '">' +
                '<p class="title-element">' + item.nome + '</p>' +
                '<img src="' + URL_SITE + 'area_laboratorio/assets/objetos/armario/' + item.conceito + '.png" height="120px">' +
                botao +
                botao_qtd +
                '</div>'
            );
    }

    static construirTabs(data) {

        var baloes = data.armario.baloes;
        var bequers = data.armario.bequers;
        var pipetas = data.armario.pipeta_volumetrica;
        var micropipetas = data.armario.micropipetas;
        var cubetas = data.armario.cubetas;
        var pipetadores = data.armario.pipetadores;
        var solucoes = data.armario.solucoes;
        var frascos = data.armario.frascos;
        var ponteiras = data.armario.ponteiras;

        for (var i = 0; i < baloes.length; i++)
            ArmarioTabs.construirItem('baloes', baloes[i]);

        for (var i = 0; i < bequers.length; i++) {
            ArmarioTabs.construirItem('bequers', bequers[i]);
        }

        for (var i = 0; i < pipetas.length; i++)
            ArmarioTabs.construirItem('pipetas', pipetas[i]);

        for (var i = 0; i < cubetas.length; i++) {
            cubetas[i].conceito = 'cubeta';
            ArmarioTabs.construirItem('cubetas', cubetas[i]);
        }

        for (var i = 0; i < micropipetas.length; i++)
            ArmarioTabs.construirItem('micropipetas', micropipetas[i]);

        for (var i = 0; i < pipetadores.length; i++) {
            pipetadores[i].conceito = 'pipetador';
            ArmarioTabs.construirItem('pipetadores', pipetadores[i]);
        }

        for (var i = 0; i < solucoes.length; i++) {
            solucoes[i].conceito = 'solucao';
            ArmarioTabs.construirItem('solucoes', solucoes[i]);
        }

        for (var i = 0; i < frascos.length; i++) {
            ArmarioTabs.construirItem('frascos', frascos[i]);
        }

        for (var i = 0; i < ponteiras.length; i++) {
            ArmarioTabs.construirItem('ponteiras', ponteiras[i]);
        }

        //somente se professor
        if (TIPO_USUARIO == 2 || TIPO_USUARIO == 3) {
            var json_prof = ArmarioTabs.getJsonProfessor();
            for (var i = 0; i < json_prof.length; i++) {
                ArmarioTabs.construirItem('professor', json_prof[i]);
            }
        }

    }
    static getJsonProfessor() {
        var objetos = [];
        objetos.push({
            conceito: "phmetro",
            disponivel: "S",
            id: 5345,
            nome: "Phmetro",
            qtd_maxima: "1",
        });
        objetos.push({
            conceito: "espectrofotometro",
            disponivel: "S",
            id: 54564,
            nome: "Espectrofotometro",
            qtd_maxima: "1",
        });
        objetos.push({
            conceito: "pia",
            disponivel: "S",
            id: 542134,
            nome: "Pia",
            qtd_maxima: "1",
        });
        objetos.push({
            nome: "Bequer Repouso",
            conceito: "bequer_repouso",
            id: 23123,
            qtd_maxima: "10"
        });
        objetos.push({
            nome: "Descarte",
            conceito: "descarte",
            id: 123345,
            qtd_maxima: "10"
        });
        objetos.push({
            nome: "Lenço",
            conceito: "lenco",
            id: 12356754,
            qtd_maxima: "10"
        });
        return objetos;
    }
}