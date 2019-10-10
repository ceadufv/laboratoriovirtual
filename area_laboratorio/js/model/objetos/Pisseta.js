class Pisseta extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        //var sprite = GAME_SCENE.add.sprite(0, 0, 'pisseta');
        //this.gameobject = sprite;
        var config = {
            key: 'pisseta',
            x: data.x,
            y: data.y
        };
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        //console.log('addObject');
    }
}