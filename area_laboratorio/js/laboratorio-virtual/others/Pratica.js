class Pratica {
    static initPratica() {
        console.log("Pratica.initPratica");
        $.ajax({ url: URL_SITE + 'area_laboratorio/index-app.php?app=jogo&file=get-data-pratica-jogo&id_pratica=' + id_pratica }).done(function (data) {
            PRATICA_DATA = data;
            ArmarioTabs.construirModal(data);
            Pratica.setFilesAlunoRoteiro(data);
            Laboratorio.init();
        });
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