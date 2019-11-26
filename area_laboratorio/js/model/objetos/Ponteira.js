class Ponteira extends ObjetoDefaultVolume {
    ambientado = false;
    volume_atual = 0;
    volume_max = 0;
    lavado = false;

    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        var config = {
            key: 'ponteira',
            x: data.x,
            y: data.y
        };
        this.nome = data.nome;
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        this.gameobject.setOrigin(0.5, 0.9);
        console.log('addObject');
    }

    getTextPopOver() {
        var txt = [];
        var txtc = this.textComposicao();
        txt = txt.concat(txtc);
        return txt;
    }
}