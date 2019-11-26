class Espectrofotometro extends ObjetoDefault {
    countUpdate = 0;
    tampa_aberta = false;
    ligado = false;
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        //container
        this.container = GAME_SCENE.add.container(data.x, data.y);
        this.container.setScale(0.8);
        
        this.objetoPrincipal();
        this.insertTampa();
        this.insertTextos();
        this.changeTexture();
    }

    insertTextos() {
        var texto1 = GAME_SCENE.add.text(469.34, 62.27, 'Absorbância', { fontFamily: 'Arial', fontSize: 14, color: '#ffffff' });
        var texto2 = GAME_SCENE.add.text(527.62, 79.45, '', { fontFamily: 'Arial', fontSize: 22, color: '#ffffff' });
        texto1.setOrigin(0, 0);
        texto2.setOrigin(0, 0);
        this.container.add(texto1);
        this.container.add(texto2);
    }

    objetoPrincipal() {
        var container = this.container;
        var image = GAME_SCENE.add.sprite(60, 0, 'espectrofotometro');
        image.setOrigin(0, 0);
        image.A_REF_CLASS = this;
        container.add(image);
        this.insertInteractive(image);
        image.on('pointerdown', function () {
            this.A_REF_CLASS.foco = 'objeto';
            this.A_REF_CLASS.clickObject(image);
        });
    }

    insertTampa() {
        var container = this.container;
        var image = GAME_SCENE.add.sprite(143.3250, -192.1531, 'tampa_espectrofotometro_aberta');
        image.setOrigin(0, 0);
        image.A_REF_CLASS = this;
        container.add(image);
        image.visible = false;
    }

    changeTexture() {
        if (this.tampa_aberta) {
            this.container.list[1].visible = true;
        } else
            this.container.list[1].visible = false;

        if (this.ligado) {
            this.container.list[2].visible = true;
            this.container.list[3].visible = true;
        } else {
            this.container.list[2].visible = false;
            this.container.list[3].visible = false;
        }
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