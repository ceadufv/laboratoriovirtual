/**
 * eventos do phaser
 */
class ObjetoDefaultEvents {
    /** quando somento clica no objeto */
    clickObject(objeto) {
        InterractObject.callInterractOne(objeto.A_REF_CLASS);
        GAME_SCENE.sound.play('a_pop');
    }

    pointerdown(){
        console.log('pointerdown', this);
    }

    pointerover(pointer, localX, localY, event) {
        var objeto_s = this;
        objeto_s.setTint(0xeada11);

        if (this.A_REF_CLASS.getTextPopOver()) {
            PRATICA_POPOVER.setText(this.A_REF_CLASS.getTextPopOver());
            PRATICA_POPOVER.setVisible(true);
        }
    }

    pointerout() {
        var objeto_s = this;
        objeto_s.clearTint();
        PRATICA_POPOVER.setVisible(false);
    }

    gameobjectover(pointer) {
        var objeto_s = this;
        objeto_s.setTint(0x00ff00);
    }

    gameobjectout(pointer) {
        var objeto_s = this;
        objeto_s.clearTint();
    }

    drop(pointer, dropZone) {
        GAME_SCENE.sound.play('a_click2');

        console.error('drop', 'ObjetoDefault');
        var objeto_s = this;
        this.click = false;
        this.drop = true;
        
        if (dropZone.type == 'Zone') { //se tipo dropZone
            dropZone.A_REF_CLASS.normal();
            objeto_s.x = dropZone.A_REF_CLASS.x;
            objeto_s.y = dropZone.A_REF_CLASS.y;

            if(objeto_s.type=="Container"){ //se for container
                objeto_s.y = dropZone.A_REF_CLASS.y-(objeto_s.width/2);
            }
            
        } else { //se tipo outro objeto
            dropZone.clearTint();
            objeto_s.x = objeto_s.input.dragStartX;
            objeto_s.y = objeto_s.input.dragStartY;
        }

        console.warn(dropZone, objeto_s);
        if (dropZone.type != 'Zone') { //se tipo dropZone
            InterractObject.callInterractDuo(objeto_s.A_REF_CLASS, dropZone.A_REF_CLASS);
        } else {
            console.warn('É dropZone');
        }
        
        console.warn(dropZone.A_REF_CLASS, objeto_s.A_REF_CLASS);
        DropZones.ckeckUsado();
    }

    dragleave(pointer, dropZone) {
        console.log('dragleave', 'ObjetoDefault');
        console.log(dropZone, 'ObjetoDefault');
        if (dropZone.type == 'Zone') {
            dropZone.A_REF_CLASS.normal();
        } else {
            dropZone.clearTint();
        }
    }

    drag(pointer, dragX, dragY) {
        this.x = dragX;
        this.y = dragY;
        console.log('drag', dragX, dragY, pointer);
    }

    dragend(pointer) {
        console.log(this, 'dragend');
        //se tiver na mesma posição
        //e click tiver ativado
        if (this.input.dragStartX == this.x && this.click) {
            this.A_REF_CLASS.clickObject(this);
        }

        if (!this.drop) { //se não dropou em nada
            this.x = this.input.dragStartX;
            this.y = this.input.dragStartY;
        }
    }
    dragenter(pointer, dropZone) {
        console.log('dragenter', dropZone);
        if (dropZone.type == 'Zone') {
            dropZone.A_REF_CLASS.hover();
        } else {
            dropZone.setTint(0x7b7878);
        }
    }

    dragstart(pointer) {
        //jogar pra frente
        console.log('dragstart', this);
        GAME_SCENE.children.bringToTop(this);
        this.click = true;
        this.drop = false;
        this.setTint(0x45b1e4);
        SceneObjectsSLab.setDropZone(true);
        this.input.dropZone = false;
    }
}