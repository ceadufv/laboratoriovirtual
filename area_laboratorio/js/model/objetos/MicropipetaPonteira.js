class MicropipetaPonteira extends ObjetoDefaultVolume {
    ambientado = false;
    volume_atual = 0;
    volume_max = 0;
    volume_min = 0;
    lavado = false;

    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        console.log(data);
        this.volume_max = parseFloat(data.volume_max);
        this.volume_min = parseFloat(data.volume_min);
        var config = {
            key: 'micropipeta_ponteira_vazia',
            x: data.x,
            y: data.y
        };
        this.nome = data.nome;
        this.addSpriteScene(config);
        this.insertDrag(this.gameobject);
        this.gameobject.setScale(1);
        console.log('addObject');
    }

    changeTexture(){
        this.gameobject.setTexture('micropipeta_ponteira_cheia'); //nova textura
    }
  
    /*
    removerVolume(volume) {
        var novo_volume = parseFloat(parseFloat(this.volume_atual) - parseFloat(volume));
        this.volume_atual = novo_volume.toFixed(4);
        this.changeTexture();
    }
    */
    
    getTextPopOver() {
        var txt = [];
     //   txt.push("Volume Máximo: " + this.volume_max + "mL");
     //   txt.push("Volume Atual: " + this.volume_atual + "mL");
        
        var textoComposicao = this.textComposicao();
        txt = txt.concat(textoComposicao);

        if (this.ambientado)
            txt.push("Micropipeta com ponteira ambientada");
        else {
            txt.push("Micropipeta com ponteira vazia");
        }


        if (this.lavado)
            txt.push("lavada: sim");
        else {
            txt.push("lavada: não");
        }
        return txt;
    }    
}