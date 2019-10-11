class Pipetador extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        var config = {
            key: 'pipetador',
            x: data.x,
            y: data.y
        };
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        console.log('addObject');
    }
}