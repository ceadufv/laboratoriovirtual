class Descarte extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        var config = {
            key: 'descarte',
            x: data.x,
            y: data.y
        };
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        this.gameobject.setOrigin(0.5, 0.9);
    }
}