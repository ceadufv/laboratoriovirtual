class Interac_Pisseta_Bequer{

    init(objPisseta, objBequer){
        this.objPisseta = objPisseta;
        this.objBequer = objBequer;
        console.log(objPisseta, objBequer);
        
        if(objBequer.lavado){
            var html = '<p>já está lavado!!!</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        }

        if(objBequer.ambientado){
            var menu = [
                {
                    text: 'LAVAR',
                    func: 'lavar'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);

        }else{
            var html = '<p>Sem ação, O bequer ainda não está ambientado!!!</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    }

    lavar(){
        this.objBequer.esvaziarVolume();
        this.objBequer.lavado = true;
        var html = '<p>O béquer foi lavado</p>';
        MenuInteract.montModalInteracHTML(html);
    }

}