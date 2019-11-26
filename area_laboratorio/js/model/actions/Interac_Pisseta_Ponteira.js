class Interac_Pisseta_Ponteira {

    init(objPisseta, objPonteira){
        this.objPisseta = objPisseta;
        this.objPonteira = objPonteira;
        console.log(objPisseta, objPonteira);
        
        if(objPonteira.lavado){
            var html = '<p>A ponteira já está lavada!</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        }

        //if(objPonteira.ambientado){
            var menu = [
                {
                    text: 'LAVAR',
                    func: 'lavar'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);
/*
        }else{
            var html = '<p>A ponteira está limpa!</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    */
    }

    lavar(){
        this.objPonteira.lavado = true;
        this.objPonteira.ambientado = false;
        var html = '<p>A ponteira foi lavada</p>';
        MenuInteract.montModalInteracHTML(html);
    }

}