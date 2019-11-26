class Balao extends ObjetoDefaultVolume {
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
            key: 'balao_vazio',
            x: data.x,
            y: data.y
        };
        this.nome = data.nome;
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        this.gameobject.setOrigin(0.5, 0.9);
        console.log('addObject');
        this.gameobject.setScale(0.9);
    }

    changeTexture() {
        if (this.volume_atual > 0)
            this.gameobject.setTexture('balao_cheio');
        else
            this.gameobject.setTexture('balao_vazio');
    }
    
    getTextPopOver() {
        var txt = [];
        var txtc = this.textComposicao();
        txt = txt.concat(txtc);
        return txt;
    }
}