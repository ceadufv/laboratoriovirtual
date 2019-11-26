class Interac_Balao_Bequer {

    init(objBalao, objBequer) {
        console.error(objBalao, objBequer);
        this.objBequer = objBequer;
        this.objBalao = objBalao;

        if(objBalao.volume_atual > 0) {
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
            var html = '<p>O balão está vazio</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    }

    ambientar() {
        if (this.objBequer.ambientado) {
            var html = '<p>O béquer já está ambientado</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        } else {
            this.objBequer.ambientado = true;
            var html = '<p>O béquer foi ambientado</p>';
            MenuInteract.montModalInteracHTML(html);
            console.log(this.objBequer);
            this.objBalao.removerVolume(0.2);
        }
    }
    
    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objBequer.adicionarVolume(valor_trans);
        this.objBequer.composicao.push({
            'itens': this.objBalao.composicao[0].itens,
            'volume': valor_trans
        });
        this.objBalao.removerVolume(valor_trans);
    }

    transferir() {
        if (this.objBequer.volumeAceito() <= 0) {
            alert('Não foi possivel, o balão já está na sua capacidade maxima');
            return;
        }

        if (this.objBalao.volume_atual <= 0) {
            alert('Não foi possivel, o béquer está vazio!!!');
            return;
        }

        var max_vol_trans = this.objBequer.volumeAceito();
        if(this.objBalao.volume_atual < max_vol_trans){
            max_vol_trans = this.objBalao.volume_atual;
        }

        var max_vol_trans = NumberCalc.getMin(this.objBalao.volume_atual, this.objBequer.volumeAceito());
        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}