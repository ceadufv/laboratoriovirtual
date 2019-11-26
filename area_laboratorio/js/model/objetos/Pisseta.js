class Pisseta extends ObjetoDefaultVolume {
    volume_atual = 100;
    volume_max = 100;

    constructor(data) {
        super(data);
        this.addObject(data);
    }
    
    addObject(data) {
        var config = {
            key: 'pisseta_cheia',
            x: data.x,
            y: data.y
        };
        this.addSpriteScene(config);
        this.gameobject.setOrigin(0.5, 0.90)
        this.insertDrag(this.gameobject);
        //DebugObject.debugGameObject(this.gameobject);
    }

    /*
    removerVolume(volume) {
        var novo_volume = parseFloat(parseFloat(this.volume_atual) - parseFloat(volume));
        this.volume_atual = novo_volume.toFixed(4);
    }
    */

    getTextPopOver() {
        var txt = [];
        txt.push("Volume máximo: " + this.volume_max);
        txt.push("Volume Atual: " + this.volume_atual);
        return txt;
    }
}