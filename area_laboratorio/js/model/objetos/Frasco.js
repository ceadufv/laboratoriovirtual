class Frasco extends ObjetoDefaultVolume {
    container = null;
    volume_atual = 0;
    volume_max = 0;
    etiqueta = '';
    composicao = [];
    lavado = false;
    ambientado = false;

    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        var conf = {
            x: data.x,
            y: data.y,
            'key': 'frasco_cheio'
        }

        this.volume_atual = data.volume_atual;
        this.volume_max = data.volume_max;
        this.composicao = this.padronizarComposicao(data.composicao, data.volume_atual);
        this.addSpriteScene(conf);
        this.insertDrag(this.gameobject);
        this.gameobject.setOrigin(0.5, 0.9);
        this.changeTexture();
    }

    changeTexture() {
        if (this.volume_atual > 0) {
            this.gameobject.setTexture('frasco_cheio');
        } else {
            this.gameobject.setTexture('frasco_vazio');
        }
    }

    getTextPopOver() {
        var txt = [];
        if (this.etiqueta)
            txt.push("Rotulo: " + this.etiqueta);

        var txtc = this.textComposicao();
        txt = txt.concat(txtc);

        return txt;
    }
}