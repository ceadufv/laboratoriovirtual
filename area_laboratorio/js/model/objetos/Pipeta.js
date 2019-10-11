class Pipeta extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        var config = {
            key: 'pipeta',
            x: data.x,
            y: data.y
        };
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        console.log('addObject');
    }
}