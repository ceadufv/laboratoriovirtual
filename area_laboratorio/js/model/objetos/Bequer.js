class Bequer extends ObjetoDefaultVolume {
    ambientado = false;
    volume_atual = 0;
    volume_max = 0;
    lavado = false;

    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        this.volume_max = parseFloat(data.volume);
        var config = {
            key: 'bequer_vazio',
            x: data.x,
            y: data.y
        };
        this.nome = data.nome;
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        this.gameobject.setOrigin(0.5, 0.9);
        console.log('addObject');
    }

    changeTexture() {
        if (this.volume_atual > 0)
            this.gameobject.setTexture('bequer_cheio');
        else
            this.gameobject.setTexture('bequer_vazio');
    }

    getTextPopOver() {
        var txt = [];
        var txtc = this.textComposicao();
        txt = txt.concat(txtc);
        return txt;
    }
}