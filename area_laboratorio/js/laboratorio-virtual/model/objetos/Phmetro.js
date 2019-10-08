class Phmetro extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {

        var container = GAME_SCENE.add.container(data.x, data.y);

        var image3 = GAME_SCENE.add.sprite(244.12, -113.39, 'phmetro_braco');
        container.add(image3);
        this.image3 = image3;

        var image4 = GAME_SCENE.add.sprite(307.12, 20.47, 'phmetro_frente');
        container.add(image4);

        var image1 = GAME_SCENE.add.sprite(0, 0, 'phmetro');
        container.add(image1);

        var eletrodo = GAME_SCENE.add.sprite(266.16, 152.76, 'eletrodo');
        container.add(eletrodo);
        this.eletrodo = eletrodo;

        //var line = new Phaser.Geom.Line(100, 500, 700, 100);
        this.graphics = GAME_SCENE.add.graphics({ lineStyle: { width: 5, color: 0x9e9e9e } });
        this.graphics.clear();
        container.add(this.graphics);

        var asdasd = eletrodo;
        asdasd.on('drag', this.drag);
        asdasd.setInteractive({ cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/pen.cur), pointer' });
        GAME_SCENE.input.setDraggable(asdasd);
        asdasd.setScrollFactor(1);
        asdasd.input.dropZone = false;

        this.gameobject = eletrodo;
        eletrodo.ref_class = this;
        this.insertInteractive(this.gameobject);
        //this.addSpriteScene(config);
    }
    
    update(){
        this.graphics.clear();
        this.graphics.beginPath();
        this.graphics.moveTo(this.image3.x+40, this.image3.y);
        this.graphics.lineTo(this.eletrodo.x, this.eletrodo.y-100);
        this.graphics.strokePath();
        this.graphics.closePath();
    }
}