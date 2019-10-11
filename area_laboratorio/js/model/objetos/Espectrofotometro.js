class Espectrofotometro extends ObjetoDefault {
    countUpdate = 0;
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        this.container = GAME_SCENE.add.container(data.x, data.y);
        this.objetoPrincipal();
        this.insertTampa();
        this.insertTextos();
    }

    insertTextos() {
        var texto1 = GAME_SCENE.add.text(1864.8, 280.35, 'Absorbância', { fontFamily: 'Arial', fontSize: 14, color: '#ffffff' });
        var texto2 = GAME_SCENE.add.text(1924.65, 300.82, '', { fontFamily: 'Arial', fontSize: 22, color: '#ffffff' });
        this.container.add(texto1);
        this.container.add(texto2);
        //texto1.visible = false;
        //texto2.visible = false;
    }

    objetoPrincipal() {
        var container = this.container;
        var image = GAME_SCENE.add.sprite(1814.82,443.77, 'espectrofotometro');
        image.A_REF_CLASS = this;
        container.add(image);
        this.insertInteractive(image);
        image.on('pointerdown', function(){
            this.A_REF_CLASS.foco = 'objeto';
            this.A_REF_CLASS.clickObject(image);
        });
        this.gameobject = image;
    }

    insertTampa() {
        var container = this.container;
        var image = GAME_SCENE.add.sprite(1630.15,257.92, 'tampa_espectrofotometro');
        image.A_REF_CLASS = this;
        container.add(image);
        this.insertInteractive(image);
        image.on('pointerdown', function(){
            this.A_REF_CLASS.foco = 'tampa';
            this.A_REF_CLASS.clickObject(image);
        });
    }
    
    updatePHVisor() {
        this.countUpdate = 0;
        this.container.list[3].text = QuimicaFormulas.calcularVariacao(0.072, 0.02);
    }

    update() {
        this.countUpdate++;
        if (this.countUpdate > 100)
            this.updatePHVisor();
    }
}