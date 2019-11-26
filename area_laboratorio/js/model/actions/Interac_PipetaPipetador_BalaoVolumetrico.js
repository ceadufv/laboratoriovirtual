class Interac_PipetaPipetador_Balao {

    init(objPipetaVolumetrica, objBalaoVolumetrico) {
        console.error(objPipetaVolumetrica, objBalaoVolumetrico);
        this.objBalaoVolumetrico = objBalaoVolumetrico;
        this.objPipetaVolumetrica = objPipetaVolumetrica;

        if(objBalaoVolumetrico.volume_atual > 0) {
            var menu = [
                {
                    text: 'AMBIENTAR',
                    func: 'ambientar'
                }
            ];

            if (this.objPipetaVolumetrica.ambientado) {
                menu.push({
                    text: 'ASPIRAR',
                    func: 'aspirar'
                });
            }

            menu.push({
                text: 'ENCHER',
                func: 'liberar'
            });
            MenuInteract.montModalInteracMenu(menu);
      
        } else if (this.objPipetaVolumetrica.volume_atual > 0) {
            var menu = [
                {
                    text: 'ENCHER',
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
        //Se a pipeta já estiver ambientada, ela pode ser ambientada novamente em outra solução, então essa condição já elvis
        /*
        if (this.objPipetaVolumetrica.ambientado) {
            var html = '<p>A pipeta já está ambientada</p>';
            MenuInteract.montModalInteracHTML(html);
            return;
        } else {
            */
            this.objPipetaVolumetrica.ambientado = true;
            var html = '<p>A pipeta foi ambientada.</p>';
            this.objPipetaVolumetrica.adicionarVolume(0.2);
            console.log(this.objPipetaVolumetrica);
            this.objBalaoVolumetrico.removerVolume(0.2);
            MenuInteract.montModalInteracHTML(html);
        //}
    }
    
    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objPipetaVolumetrica.adicionarVolume(valor_trans);
        this.objBalaoVolumetrico.misturar();
        this.objPipetaVolumetrica.addComposicao({
            'itens': this.objBalaoVolumetrico.composicao[0].itens,
            'volume': valor_trans
        });
        this.objBalaoVolumetrico.removerVolume(valor_trans);
    }

    liberarLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objBalaoVolumetrico.adicionarVolume(valor_trans);
        this.objBalaoVolumetrico.misturar();
        this.objBalaoVolumetrico.addComposicao({
            'itens': this.objBalaoVolumetrico.composicao[0].itens,
            'volume': valor_trans
        });
        this.objPipetaVolumetrica.removerVolume(valor_trans);
    }

    aspirar() {
        if (this.objPipetaVolumetrica.volumeAceito() <= 0) {
            alert('Não foi possivel, a pipeta já está na sua capacidade maxima');
            return;
        }

        if (this.objBalaoVolumetrico.volume_atual <= 0) {
            alert('Não foi possivel, o béquer está vazio!!!');
            return;
        }

        if(this.objBalaoVolumetrico.volume_atual <= 0){
            this.objBalaoVolumetrico.changeTexture('bequer_vazio');
        }
        
        var max_vol_trans = NumberCalc.getMin(this.objBalaoVolumetrico.volume_atual, this.objPipetaVolumetrica.volumeAceito());
        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }


    
    liberar() {

        if(this.objBalaoVolumetrico.volumeAceito() == 0) {
            alert('Não foi possivel, o béquer já está na sua capacidade maxima');
            return;
        }

        if(this.objBalaoVolumetrico.volume_atual > 0){
            this.objBalaoVolumetrico.changeTexture('bequer_cheio');
        }
        
        if(this.objPipetaVolumetrica.volume_atual <= 0){
            this.objPipetaVolumetrica.changeTexture('pipeta');
            //this.objPipetaVolumetrica.changeTexture('pipeta_vazia'); quando tiver a imagem
        }

        var max_vol_trans = NumberCalc.getMin(this.objPipetaVolumetrica.volume_atual, this.objBalaoVolumetrico.volumeAceito());
        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.liberarLiquido()');
        MenuInteract.montModalInteracHTML(html);
    }
}
