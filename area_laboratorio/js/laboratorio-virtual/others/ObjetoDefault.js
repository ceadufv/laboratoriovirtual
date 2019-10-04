class ObjetoDefault {
    /*
        https://phaser.io/examples/v3/search?search=drag
        preload 
        https://phaser.io/examples/v3/view/input/dragging/drag-with-multiple-scenes
        container
        https://phaser.io/examples/v3/view/game-objects/container/draggable-container
        //drop
        https://phaser.io/examples/v3/view/input/zones/circular-drop-zone
    */
    constructor(data) {
        this.dice = data;
        this.tala = 'beleza'
        this.gameobject = null;
        this.dropped = false;
    }
    destroy(gameObject) {
        gameObject.destroy();
        this.gameobject = null;
    }

    limparGameObject(obj, dropZone){
        this.dropped = false;
        this.dropZone = null;
        obj.clearTint();
        dropZone.zone_sprite.clearTint();
    }

    insertDrag(obj1) {
        obj1.setInteractive({ cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/pen.cur), pointer' });
        GAME_SCENE.input.setDraggable([obj1]);
        obj1.setScrollFactor(1);

        obj1.on('pointerover', function () {
            obj1.setTint(0x44ff44);
        });
        obj1.on('pointerout', function () {
            obj1.clearTint();
        });

        obj1.on('drag', function (pointer, dragX, dragY) {
            obj1.x = dragX;
            obj1.y = dragY;
        });

        obj1.on('dragstart', function (pointer) {
            obj1.setTint(0xff0000);
        });

        obj1.on('dragend', function (pointer) {
            if (!this.dropped) {
                obj1.x = obj1.input.dragStartX;
                obj1.y = obj1.input.dragStartY;
            }
            this.limparGameObject(obj1, null);
        });

        obj1.on('gameobjectover', function (pointer) {
            obj1.setTint(0x00ff00);
        });

        obj1.on('gameobjectout', function (pointer) {
            obj1.clearTint();
        });

        obj1.on('dragenter', function (pointer, dropZone) {
            dropZone.zone_sprite.setTint(0x00ff00);
            console.log('dragenter');
        });

        obj1.on('dragleave', function (pointer, dropZone) {
            console.log('dragleave');
            this.limparGameObject(obj1, dropZone);
        });

        obj1.on('drop', function (pointer, dropZone) {

            dropZone.ocupado = true;
            console.log('drop');
            obj1.x = dropZone.zone_sprite.x;
            obj1.y = dropZone.zone_sprite.y - (obj1.height / 4);
            if(dropZone.ocupado){
                console.log('Local Ocupado');
                this.limparGameObject(obj1, dropZone);
            }else{
                this.dropZone = dropZone;
                this.dropped = true;
                this.dropZone.ocupado = true;
            }
        });
    }

    addSpriteScene(config) {
        var image1 = GAME_SCENE.make.sprite(config);
        this.gameobject = image1;
    }
}