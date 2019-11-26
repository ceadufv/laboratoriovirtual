/** 
https://phaser.io/examples/v3/search?search=drag
preload 
https://phaser.io/examples/v3/view/input/dragging/drag-with-multiple-scenes
container
https://phaser.io/examples/v3/view/game-objects/container/draggable-container
//drop
https://phaser.io/examples/v3/view/input/zones/circular-drop-zone

https://rexrainbow.github.io/phaser3-rex-notes/docs/site/touchevents/

https://rexrainbow.github.io/phaser3-rex-notes/docs/site/container/
*/
class Laboratorio {
    static init() {
        console.log('Laboratorio.init()');
        PHASER_CONFIG = {
            "title": "NeoAlice",
            type: Phaser.AUTO,
            width: 2520,
            height: 1080,
            parent: 'area_jogo'
        };
        PHASER_GAME = new Phaser.Game(PHASER_CONFIG);
        PHASER_GAME.scene.add("LaboratorioScene", LaboratorioScene, true);
        //PHASER_GAME.scene.add("CenaTeste", CenaTeste, true);
    }

    static pause() {
        GAME_SCENE.scene.pause();
    }

    static resume() {
        GAME_SCENE.scene.resume();
    }
}