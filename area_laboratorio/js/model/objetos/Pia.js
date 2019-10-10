class Pia extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        var config = {
            key: 'pia',
            x: data.x,
            y: data.y
        };
        this.addSpriteScene(config);
        this.insertInteractive(this.gameobject);
    }
}