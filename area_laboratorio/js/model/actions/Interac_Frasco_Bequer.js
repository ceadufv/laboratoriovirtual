class Interac_Frasco_Bequer {

    init(objSolucao, objBequer) {
        console.error(objSolucao, objBequer);
        this.objBequer = objBequer;
        this.objSolucao = objSolucao;

        if(objSolucao.volume_atual > 0) {
            var menu = [
                {
                    text: 'AMBIENTAR',
                    func: 'ambientar'
                }
            ];

            if (this.objBequer.ambientado) {
                menu.push({
                    text: 'TRANSFERIR',
                    func: 'transferir'
                });
            }
            MenuInteract.montModalInteracMenu(menu);
        } else {
            var html = '<p>O frasco está vazio</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    }

    ambientar() {
        this.objBequer.ambientado = true;
        this.objSolucao.removerVolume(0.2);
    }
    
    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objBequer.adicionarVolume(valor_trans);
        this.objBequer.addComposicao({
            'itens': this.objSolucao.composicao[0].itens,
            'volume': valor_trans
        });
        this.objSolucao.removerVolume(valor_trans);
    }
    
    transferir() {
        if (this.objBequer.volumeAceito() <= 0) {
            alert('Não foi possivel, o bequer já está na sua capacidade maxima');
            return;
        }

        if (this.objSolucao.volume_atual <= 0) {
            alert('Não foi possivel, o frasco está vazio!!!');
            return;
        }

        var max_vol_trans = this.objBequer.volumeAceito();
        if(this.objSolucao.volume_atual < max_vol_trans){
            max_vol_trans = this.objSolucao.volume_atual;
        }

        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}