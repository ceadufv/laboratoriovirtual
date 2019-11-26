class Interac_Balao_Frasco {

    init(objBalao, objFrasco) {
        console.error(objBalao, objFrasco);
        this.objFrasco = objFrasco;
        this.objBalao = objBalao;

        if(objBalao.volume_atual > 0) {
            var menu = [
                {
                    text: 'AMBIENTAR',
                    func: 'ambientar'
                }
            ];

            if (this.objFrasco.ambientado) {
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
        if (this.objFrasco.volume_atual > 0) {
            var html = '<p>Não é possível ambientar, pois o frasco não está vazio.</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        }

        if (this.objFrasco.ambientado) {
            var html = '<p>O frasco já está ambientado</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        } else {
            this.objFrasco.ambientado = true;
            var html = '<p>O frasco foi ambientado</p>';
            MenuInteract.montModalInteracHTML(html);
            console.log(this.objFrasco);
            this.objBalao.removerVolume(0.2);
        }
    }
    
    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objFrasco.adicionarVolume(valor_trans);
        this.objFrasco.composicao.push({
            'itens': this.objBalao.composicao[0].itens,
            'volume': valor_trans
        });
        this.objBalao.removerVolume(valor_trans);
    }

    transferir() {
        if (this.objFrasco.volumeAceito() <= 0) {
            alert('Não foi possivel, o balão já está na sua capacidade maxima');
            return;
        }

        if (this.objBalao.volume_atual <= 0) {
            alert('Não foi possivel, o frasco está vazio!!!');
            return;
        }

        var max_vol_trans = NumberCalc.getMin(this.objBalao.volume_atual, this.objFrasco.volumeAceito());
        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}