class Interac_Frasco_Frasco {
    /*
    constructor(){
        console.error('interacSolucao_Solucao Okkk');
    }
*/
    init(objFrascoAtivo, objFrascoDrop) {
        this.objFrascoDrop = objFrascoDrop;
        this.objFrascoAtivo = objFrascoAtivo;

        console.log(this.objFrascoAtivo);

        var menu = [
            {
                text: 'AMBIENTAR',
                func: 'ambientar'
            }
        ];

        if (this.objFrascoDrop.ambientado) {
            console.log('ambientado');
            menu.push({
                text: 'TRANSFERIR',
                func: 'transferir'
            });
        }
        
        MenuInteract.montModalInteracMenu(menu);
    }

    ambientar() {
        if (this.objFrascoDrop.ambientado) {
            var html = '<p>O frasco já está ambientado</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        } else {
            this.objFrascoDrop.ambientado = true;
            var html = '<p>O frasco foi ambientado</p>';
            MenuInteract.montModalInteracHTML(html);
            console.log(this.objFrascoDrop);
            this.objFrascoAtivo.removerVolume(0.2);
        }
    }

    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objFrascoDrop.adicionarVolume(valor_trans);
        this.objFrascoDrop.composicao.push({
            'itens': this.objFrascoAtivo.datadefault.composicao,
            'volume': valor_trans
        });
        this.objFrascoAtivo.removerVolume(valor_trans);
    }

    transferir() {

        if (this.objFrascoDrop.volumeAceito() <= 0) {
            alert('Não foi possivel, o frasco já está na sua capacidade maxima');
            return;
        }

        if (this.objFrascoAtivo.volume_atual <= 0) {
            alert('Não foi possivel, o frasco está vazio!!!');
            return;
        }

        var max_vol_trans = this.objFrascoDrop.volumeAceito();

        if (this.objFrascoAtivo.volume_atual < max_vol_trans) {
            max_vol_trans = this.objFrascoAtivo.volume_atual;
        }

        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }

}