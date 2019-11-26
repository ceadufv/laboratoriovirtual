class Interac_Pisseta_Frasco {

    init(objPisseta, objFrasco){
        this.objPisseta = objPisseta;
        this.objFrasco = objFrasco;
        console.log(objPisseta, objFrasco);
        
        if(objFrasco.lavado){
            var html = '<p>já está lavado!!!</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        }

        if(objFrasco.ambientado){
            var menu = [
                {
                    text: 'LAVAR',
                    func: 'lavar'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);

        }else{
            var html = '<p>O frasco não está ambientado!!!</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    }

    lavar(){
        this.objFrasco.lavado = true;
        this.objFrasco.esvaziarVolume();
        var html = '<p>O frasco foi lavado</p>';
        MenuInteract.montModalInteracHTML(html);
    }

}