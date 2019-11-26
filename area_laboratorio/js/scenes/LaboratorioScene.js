class LaboratorioScene extends Phaser.Scene {
    
    constructor(config) {
        super(config);

    }
    init(data) {
        console.log('LaboratorioScene.init');
    }

    create(data) {
        this.cameras.main.setBackgroundColor('#b8b7a7');
        console.log('LaboratorioScene.create');
        GAME_SCENE = this;
        this.createAnimations();
        //GAME_SCENE.input.setDefaultCursor('url(' + URL_SITE + 'area_laboratorio/assets/cursors/arrow.cur), pointer');
        LaboratorioDefault.addItensScene();
    }

    preload() {
        console.log('LaboratorioScene.preload');
        this.load.setBaseURL(URL_SITE + 'area_laboratorio/');

        //audios
        this.load.audio('a_open', 'assets/audio/open.mp3');
        this.load.audio('a_drop_glass', 'assets/audio/drop-glass.mp3');
        this.load.audio('a_click1', 'assets/audio/click1.mp3');
        this.load.audio('a_click2', 'assets/audio/click2.mp3');
        this.load.audio('a_pop', 'assets/audio/pop.wav');
        this.load.audio('a_open_porta', 'assets/audio/porta_open.wav');
       
        this.load.image('liberar', 'assets/itens/pipeta/image/liberar.png');
        
        this.load.image('aspirar', 'assets/itens/pipeta/image/aspirar.png');
        this.load.image('parar', 'assets/itens/pipeta/image/parar.png');

        this.load.image('background', 'assets/laboratorio/background.png');
        this.load.image('popup', 'assets/laboratorio/popup.png');

        //BOX
        this.load.image('box_default_bg', 'assets/itens/box-modal/default/bg.png');
        this.load.image('box_default_close', 'assets/itens/box-modal/default/close.png');
        this.load.image('box_default_confirm', 'assets/itens/box-modal/default/btn_confirmar.png');
        this.load.image('box_default_cancel', 'assets/itens/box-modal/default/btn_cancel.png');
        this.load.image('box_default_close_over', 'assets/itens/box-modal/default/close_over.png');
        this.load.image('box_default_bg_opac', 'assets/itens/box-modal/default/bg_opac.png');

        //DEFAULT/ STATICS
        this.load.image('bancada_armario', 'assets/laboratorio/bancada_armario.png');
        //this.load.image('armario_vidrarias', 'assets/laboratorio/gaveta-vidrarias.png');


        //DEFAULT // OBJETOS
        this.load.image('pia', 'assets/objetos/pia.png');

        //OBJETOS
        //bequer
        this.load.image('bequer_vazio', 'assets/objetos/bequer_vazio.png');
        this.load.image('bequer_frente', 'assets/objetos/bequer_frente.png');
        this.load.image('bequer_repouso', 'assets/objetos/bequer_repouso.png');
        this.load.image('bequer_cheio', 'assets/objetos/bequer_cheio.png');


        //descarte
        this.load.image('descarte', 'assets/objetos/descarte.png');

        //ponteira
        this.load.image('ponteira', 'assets/objetos/ponteira.png');

        //cubeta
        this.load.image('cubeta_vazia', 'assets/objetos/cubeta_vazia.png');
        this.load.image('cubeta_cheia', 'assets/objetos/cubeta_cheia.png');

        //balao
        this.load.image('balao_vazio', 'assets/objetos/balao_vazio.png');
        this.load.image('balao_cheio', 'assets/objetos/balao_cheio.png');

        //frasco
        this.load.image('frasco_cheio', 'assets/objetos/frasco_cheio.png');
        this.load.image('frasco_vazio', 'assets/objetos/frasco_vazio.png');

        this.load.image('lenco', 'assets/objetos/lenco.png');

        //pipeta
        this.load.image('pipeta', 'assets/itens/pipeta/image/pipeta.png');
        this.load.atlas('pipeta_enchendo', 'assets/itens/pipeta/animations/enchendo/sprites.png', 'assets/itens/pipeta/animations/enchendo/sprites.json');
        
        this.load.image('micropipeta', 'assets/objetos/micropipeta.png');
        this.load.image('micropipeta_ponteira_vazia', 'assets/objetos/micropipeta_ponteira_vazia.png');
        this.load.image('micropipeta_ponteira_cheia', 'assets/objetos/micropipeta_ponteira_cheia.png');

        this.load.image('pipeta_pipetador', 'assets/objetos/pipeta_pipetador.png');
        this.load.image('pipetador', 'assets/objetos/pipetador.png');


        this.load.image('pisseta_cheia', 'assets/objetos/pisseta_cheia.png');

        //phmetro
        this.load.image('btn_config_phmetro', 'assets/itens/phmetro/image/btn_config_phmetro.png');
        this.load.image('btn_emv_phmetro', 'assets/itens/phmetro/image/btn_emv_phmetro.png');
        this.load.image('btn_ph_phmetro', 'assets/itens/phmetro/image/btn_ph_phmetro.png');
        
        this.load.image('phmetro', 'assets/itens/phmetro/image/phmetro.png');
        this.load.image('phmetro_braco', 'assets/itens/phmetro/image/phmetro_braco.png');
        this.load.image('phmetro_frente', 'assets/itens/phmetro/image/phmetro_frente.png');
        this.load.image('eletrodo', 'assets/itens/phmetro/image/eletrodo.png');

        //espectrofotometro
        this.load.image('espectrofotometro', 'assets/objetos/espectrofotometro2.png');
        this.load.image('tampa_espectrofotometro_aberta', 'assets/objetos/tampa_espectrofotometro_aberta.png');

        //SPRITE
        this.load.spritesheet('ani_fire', 'assets/itens/fire/sprite/explosion_3_40_128.png', { frameWidth: 128, frameHeight: 128, endFrame: 40 });

        //DROPZONES
        this.load.image('drop_zone', 'assets/dropzone/movel.png');
        this.load.image('drop_zone_hover', 'assets/dropzone/movel-hover.png');
    }

    createAnimations(){
        console.log('createAnimations');
        var frameNames = GAME_SCENE.anims.generateFrameNames('pipeta_enchendo', {
            start: 0, 
            end: 99,
            prefix: 'pipeta_enchendo_', 
            zeroPad: 2,
            suffix: '.png'
        });
        //console.log('frameNames', frameNames);
        GAME_SCENE.anims.create({ 
            key: 'pipeta_enchendo',
            frames: frameNames,
            frameRate: 12,
            repeat: 0
        });
    }

    update(t, delta) {
        //update the objets
        var objetos = OBJETOS_LAB;
        for (var j = 0; j < objetos.length; j++) {
            if (objetos[j].update)
                objetos[j].update();
        }
    }
}