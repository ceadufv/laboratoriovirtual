class BequerRepouso extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        var config = {
            key: 'bequer_repouso',
            x: data.x,
            y: data.y
        };
        this.addSpriteScene(config);
        this.gameobject.setOrigin(0.5, 0.95);
        this.insertDrag(this.gameobject);
    }

    //tirando o drag
    /*drag(){

    }*/
}