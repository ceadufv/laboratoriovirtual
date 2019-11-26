class BoxAnimacaoPipetaPipetador extends Interac_Implemente_Modal {
    volume_final = 0;
    interact = null;
    max_vol_trans = 0;
    min_vol_trans = 0;
    estado = 'aspirando'
    volume_total = 10;

    init(interact) {
        this.interact = interact;

        //montando o BOX
        this.openModal();

        var classe = this;
        var pipetador = GAME_SCENE.add.sprite(1200, 200, 'pipetador');
        pipetador.setOrigin(0);

        var objeto_animacao = GAME_SCENE.add.sprite(1183, 340, 'pipeta_enchendo', "pipeta_enchendo_00.png");
        var bequer = GAME_SCENE.add.sprite(1234.25, 1003.15, "bequer_cheio");
        var text = GAME_SCENE.add.text(100, 200, '', { fontFamily: 'Arial', fontSize: 64, color: '#000000' });

        objeto_animacao.setOrigin(0, 0);
        objeto_animacao.setScale(1.5);
        objeto_animacao.setInteractive();
        objeto_animacao.anims.play("pipeta_enchendo");
        objeto_animacao.anims.stop();

        objeto_animacao.on('animationupdate', function (currentAnim, currentFrame, sprite) {
            classe.recalculaMaxVolume();
            classe.recalculaMinVolume();

            text.text = parseFloat(classe.volume_final).toFixed(3)+' m/L';
        });
        objeto_animacao.on('animationrepeat', function (currentAnim, currentFrame, sprite) { });
        objeto_animacao.on('animationcomplete', function (currentAnim, currentFramee, sprite) { });
        objeto_animacao.on('animationrestart', function (currentAnim, currentFrame, sprite) { });
        objeto_animacao.on('animationstart', function (currentAnim, currentFrame, sprite) { });
        objeto_animacao.on('pointerdown', function () {
            objeto_animacao.anims.stop();
        });
        this.objeto_animacao = objeto_animacao;

        var container_ani = GAME_SCENE.add.container(0, -120);
        this.container = container_ani;
        container_ani.add([text, objeto_animacao, pipetador, bequer]);
        container_ani.setScale(1);
        this.liberar();
        this.sugar();
        this.parar();
       
        /*
        //Minimap
        var minimap = GAME_SCENE.cameras.add(450, 25, 300, 1040).setName('mini');
        minimap.setBackgroundColor(0x002244);
        minimap.scrollX = 1100;
        minimap.scrollY = 30;
        minimap.ignore(bequer);
        minimap.setZoom(1.5);
        minimap.inputEnabled = false;
        console.log('tap', minimap);
        //GAME_SCENE.cameras.remove(minimap);
        */
    }


    checkMaxVolume() {
        if (this.max_vol_trans < this.volume_final) {
            return false;
        }
        return true;
    }


    calculaAnimFrameMl() {
        var currentFrame = this.objeto_animacao.anims.currentFrame;
        var currentAnim = this.objeto_animacao.anims.currentAnim;
        var volAnim = this.calcFrameMl(currentAnim.frames.length, currentFrame.index, this.calculaFrameMlSobra(70, 10));
        if (currentFrame.index == 1)
            volAnim = 0;
        console.log('volAnim', volAnim);
        return volAnim;
    }

    recalculaMaxVolume() {
        //verificar isso segunda
        var classe = this;
        var objeto_animacao = this.objeto_animacao;
        var first = true;

        while (!this.checkMaxVolume() || first) {
            first = false;
            var volume_final = this.calculaAnimFrameMl();
            classe.volume_final = volume_final;

            if (!this.checkMaxVolume()) {
                objeto_animacao.anims.stop();
                objeto_animacao.anims.previousFrame();
            }
            console.log('recalculaMaxVolume', 'max:', classe.max_vol_trans, 'vol:', this.volume_final);
        }
        console.log('Recalculado', 'max:', classe.max_vol_trans, 'vol:', this.volume_final);
        return true;
    }

    checkMinVolume() {
        if (this.volume_final < this.min_vol_trans) {
            return false;
        }
        return true;
    }

    recalculaMinVolume() {
        var classe = this;
        var objeto_animacao = this.objeto_animacao;
        var first = true;

        while (!this.checkMinVolume() || first) {
            first = false;
            var volume_final = this.calculaAnimFrameMl();
            classe.volume_final = volume_final;
            if (!this.checkMinVolume()) {
                objeto_animacao.anims.stop();
                objeto_animacao.anims.nextFrame();
            }
            console.log('recalculaMinVolume', 'min:', classe.min_vol_trans, 'vol:', this.volume_final);
        }
        console.log('Recalculado', 'min:', classe.min_vol_trans, 'vol:', this.volume_final);
        return true;
    }

    clickConfirm() {
        console.log('clickConfirm', this.volume_final);
        if (this.estado == 'aspirando') {
            this.interact.sugarLiquido(this.volume_final);
        } else {
            var volume_tirado = this.max_vol_trans - this.volume_final;
            this.interact.liberarLiquido(volume_tirado);
        }



        this.closeNow();
    }

    changeTextureAnim() {
        var volume_final;
        var classe = this;
        var objeto_animacao = this.objeto_animacao;
        objeto_animacao.anims.setProgress(0);
        volume_final = this.calculaAnimFrameMl();
        while (this.volume_final > volume_final) {
            volume_final = this.calculaAnimFrameMl();
            if (this.volume_final == volume_final) {
                break;
            }
            objeto_animacao.anims.nextFrame();
        }
    }

    setVolumeAtual(vol) {
        this.volume_final = vol;
        this.changeTextureAnim();
    }
    setMaxVolumeTrans(max_vol_trans) {
        this.max_vol_trans = max_vol_trans;
    }

    setMinVolumeTrans(min_vol_trans) {
        this.min_vol_trans = min_vol_trans;
    }

    liberar() {
        var objeto_animacao = this.objeto_animacao;
        var liberarPipeta = GAME_SCENE.add.sprite(1240, 230, 'liberar');
        liberarPipeta.setScale(0.6);
        liberarPipeta.setInteractive({
            cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/hover2.gif), pointer',
            pixelPerfect: false,
            alphaTolerance: 1
        });
        liberarPipeta.on('pointerdown', function (pointer) {
            objeto_animacao.anims.stop('pipeta_enchendo');
            var currentFrame = objeto_animacao.anims.currentFrame;
            console.log('liberar', currentFrame.index, objeto_animacao.anims.currentFrame);
            if (!currentFrame.isFirst) {
                objeto_animacao.anims.playReverse('pipeta_enchendo', true, currentFrame.index - 1);
            }

            this.setTint(0x565653);
        });
        liberarPipeta.on('pointerup', function (pointer) {
            objeto_animacao.anims.stop('pipeta_enchendo');
            this.clearTint();
        });
        this.container.add([liberarPipeta]);
    }

    parar() {
        //console.log('clickparar');
        //objeto_animacao.anims.stop('pipeta_enchendo');
    }

    sugar() {
        var classe = this;
        var objeto_animacao = this.objeto_animacao;
        var sugarPipeta = GAME_SCENE.add.sprite(1280, 340, 'aspirar');
        sugarPipeta.setScale(0.6);
        sugarPipeta.setInteractive({
            cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/hover2.gif), pointer',
            pixelPerfect: false,
            alphaTolerance: 1
        });
        sugarPipeta.on('pointerdown', function (pointer) {
            if (!classe.checkMaxVolume()) {
                return false;
            }

            this.setTint(0x565653);
            console.log('sugarPipeta');
            var isPlaying = objeto_animacao.anims.isPlaying;
            var currentFrame = objeto_animacao.anims.currentFrame;
            console.log(currentFrame);
            objeto_animacao.anims.stop('pipeta_enchendo');
            if (!currentFrame.isLast) {
                objeto_animacao.anims.play('pipeta_enchendo', true, currentFrame.index);
            };

        });
        sugarPipeta.on('pointerup', function (pointer) {
            objeto_animacao.anims.stop('pipeta_enchendo');
            this.clearTint();
        });
        this.container.add([sugarPipeta]);
    }
}