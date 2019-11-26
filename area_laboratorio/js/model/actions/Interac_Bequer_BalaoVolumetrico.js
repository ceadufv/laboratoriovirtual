class Interac_Bequer_Balao {

    init(objBequer, objBalao) {
        console.error(objBequer, objBalao);
        this.objBalao = objBalao;
        this.objBequer = objBequer;

        if(objBequer.volume_atual > 0) {
            var menu = [
                {
                    text: 'AMBIENTAR',
                    func: 'ambientar'
                }
            ];

            if (this.objBalao.ambientado) {
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

        if (this.objBalao.ambientado) {
            var html = '<p>O balão volumétrico já está ambientado</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        } else {
            this.objBalao.ambientado = true;
            var html = '<p>O balão foi ambientado</p>';
            MenuInteract.montModalInteracHTML(html);
            console.log(this.objBalao);
            this.objBequer.removerVolume(0.2);
        }
    }
    
    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objBalao.adicionarVolume(valor_trans);
        this.objBalao.composicao.push({
            'itens': this.objBequer.composicao[0].itens,
            'volume': valor_trans
        });
        this.objBequer.removerVolume(valor_trans);
    }

    transferir() {
        if (this.objBalao.volumeAceito() <= 0) {
            alert('Não foi possivel, o balão já está na sua capacidade maxima');
            return;
        }

        if (this.objBequer.volume_atual <= 0) {
            alert('Não foi possivel, o béquer está vazio!!!');
            return;
        }

        var max_vol_trans = NumberCalc.getMin(this.objBequer.volume_atual, this.objBalao.volumeAceito());
        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}