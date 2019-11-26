class Interac_Frasco_Ponteira {

    init(objSolucao, objPonteira) {
        console.error(objSolucao, objPonteira);
        this.objPonteira = objPonteira;
        this.objSolucao = objSolucao;

        var menu = [
        {
            text: 'AMBIENTAR',
            func: 'ambientar'
        }
        ];
        MenuInteract.montModalInteracMenu(menu);
    }

    ambientar() {
        this.objPonteira.ambientado = true;
        this.objPonteira.lavado = false;
        console.log(this.objPonteira);
        this.objSolucao.removerVolume(0.2);
    }
   
}