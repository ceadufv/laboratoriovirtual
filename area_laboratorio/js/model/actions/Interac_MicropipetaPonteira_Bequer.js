class Interac_MicropipetaPonteira_Bequer {

    init(objMicropipetaPonteira, objBequer) {
        console.error(objMicropipetaPonteira, objBequer);
        this.objBequer = objBequer;
        this.objMicropipetaPonteira = objMicropipetaPonteira;

        if(objBequer.volume_atual > 0) {
            var menu = [
                {
                    text: 'AMBIENTAR',
                    func: 'ambientar'
                }
            ];

            if (this.objMicropipetaPonteira.ambientado) {
                menu.push({
                    text: 'ASPIRAR',
                    func: 'aspirar'
                });
            }

            menu.push({
                text: 'LIBERAR',
                func: 'liberar'
            });
            MenuInteract.montModalInteracMenu(menu);
      
        } else if (this.objMicropipetaPonteira.volume_atual > 0) {
            var menu = [
                {
                    text: 'LIBERAR',
                    func: 'liberar'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);
        
        } else {
            var html = '<p>O béquer está vazio</p>';
            MenuInteract.montModalInteracHTML(html);
        }
    }

    ambientar() {
        if (this.objMicropipetaPonteira.ambientado) {
            var html = '<p>A Micropipeta com ponteira já está ambientada</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        } else {
            this.objMicropipetaPonteira.ambientado = true;
            var html = '<p>A Micropipeta com ponteira foi ambientada.</p>';
            this.objMicropipetaPonteira.adicionarVolume(0.2);
            MenuInteract.montModalInteracHTML(html);
            console.log(this.objMicropipetaPonteira);
            this.objBequer.removerVolume(0.2);
        }
    }
    
    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objMicropipetaPonteira.adicionarVolume(valor_trans);
        this.objMicropipetaPonteira.addComposicao({
            'itens': this.objBequer.composicao[0].itens,
            'volume': valor_trans
        });
        this.objBequer.removerVolume(valor_trans);
    }

    liberarLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objBequer.adicionarVolume(valor_trans);
        this.objBequer.addComposicao({
            'itens': this.objMicropipetaPonteira.composicao[0].itens,
            'volume': valor_trans
        });
        this.objMicropipetaPonteira.removerVolume(valor_trans);
    }

    aspirar() {
        if (this.objMicropipetaPonteira.volumeAceito() <= 0) {
            alert('Não foi possivel, a micropipeta já está na sua capacidade maxima');
            return;
        }

        if (this.objBequer.volume_atual <= 0) {
            alert('Não foi possivel, o béquer está vazio!!!');
            return;
        }

        var max_vol_trans = this.objMicropipetaPonteira.volumeAceito();

        if(this.objBequer.volume_atual < max_vol_trans){
            max_vol_trans = this.objBequer.volume_atual;
        }

        if(this.objBequer.volume_atual <= 0){
            this.objBequer.changeTexture('bequer_vazio');
        }
        

        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }


    
    liberar() {
        if (this.objBequer.volumeAceito() < this.objBequer.volume_atual) {
            alert('Não foi possivel, o béquer já está na sua capacidade maxima');
            return;
        }

        var max_vol_trans = this.objMicropipetaPonteira.volume_atual;

        if(this.objMicropipetaPonteira.volume_atual < max_vol_trans){
            max_vol_trans = this.objMicropipetaPonteira.volume_atual;
        }

        if(this.objBequer.volume_atual > 0){
            this.objBequer.changeTexture('bequer_cheio');
        }
        
        if(this.objMicropipetaPonteira.volume_atual <= 0){
            this.objMicropipetaPonteira.changeTexture('micropipeta_vazia');
        }

        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.liberarLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}
