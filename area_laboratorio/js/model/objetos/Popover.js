class Popover{
    constructor(data) {
        this.addObject(data);
    }

    addObject(data) {
        this.container = GAME_SCENE.add.container(2020, 200);
        var image = GAME_SCENE.add.sprite(0,0, 'popup');
        image.setOrigin(0,0);
        this.container.add(image);
        this.insertTextos();
    }

    insertTextos() {
        var texto = GAME_SCENE.add.text(
            40, 80, 'Texto', 
            { fontFamily: 'Arial', fontSize: 20, color: '#000000' }
        ).setPadding(0).setOrigin(0,0);
        this.container.add(texto);
        
        var cabecalho = GAME_SCENE.add.text(
            170, 40, 'INFORMAÇÕES', 
            { fontFamily: 'Arial', fontSize: 25, color: '#000000' }
        ).setPadding(0).setOrigin(0,0);
        this.container.add(cabecalho);
    
        this.container.visible = false;
    }

    toFront(){
        GAME_SCENE.children.bringToTop(this.container);
    }

    setVisible(visible){
        this.container.visible = visible;
    }

    setText(texto){
        this.container.list[1].text = texto;
    }

}