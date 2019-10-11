class Espectrofotometro extends ObjetoDefault {
    constructor(data) {
        super(data);
        this.addObject(data);
    }

    addObject(data) {
        this.container = GAME_SCENE.add.group(data.x, data.y);
        this.objetoPrincipal();
        this.insertTampa();
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
        var classe = this;
        image.on('pointerdown', function(){
            this.A_REF_CLASS.foco = 'tampa';
            this.A_REF_CLASS.clickObject(image);
        });
    }
}