class Interac_MicropipetaPonteira_Balao {

    init(objMicropipetaPonteira, objBalaoVolumetrico) {
        console.error(objMicropipetaPonteira, objBalaoVolumetrico);
        this.objBalaoVolumetrico = objBalaoVolumetrico;
        this.objMicropipetaPonteira = objMicropipetaPonteira;

        if(objBalaoVolumetrico.volume_atual > 0) {
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
            var html = '<p>O balão volumétrico está vazio</p>';
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
            var html = '<p>A Micropipeta com ponteira foi ambientada</p>';
            MenuInteract.montModalInteracHTML(html);
            console.log(this.objMicropipetaPonteira);
            this.objBalaoVolumetrico.removerVolume(0.2);
        }
    }
    
    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objMicropipetaPonteira.adicionarVolume(valor_trans);
        this.objBalaoVolumetrico.misturar();
        this.objMicropipetaPonteira.composicao.push({
            'itens': this.objBalaoVolumetrico.composicao[0].itens,
            'volume': valor_trans
        });
        this.objBalaoVolumetrico.removerVolume(valor_trans);
    }

    
    liberarLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objMicropipetaPonteira.removerVolume(valor_trans);
        this.objBalaoVolumetrico.adicionarVolume(valor_trans);
        this.objBalaoVolumetrico.misturar();
        this.objBalaoVolumetrico.composicao.push({
            'itens': this.objBalaoVolumetrico.composicao[0].itens,
            'volume': valor_trans
        });
    }

    aspirar() {
        if (this.objMicropipetaPonteira.volumeAceito() <= 0) {
            alert('Não foi possivel, a micropipeta já está na sua capacidade maxima');
            return;
        }

        if (this.objBalaoVolumetrico.volume_atual <= 0) {
            alert('Não foi possivel, o béquer está vazio!!!');
            return;
        }

        var max_vol_trans = this.objMicropipetaPonteira.volumeAceito();

        if(this.objBalaoVolumetrico.volume_atual < max_vol_trans){
            max_vol_trans = this.objBalaoVolumetrico.volume_atual;
        }

        if(this.objBalaoVolumetrico.volume_atual <= 0){
            this.objBalaoVolumetrico.changeTexture('balao_vazio');
        }
        

        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }

    liberar() {
        if (this.objBalaoVolumetrico.volumeAceito() < this.objBalaoVolumetrico.volume_atual) {
            alert('Não foi possivel, o béquer já está na sua capacidade maxima');
            return;
        }

        var max_vol_trans = this.objMicropipetaPonteira.volume_atual;

        if(this.objMicropipetaPonteira.volume_atual < max_vol_trans){
            max_vol_trans = this.objMicropipetaPonteira.volume_atual;
        }

        if(this.objBalaoVolumetrico.volume_atual > 0){
            this.objBalaoVolumetrico.changeTexture('balao_cheio');
        }
        
        if(this.objMicropipetaPonteira.volume_atual <= 0){
            this.objMicropipetaPonteira.changeTexture('micropipeta_vazia');
        }

        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.liberarLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}
