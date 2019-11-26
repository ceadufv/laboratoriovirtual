class Pratica {
    static initPratica() {
        console.log("Pratica.initPratica");
        $.ajax({ url: URL_SITE + 'area_laboratorio/index-app.php?app=jogo&file=get-data-pratica-jogo&id_pratica=' + ID_PRATICA }).done(function (data) {
            PRATICA_DATA = data;
            Pratica.setTitlePage();
            ArmarioTabs.construirTabs(data);
            Pratica.setFilesAlunoRoteiro(data);
            Laboratorio.init();
            PracticeRegistration.register([{ 'desc': 'Carregou a pratica', 'data': null }]);
        });

        //funçoes boostrap modal, eventos
        $('#armario').on('hide.bs.modal', function (e) { Laboratorio.resume(); });
        $('#interacao-1').on('hide.bs.modal', function (e) { Laboratorio.resume(); });
        $('#animacao').on('hide.bs.modal', function (e) { Laboratorio.resume(); });
        $('#interacao-2').on('hide.bs.modal', function (e) { Laboratorio.resume(); });
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

    /** screen */
    static clickBtnFullScreen() {
        if (GAME_SCENE.scale.isFullscreen) {
            this.closeFullscreen();
            // On stop fulll screen
            $('.btn-expand').html('<i class="fas fa-expand"></i> Expandir');
        } else {
            this.openFullscreen();
            $('.btn-expand').html('<i class="fas fa-expand"></i> Minimizar');
            // On start fulll screen
        }
    }

    static openUnlockcreen() {
        screen.orientation.unlock();
    }
    
    static openLandscapescreen() {
        if (window.matchMedia("(orientation: landscape)").matches) {
            this.openUnlockcreen();
            return;
        }

        this.openFullscreen();
        screen.orientation.lock("landscape-primary").then(function () { }).catch(function (error) { console.error(error); });
    }

    /* Close fullscreen */
    static closeFullscreen() {
        GAME_SCENE.scale.stopFullscreen();
        return;

        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) { /* Firefox */
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { /* IE/Edge */
            document.msExitFullscreen();
        }
    }

    static openFullscreen() {
        GAME_SCENE.scale.fullscreenTarget = document.getElementById('full-screen-html');
        GAME_SCENE.scale.startFullscreen();
        return;

        if (document.fullscreen) {
            this.closeFullscreen();
            return;
        }
        var elem = document.querySelector("html");
        if (elem.requestFullscreen) {
            elem.requestFullscreen().then(function () { console.log('requestFullscreen'); })
                .catch(function (error) { console.log(error); });;
        } else if (elem.mozRequestFullScreen) { /* Firefox */
            elem.mozRequestFullScreen().then(function () { console.log('mozRequestFullScreen'); })
                .catch(function (error) { console.log(error); });;
        } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
            elem.webkitRequestFullscreen().then(function () { console.log('webkitRequestFullscreen'); })
                .catch(function (error) { console.log(error); });;
        } else if (elem.msRequestFullscreen) { /* IE/Edge */
            elem.msRequestFullscreen().then(function () { console.log('msRequestFullscreen'); })
                .catch(function (error) { console.log(error); });;;
        }
    }
}