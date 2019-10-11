class Bequer extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.data_item = data;
        this.addObject(data);
    }

    addObject(data) {
        var config = {
            key: 'bequer',
            x: data.x,
            y: data.y
        };
        this.nome = data.nome;
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        console.log('addObject');
    }
}