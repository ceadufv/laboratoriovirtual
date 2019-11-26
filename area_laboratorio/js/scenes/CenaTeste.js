class CenaTeste extends Phaser.Scene {
    constructor(config) {
        super(config);
    }
    preload() {
        //pack
        //this.load.pack("pack_wel", "assets/itens/pipeta/pack.json");
        //this.load.animation('gemData', 'assets/animations/gems.json');
        this.load.atlas('pipeta_enchendo', 'assets/itens/pipeta/sprites.png', 'assets/itens/pipeta/sprites.json');
    }
    create() {
        GAME_SCENE = this;
        var pipeta = this.add.sprite(242.0, 217.0, 'pipeta_enchendo',"pipeta_enchendo_00.png");
        //objeto_teste_1.anims.play("enchendo");

        var frameNames = this.anims.generateFrameNames('pipeta_enchendo', {
            start: 0, 
            end: 99,
            prefix: 'pipeta_enchendo_', 
            zeroPad: 2,
            suffix: '.png'
        });
        this.anims.create({ 
            key: 'enchendo',
            frames: frameNames,
            frameRate: 12,
            repeat: 2
        });
        pipeta.setScale(3);
        pipeta.setOrigin(0);
        pipeta.anims.play('enchendo');
        console.log(frameNames);


    }
    update() {
        
    }
}