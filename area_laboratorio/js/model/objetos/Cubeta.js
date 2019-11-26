class Cubeta extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        var config = {
            key: 'cubeta_vazia',
            x: data.x,
            y: data.y
        };
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
    }
}