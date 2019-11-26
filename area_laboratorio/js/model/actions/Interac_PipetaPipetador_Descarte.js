class Interac_PipetaPipetador_Descarte {

    init(objPipetaPipetador, objDescarte) {
        console.error(objPipetaPipetador, objDescarte);
        this.objDescarte = objDescarte;
        this.objPipetaPipetador = objPipetaPipetador;

        if(objPipetaPipetador.volume_atual > 0) {
            var menu = [
                {
                    text: 'LIBERAR',
                    func: 'liberar'
                }
            ];

            MenuInteract.montModalInteracMenu(menu);

        } else {
            var html = '<p>A pipeta está vazia</p>';
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
        this.objPipetaPipetador.removerVolume(valor_trans);
    }

    liberar() {
        var max_vol_trans = this.objPipetaPipetador.volume_atual;

        if(this.objPipetaPipetador.volume_atual < max_vol_trans){
            max_vol_trans = this.objPipetaPipetador.volume_atual;
        }

        if(this.objDescarte.volume_atual > 0){
            this.objDescarte.changeTexture('descarte_cheio');
        }
        
        if(this.objPipetaPipetador.volume_atual <= 0){
            //this.objPipetaPipetador.changeTexture('pipeta_pipetador_vazio'); quando tiver a imagem
            this.objPipetaPipetador.changeTexture('pipeta_pipetador');
        }

        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.liberarLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}
