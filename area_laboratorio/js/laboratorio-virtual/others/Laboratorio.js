/** 
https://phaser.io/examples/v3/search?search=drag
preload 
https://phaser.io/examples/v3/view/input/dragging/drag-with-multiple-scenes
container
https://phaser.io/examples/v3/view/game-objects/container/draggable-container
//drop
https://phaser.io/examples/v3/view/input/zones/circular-drop-zone
*/
class Laboratorio {
    static init() {
        Debug.log('Laboratorio.init()', 'Laboratorio');

        var width = 2520;
        var height = 1080;
        PHASER_CONFIG = {
            type: Phaser.AUTO,
            width: width,
            height: height,
            parent: 'AreaJogo',
            plugins: {
                global: [{
                    key: 'GameScalePlugin',
                    plugin: Phaser.Plugins.GameScalePlugin,
                    mapping: 'gameScale',
                    data: {
                        debounce: false,
                        debounceDelay: 50,
                        maxHeight: Infinity,
                        maxWidth: Infinity,
                        minHeight: 0,
                        minWidth: 0,
                        mode: 'fit',
                        resizeCameras: true,
                        snap: null
                    }
                }]
            },
            physics: {
                default: 'arcade',
                arcade: {
                    gravity: { y: 0 },
                    debug: true
                }
                /*
                default: 'matter',
                matter: {
                    gravity: {
                        x: 0,
                        y: 0
                    }
                }
                */
            },
            scene: {
                preload: Laboratorio.preload,
                create: Laboratorio.create,
                update: Laboratorio.update
            }
        };
        PHASER_GAME = new Phaser.Game(PHASER_CONFIG);
    }

    static create() {
        GAME_SCENE = this;
        GAME_SCENE.input.setDefaultCursor('url(' + URL_SITE + 'area_laboratorio/assets/cursors/arrow.cur), pointer');
        LaboratorioDefault.addItensScene();
    }

    static update() {

        //update the objets
        var objetos = OBJETOS_LAB;
        for (var j = 0; j < objetos.length; j++) {
            if (objetos[j].update)
                objetos[j].update();
        }
    }

    static preload() {
        Debug.log('Laboratorio.preload', 'Laboratorio');
        this.load.setBaseURL(URL_SITE+'area_laboratorio/');

        this.load.image('background', 'assets/laboratorio/background.png');
        this.load.image('popup', 'assets/laboratorio/popup.png');

        //DEFAULT/ STATICS
        this.load.image('armario_solucoes', 'assets/laboratorio/gaveta-solucoes.png');
        this.load.image('armario_vidrarias', 'assets/laboratorio/gaveta-vidrarias.png');


        //DEFAULT // OBJETOS
        this.load.image('pia', 'assets/objetos/pia.png');

        //OBJETOS
        this.load.image('bequer', 'assets/objetos/bequer-vazio.png');
        this.load.image('bequer_frente', 'assets/objetos/bequer-frente.png');
        this.load.image('bequer_repouso', 'assets/objetos/bequer-repouso.png');
        this.load.image('bequer_vazio', 'assets/objetos/bequer-descarte.png');
        this.load.image('bequer_cheio', 'assets/objetos/bequer.png');
        this.load.image('bequer_cheio2', 'assets/objetos/bequer.png');
        this.load.image('cubeta', 'assets/objetos/cubeta.png');
        this.load.image('cubeta_cheia', 'assets/objetos/cubeta-cheia.png');
        this.load.image('eletrodo', 'assets/objetos/eletrodo.png');
        this.load.image('frasco', 'assets/objetos/frasco.png');
        this.load.image('frasco_estoque', 'assets/objetos/frasco_estoque.png');
        this.load.image('lenco', 'assets/objetos/lenco.png');
        this.load.image('objeto', 'assets/objetos/frasco.png');
        this.load.image('pipeta', 'assets/objetos/pipeta.png');
        this.load.image('micropipeta', 'assets/objetos/micropipeta.png');
        this.load.image('pipeta_pipetador', 'assets/objetos/pipeta-pipetador.png');
        this.load.image('pipetador', 'assets/objetos/pipetador.png');
        this.load.image('balao', 'assets/objetos/balao.png');
        this.load.image('phmetro', 'assets/objetos/phmetro.png');
        this.load.image('phmetro_braco', 'assets/objetos/phmetro-braco.png');
        this.load.image('phmetro_frente', 'assets/objetos/phmetro-frente.png');
        this.load.image('pisseta', 'assets/objetos/pisseta.png');
        this.load.image('espectrofotometro', 'assets/objetos/espectrofotometro2.png');
        this.load.image('tampa_espectrofotometro', 'assets/objetos/tampa_espectrofotometro.png');
        
        //SPRITE
        this.load.spritesheet('ani_fire', 'assets/animations/fire/explosion_3_40_128.png',  { frameWidth: 128, frameHeight: 128, endFrame: 40 });

        //DROPZONES
        this.load.image('drop_zone', 'assets/dropzone/movel.png');
        this.load.image('drop_zone_hover', 'assets/dropzone/movel-hover.png');
    }

}