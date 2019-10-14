class Pratica {
    static initPratica() {
        console.log("Pratica.initPratica");
        $.ajax({ url: URL_SITE + 'area_laboratorio/index-app.php?app=jogo&file=get-data-pratica-jogo&id_pratica=' + ID_PRATICA }).done(function (data) {
            PRATICA_DATA = data;
            Pratica.setTitlePage();
            ArmarioTabs.construirTabs(data);
            Pratica.setFilesAlunoRoteiro(data);
            Laboratorio.init();

            PracticeRegistration.register([{'desc': 'Carregou a pratica', 'data':null}]);
        });
        
        //funçoes boostrap modal, eventos
        $('#armario').on('hide.bs.modal', function (e) {Laboratorio.resume();});
        $('#interacao-1').on('hide.bs.modal', function (e) {Laboratorio.resume();});
        $('#animacao').on('hide.bs.modal', function (e) {Laboratorio.resume();});
        $('#interacao-2').on('hide.bs.modal', function (e) {Laboratorio.resume();});
    }

    static setTitlePage() {
        if (TIPO_ACESSO == 'treino')
            var texto = PRATICA_DATA.nome + ' (treinamento)';
        else
            var texto = PRATICA_DATA.nome;

        $('#titulopratica').text(texto);
    }

    //arquivos de roteiro/cadernos
    static setFilesAlunoRoteiro(dados) {
        var html_a = '';
        $.each(dados.arquivos.caderno, function (indexInArray, arquivo) {
            html_a += '<a target="_blank"  href="' + URL_SITE + arquivo.scr_img_moprar + '">Caderno didático </a> <br />';
        });

        $.each(dados.arquivos.roteiro, function (indexInArray, arquivo) {
            html_a += '<a target="_blank" href="' + URL_SITE + arquivo.scr_img_moprar + '">Roteiro da prática </a> <br />';
        });

        $('#info').popover({
            title: "Menu",
            content: html_a,
            html: true,
            trigger: 'manual'
        }).click(function (e) {
            $(this).popover('toggle');
            e.stopPropagation();
        });
    }

    static sairLaboratorio(tipo_usuario) {
        if (tipo_usuario == 1 || tipo_usuario == 2) {
            window.location = URL_SITE + 'area_professor/index.php';
        } else {
            window.location = URL_SITE + 'area_aluno/index.php';
        }
    }
}