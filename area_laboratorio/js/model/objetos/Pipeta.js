class Pipeta extends ObjetoDefaultVolume {
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
            key: 'pipeta',
            x: data.x,
            y: data.y
        };
        this.nome = data.nome;
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        //this.gameobject.setOrigin(-0.4, 0.5);
        console.log('addObject');
    }
/*
    changeTexture() {
        if (this.volume_atual > 0)
            this.gameobject.setTexture('pipeta_cheia');
        else
            this.gameobject.setTexture('pipeta_vazia');
    }
*/
    getTextPopOver() {
        var txt = [];
        var txtc = this.textComposicao();
        txt = txt.concat(txtc);
        return txt;
    }
}