class DebugObject{
    //DebugObject.debugGameObject()
    static debugGameObject(objeto){
        GAME_SCENE.input.enableDebug(objeto);
        var graphics = GAME_SCENE.add.graphics();
        graphics.fillGradientStyle(0xff0000, 0xff0000, 0x0000ff, 0x0000ff, 1);
        graphics.fillCircle(objeto.x, objeto.y, 5);
    }

    //DebugObject.insertDragDebug(objeto);
    static insertDragDebug(objeto, width=300, height=300) {
        this.debugGameObject(objeto);
        if(objeto.type == "Container"){
            objeto.setSize(width, height);
        }
        objeto.setInteractive({ cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/hover.cur), pointer' });
        GAME_SCENE.input.setDraggable(objeto);
        objeto.setScrollFactor(1);
        objeto.on('drag', function(pointer, dragX, dragY) {
            this.x = dragX;
            this.y = dragY;
            console.log('Drag Debug', dragX, ',', dragY);
        });
    }
}