class Interac_Pisseta_PipetaPipetador {

    init(objPisseta, objPipeta) {
        this.objPisseta = objPisseta;
        this.objPipeta = objPipeta;



        if (objPipeta.ambientado) {
            var menu = [
                {
                    text: 'TRANSFERIR',
                    func: 'transferir'
                },
                {
                    text: 'LAVAR',
                    func: 'lavar'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);
        } else {
            var menu = [
                {
                    text: 'AMBIENTAR',
                    func: 'ambientar'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);
        }
    }

    ambientar(){
        this.objPipeta.ambientado = true;
    }

    lavar() {
        this.objPipeta.lavado = true;
        this.objPipeta.ambientado = false;
        this.objPipeta.volume_atual = 0;
    }

    transferir() {
        if (this.objPipeta.volumeAceito() <= 0) {
            alert('Não foi possivel, o balão já está na sua capacidade maxima');
            return;
        }

        if (this.objPisseta.volume_atual <= 0) {
            alert('Não foi possivel, a pisseta está vazio!!!');
            return;
        }

        var max_vol_trans = this.objPipeta.volumeAceito();
        if (this.objPisseta.volume_atual < max_vol_trans) {
            max_vol_trans = this.objPisseta.volume_atual;
        }

        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }

    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();

        this.objPipeta.adicionarVolume(valor_trans);
        this.objPisseta.removerVolume(valor_trans);

    }
}