class Phmetro extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
        this.countUpdate=0;
        Debug.error('Phmetro.constructor', "Phmetro");
    }

    addObject(data) {
        /*
            var group = GAME_SCENE.add.group();
            group.add(TextopH);
        */

        this.container = GAME_SCENE.add.container(data.x, data.y);
        this.insertSprites();
        //inserindo textos
        this.insertTextos();

        var eletrodo = this.container.list[3];
        this.insertDragTeste(eletrodo);
        this.gameobject = eletrodo;
        eletrodo.ref_class = this;
        this.insertInteractive(this.gameobject);
    }
    
    /** depois deletar */
    insertDragTeste(elemento){
        elemento.on('drag', function(pointer, dragX, dragY){
            this.x = dragX;
            this.y = dragY;
            console.log('drag', this.x, this.y);
         });
        elemento.setInteractive({ cursor: 'url(' + URL_SITE + 'area_laboratorio/assets/cursors/pen.cur), pointer' });
        GAME_SCENE.input.setDraggable(elemento);
        elemento.setScrollFactor(1);
        elemento.input.dropZone = false;
    }

    insertSprites(){
        var container = this.container;
        var image3 = GAME_SCENE.add.sprite(244.12, -113.39, 'phmetro_braco');
        container.add(image3);

        var image4 = GAME_SCENE.add.sprite(307.12, 20.47, 'phmetro_frente');
        container.add(image4);

        var image1 = GAME_SCENE.add.sprite(0, 0, 'phmetro');
        container.add(image1);

        var eletrodo = GAME_SCENE.add.sprite(266.16, 152.76, 'eletrodo');
        container.add(eletrodo);

        this.graphics = GAME_SCENE.add.graphics({ lineStyle: { width: 5, color: 0x9e9e9e } });
        this.graphics.clear();
        container.add(this.graphics);
    }
    insertTextos(){
        var fonte = 'Open Sans Condensed';
        var TextopH = GAME_SCENE.add.text(-37.80, -102.37, '7.000' , { fontFamily: fonte, fontSize: 32, color: '#ffffff' });
        var TextoModo1 = GAME_SCENE.add.text(-122.84, -119.69, 'Modo: pH', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });
        var TextoModo2 = GAME_SCENE.add.text(-126, -67.72, '08/10/2019', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });  
        var TextoModo3 = GAME_SCENE.add.text(67.72, -119.69, '25º C', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });  
        var TextoModo4 = GAME_SCENE.add.text(-10, -66.14, 'CAL:', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });  

        this.container.add(TextopH);
        this.container.add(TextoModo1);
        this.container.add(TextoModo2);
        this.container.add(TextoModo3);
        this.container.add(TextoModo4);

        console.log('Container Phmetro',this.container.list);
    }

    updatePHVisor(){
        this.countUpdate = 0;
        var variacao = 0.2;
        var d = (Math.random() * variacao);
        this.container.list[5].text = (7 + d-variacao/2).toFixed(3);
    }

    updateEletrodo(){
        var image3 = this.container.list[0];
        var eletrodo = this.container.list[3];

        this.graphics.clear();
        this.graphics.beginPath();
        this.graphics.moveTo(image3.x+40, image3.y);
        this.graphics.lineTo(eletrodo.x, eletrodo.y-100);
        this.graphics.strokePath();
        this.graphics.closePath();
    }

    update(){
        this.countUpdate++;
        if(this.countUpdate > 100)
            this.updatePHVisor();
        
        this.updateEletrodo();
    }
}