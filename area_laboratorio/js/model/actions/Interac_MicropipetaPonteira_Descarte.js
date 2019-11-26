class Interac_MicropipetaPonteira_Descarte {

    init(objMicropipetaPonteira, objDescarte) {
        console.error(objMicropipetaPonteira, objDescarte);
        this.objDescarte = objDescarte;
        this.objMicropipetaPonteira = objMicropipetaPonteira;

        if(objMicropipetaPonteira.volume_atual > 0) {
            var menu = [
                {
                    text: 'LIBERAR',
                    func: 'liberar'
                }
            ];

            MenuInteract.montModalInteracMenu(menu);

        } else {
            var html = '<p>A micropipeta está vazia</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    }

     liberarLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objDescarte.adicionarVolume(valor_trans);
        this.objDescarte.misturar();
        this.objDescarte.addComposicao({
            'itens': this.objDescarte.composicao[0].itens,
            'volume': valor_trans
        });
        this.objMicropipetaPonteira.removerVolume(valor_trans);
    }

    liberar() {
        if(this.objDescarte.volumeAceito() == 0) {
            alert('Não foi possivel, o descarte já está na sua capacidade maxima');
            return;
        }

        if(this.objDescarte.volume_atual > 0){
            this.objDescarte.changeTexture('descarte_cheio');
        }
        
        if(this.objMicropipetaPonteira.volume_atual <= 0){
            this.objMicropipetaPonteira.changeTexture('micropipeta_vazia');
        }
        
        var max_vol_trans = NumberCalc.getMin(this.objMicropipetaPonteira.volume_atual, this.objDescarte.volumeAceito());
        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.liberarLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}
