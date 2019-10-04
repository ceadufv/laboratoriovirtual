class Pisseta extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject();
    }
    addObject() {
        //var sprite = GAME_SCENE.add.sprite(0, 0, 'pisseta');
        //this.gameobject = sprite;
        var config = {
            key: 'pisseta',
            x: 100,
            y: 100
        };
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        console.log('addObject');
    }
}