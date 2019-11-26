class ObjetoDefault extends ObjetoDefaultEvents{
    gameobject = null;
    dropped = false;
    datadefault = null;
    
    constructor(data) {
        super();
        this.datadefault = data;
    }
    
    destroy() {
        SceneObjectsSLab.addIds();
        SceneObjectsSLab.deleteObjectId(this.id);
        this.gameobject.destroy();
        this.gameobject = null;
    }

    addSpriteScene(config) {
        var image = GAME_SCENE.make.sprite(config);
        this.gameobject = image;
        image.A_REF_CLASS = this;
    }

    insertInteractive(objeto_s, width=300, height=300) {
        if(objeto_s.type == "Container")
            objeto_s.setSize(width, height);

        objeto_s.setInteractive({ cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/hover.cur), pointer' });
        objeto_s.input.dropZone = false;
    }

    /* drag e drop para containers / são tipos diferentes de gameobject*/
    insertDragContainer(obj_container, width, height){
        obj_container.setSize(width, height);
        obj_container.A_REF_CLASS = this;
        obj_container.setTint = function(xy){
            for (let i = 0; i < obj_container.list.length; i++) {
                obj_container.list[0].setTint(xy);
            }
        };
        obj_container.clearTint = function(){
            for (let i = 0; i < obj_container.list.length; i++) {
                obj_container.list[0].clearTint();
            }
        };
        this.insertDrag(obj_container);
        this.gameobject = obj_container;
    }

    insertDrag(objeto_s) {
        objeto_s.setInteractive({ 
            cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/hover.cur), pointer',
            pixelPerfect: false,
            alphaTolerance: 1
        });
        GAME_SCENE.input.setDraggable(objeto_s);
        objeto_s.setScrollFactor(1);
        objeto_s.input.dropZone = true;

        //objeto_s._pd = true;
        //objeto_s.on('pointerdown', this.pointerdown);
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
    
    getTextPopOver(){
        return '';
    }

    setData(data_set){
        var classe = this;
        console.error(data_set, this.constructor.name);
        Object.keys(data_set).forEach(function (key) {
            classe[key] = data_set[key];
        });
    }
}