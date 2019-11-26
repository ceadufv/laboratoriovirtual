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
        config.x = 2330;
        config.y = 240;
        this.addSpriteScene(config);
        this.insertInteractive(this.gameobject);
        this.gameobject.setScale(0.9);
    }
}