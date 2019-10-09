class Interac_Phmetro_Pisseta {
    constructor() {
        console.error('Interac_Phmetro_Pisseta constructor');
    }
    init(objctInit, objctDrop) {
        return;

        //CLASS_INTERRACT_NOW = new Interac_Pisseta_Phmetro();
        //CLASS_INTERRACT_NOW.init(objctInit, objctDrop);

        //return;
        var x = objctDrop.gameobject.x;
        var y = objctDrop.gameobject.y;

        //objctDrop.destroy();
        var config = {
            key: 'explode',
            frames: GAME_SCENE.anims.generateFrameNumbers('ani_fire', { start: 0, end: 40 }),
            frameRate: 15,
            repeat: 0,
            //hideOnComplete: true
            //repeatDelay: 2,
        };
        GAME_SCENE.anims.create(config);
        var image3 = GAME_SCENE.add.sprite(GAME_SCENE.cameras.main.centerX, GAME_SCENE.cameras.main.centerY, 'ani_fire');
        image3.setOrigin(0.5, 0.5);
        image3.setScale(20);
        image3.anims.play('explode');
        alert(image3.x + ',' + image3.y);
        image3.on('animationcomplete', function () {
            image3.destroy();
        }, GAME_SCENE, this);

        /*
        var particles = GAME_SCENE.add.particles('ani_fire');
        var emitter = particles.createEmitter({
            speed: 10,
            scale: { start: 2, end: 0 },
            blendMode: 'ADD'
        });
        emitter.startFollow(image3);
        */

        //var drop = DropZones.getOneDropZoneLivre();
        var op = new Lenco({ x: x, y: y });
        SceneObjectsSLab.add(op);
    }
}