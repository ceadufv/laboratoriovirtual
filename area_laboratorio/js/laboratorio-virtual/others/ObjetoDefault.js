/*
     https://phaser.io/examples/v3/search?search=drag
     preload 
     https://phaser.io/examples/v3/view/input/dragging/drag-with-multiple-scenes
     container
     https://phaser.io/examples/v3/view/game-objects/container/draggable-container
     //drop
     https://phaser.io/examples/v3/view/input/zones/circular-drop-zone
 */
class ObjetoDefault {
    constructor(data) {
        this.dice = data;
        this.gameobject = null;
        this.dropped = false;
        this.classe = this;
    }

    destroy() {
        this.gameobject.destroy();
        this.gameobject = null;
    }

    addSpriteScene(config) {
        var image1 = GAME_SCENE.make.sprite(config);
        this.gameobject = image1;
        image1.ref_class = this;
    }

    insertInteractive(objeto_s) {
        objeto_s.setInteractive({ cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/pen.cur), pointer' });
        //objeto_s.setScrollFactor(0);
        //objeto_s.input.dropZone = false;
    }

    insertDrag(objeto_s) {
        objeto_s.setInteractive({ cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/pen.cur), pointer' });
        GAME_SCENE.input.setDraggable(objeto_s);
        objeto_s.setScrollFactor(1);
        objeto_s.input.dropZone = true;

        //objeto_s._pd = true;
        //objeto_s.on('pointerdown', LabHandler.onPointerOver);
        //objeto_s.on('pointerover', LabHandler.onPointerOver);
        //objeto_s.on('pointerout', LabHandler.onPointerOut);

        objeto_s.on('pointerover', this.pointerover);
        objeto_s.on('pointerout', this.pointerout);

        objeto_s.on('gameobjectover', this.gameobjectover);
        objeto_s.on('gameobjectout', this.gameobjectout);

        objeto_s.on('drag', this.drag);
        objeto_s.on('dragstart', this.dragstart);
        objeto_s.on('dragend', this.dragend);
        objeto_s.on('dragenter', this.dragenter);
        objeto_s.on('dragleave', this.dragleave);
        objeto_s.on('drop', this.drop);
    }

    pointerover() {
        var objeto_s = this;
        objeto_s.setTint(0x44ff44);
    }

    pointerout() {
        var objeto_s = this;
        objeto_s.clearTint();
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

        Debug.error('drop', 'ObjetoDefault');


        var objeto_s = this;
        this.click = false;
        this.drop = true;

        Debug.error(dropZone, 'ObjetoDefault');
        Debug.error(objeto_s, 'ObjetoDefault');

        if (dropZone.type == 'Zone') { //se tipo dropZone
            dropZone.refClass.normal();
            /*
            if(dropZone.refClass.getOcupado()){
                objeto_s.x = objeto_s.input.dragStartX;
                objeto_s.y = objeto_s.input.dragStartY;
            }else{
                dropZone.refClass.setOcupado(true);
                objeto_s.x = dropZone.refClass.x;
                objeto_s.y = dropZone.refClass.y;
            }*/
            objeto_s.x = dropZone.refClass.x;
            objeto_s.y = dropZone.refClass.y;
        } else { //se tipo outro objeto
            dropZone.setTint(0x000000);
            objeto_s.setTint(0x00ff00);
            objeto_s.x = objeto_s.input.dragStartX;
            objeto_s.y = objeto_s.input.dragStartY;
        }

        Debug.error(dropZone.ref_class, 'ObjetoDefault');
        Debug.error(objeto_s.ref_class, 'ObjetoDefault');

        try {
            Debug.warn('Interração', 'ObjetoDefault');
            var class_str = 'new Interac_' + dropZone.ref_class.constructor.name + '_' + objeto_s.ref_class.constructor.name + '()';
            Debug.log('class_str', 'ObjetoDefault');
            Debug.log(class_str, 'ObjetoDefault');
            CLASS_INTERRACT_NOW = eval(class_str);
            CLASS_INTERRACT_NOW.init(objeto_s.ref_class, dropZone.ref_class);
            Debug.log('SET CLASS_INTERRACT_NOW', 'ObjetoDefault');
            Debug.log(CLASS_INTERRACT_NOW, 'ObjetoDefault');
        } catch (e) {
            Debug.error('Classe não definida!!!', 'ObjetoDefault');
            Debug.error(class_str, 'ObjetoDefault');
            console.error('Error-ObjectDefault ', e);
        }
        DropZones.ckeckUsado();
    }

    dragleave(pointer, dropZone) {
        Debug.log('dragleave', 'ObjetoDefault');
        Debug.log(dropZone, 'ObjetoDefault');
        if (dropZone.type == 'Zone') {
            dropZone.refClass.normal();
        } else {
            dropZone.clearTint();
        }
    }

    drag(pointer, dragX, dragY) {
        this.x = dragX;
        this.y = dragY;
        
        Debug.log('drag', 'ObjetoDefault');
        Debug.log(this.x, 'ObjetoDefault');
        Debug.log(this.y, 'ObjetoDefault');
    }

    dragend(pointer) {
        Debug.log('dragend', 'ObjetoDefault');
        //se tiver na mesma posição
        //e click tiver ativado
        if (this.input.dragStartX == this.x && this.click) {
            Debug.log('Click', 'ObjetoDefault');
        }

        if (!this.drop) { //se não dropou em nada
            this.x = this.input.dragStartX;
            this.y = this.input.dragStartY;
        }
    }
    dragenter(pointer, dropZone) {
        Debug.log('dragenter', 'ObjetoDefault');
        Debug.log(dropZone, 'ObjetoDefault');
        if (dropZone.type == 'Zone') {
            dropZone.refClass.hover();
        } else {
            dropZone.setTint(0x000000);
        }
    }
    dragstart(pointer, gameObject) {
        Debug.log('dragstart', 'ObjetoDefault');
        Debug.log(this, 'ObjetoDefault');
        this.click = true;
        this.drop = false;
        this.setTint(0xff0000);
        for (var i = 0; i < OBJETOS_LAB.length; i++) {
            OBJETOS_LAB[i].gameobject.input.dropZone = true;
        }
        this.input.dropZone = false;
    }
}