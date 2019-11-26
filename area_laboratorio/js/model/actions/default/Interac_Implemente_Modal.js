class Interac_Implemente_Modal {
    openModal() {
        for (let i = 0; i < GAME_SCENE.children.list.length; i++) {
            GAME_SCENE.children.list[i].visible = false;
        }

        let classe = this;
        var container_box = GAME_SCENE.add.container(0, 0);

        var bg2 = GAME_SCENE.add.sprite(0, 0, 'box_default_bg_opac');
        bg2.setOrigin(0, 0);

        var bg = GAME_SCENE.add.sprite(0, 0, 'box_default_bg');
        bg.setOrigin(0, 0);


        //BTN CONFIRM
        var confirm = GAME_SCENE.add.sprite(1784.31, 932.29, 'box_default_confirm');
        confirm.setOrigin(0);
        confirm.setScale(1);
        confirm.alpha = 1;
        confirm.setInteractive({
            cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/hover2.gif), pointer',
            pixelPerfect: true,
            alphaTolerance: 1
        });
        confirm.on('pointerdown', function (pointer) {
            classe.clickConfirm();
        });
        confirm.on('pointerover', function (pointer) {
            this.alpha = 0.9;
        });
        confirm.on('pointerout', function (pointer) {
            this.alpha = 1;
        });

        //BTN CLOSE
        var close = GAME_SCENE.add.sprite(2119.789, 930.7248, 'box_default_cancel');
        close.setOrigin(0);
        close.setScale(1);
        close.alpha = 1;
        close.setInteractive({
            cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/hover2.gif), pointer',
            pixelPerfect: true,
            alphaTolerance: 1
        });
        close.on('pointerdown', function (pointer) {
            GAME_SCENE.sound.play('a_click1');
            classe.closeNow();
        });
        close.on('pointerover', function (pointer) {
            this.alpha = 0.9;
        });
        close.on('pointerout', function (pointer) {
            this.alpha = 1;
        });

        container_box.add([bg2, bg, close, confirm]);
        this.container_box = container_box;
    }

    closeNow() {
        this.container.destroy();
        this.container_box.destroy();
        for (let i = 0; i < GAME_SCENE.children.list.length; i++) {
            GAME_SCENE.children.list[i].visible = true;
        }
    }

    clickConfirm() {

    }

    /**retorn ml total
     * retorna a quantidade que deve jogar a mais para cair
     * na marca do frame
     * @var marcaMarca que frame que está a marca
     * @var ml = quantos ml
     * @returns total de ml com o objeto transbordando
     */
    calculaFrameMlSobra(marcaMarca, ml) {
        return (100 * ml) / marcaMarca;
    }

    /**
     * calcula quantos m/l foi pego de acordo com o frame
     * cada frame tem pesos iguais
     * @param {*} total_frame total de frame da animacao
     * @param {*} atual frame atual
     * @param {*} ml_total  total com todos frames
     * @returns m/l total que contem no objeto
     */
    calcFrameMl(total_frame, atual, ml_total) {
        let final;
        let percentFrame = (atual * 100) / total_frame;
        final = (ml_total * percentFrame) / 100;
        return final;
    }
}