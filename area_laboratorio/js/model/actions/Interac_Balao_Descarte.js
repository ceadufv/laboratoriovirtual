class Interac_Balao_Descarte{
    init(objBalao, objDescarte){
        this.objBalao = objBalao;
        this.objDescarte = objDescarte;
        if(objBalao.volume_atual > 0) {
            var menu = [
                {
                    text: 'Descartar Conteúdo',
                    func: 'descartar'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);
        } else {
            var html = '<p>O balão já está vazio</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    }
    descartar() {
        this.objBalao.esvaziarVolume();
        var html = '<p>O conteúdo foi descartado</p>';
        MenuInteract.montModalInteracHTML(html);
    }
}