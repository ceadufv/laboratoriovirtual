class Interac_Bequer_Descarte {

    init(objBequer, objDescarte) {

        this.objBequer = objBequer;
        this.objDescarte = objDescarte;
        console.log(objBequer, objDescarte);
    
        if(objBequer.volume_atual > 0) {

            var menu = [
                {
                    text: 'Descartar Conteúdo',
                    func: 'descartar'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);
        } else {
            var html = '<p>O béquer está vazio</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    }

    descartar() {
        this.objBequer.esvaziarVolume();
        var html = '<p>O conteúdo foi descartado</p>';
        MenuInteract.montModalInteracHTML(html);
    }
}