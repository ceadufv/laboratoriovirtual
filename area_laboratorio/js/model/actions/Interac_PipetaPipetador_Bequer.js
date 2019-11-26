class Interac_PipetaPipetador_Bequer {

    init(objPipetaVolumetrica, objBequer) {
        console.error(objPipetaVolumetrica, objBequer);
        this.objBequer = objBequer;
        this.objPipetaVolumetrica = objPipetaVolumetrica;

        if (objBequer.volume_atual > 0) {
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
        MenuInteract.montModalInteracHTML(html);
        console.log(this.objPipetaVolumetrica);
        this.objBequer.removerVolume(0.2);
        //}
    }

    /*
    transferirLiquido() {
        var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objPipetaVolumetrica.adicionarVolume(valor_trans);
        this.objBequer.removerVolume(valor_trans);
        this.objPipetaVolumetrica.addComposicao({
            'itens': this.objBequer.composicao[0].itens,
            'volume': valor_trans
        });
    }
    */

    sugarLiquido(valor_trans) {
        MenuInteract.hideAllModal();
        
        this.objPipetaVolumetrica.adicionarVolume(valor_trans);
        this.objPipetaVolumetrica.addComposicao({
            'itens': this.objBequer.composicao[0].itens,
            'volume': valor_trans
        });

        this.objBequer.removerVolume(valor_trans);
    }

    liberarLiquido(valor_trans) {
        //var valor_trans = $('.form-transferencia').val();
        MenuInteract.hideAllModal();
        this.objBequer.adicionarVolume(valor_trans);
        this.objBequer.addComposicao({
            'itens': this.objPipetaVolumetrica.composicao[0].itens,
            'volume': valor_trans
        });
        this.objPipetaVolumetrica.removerVolume(valor_trans);
    }

    aspirar() {
        if (this.objPipetaVolumetrica.volumeAceito() <= 0) {
            alert('Não foi possivel, a pipeta já está na sua capacidade maxima');
            return;
        }
        if (this.objBequer.volume_atual <= 0) {
            alert('Não foi possivel, o béquer está vazio!!!');
            return;
        }
        this.objBequer.changeTexture();
        this.objPipetaVolumetrica.changeTexture();
        var max_vol_trans = NumberCalc.getMin(this.objBequer.volume_atual, this.objPipetaVolumetrica.volumeAceito());

        var animP = new BoxAnimacaoPipetaPipetador();
        animP.volume_total = this.objPipetaVolumetrica.volume_max;
        animP.init(this);
        animP.setMaxVolumeTrans(max_vol_trans);
        animP.setMinVolumeTrans(0);

        /*
        var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.transferirLiquido()');
        MenuInteract.montModalInteracHTML(html);
        */
    }

    liberar() {
        if (this.objBequer.volumeAceito() == 0) {
            alert('Não foi possivel, o béquer já está na sua capacidade maxima');
            return;
        }

        this.objBequer.changeTexture();
        this.objPipetaVolumetrica.changeTexture();

        var max_vol_trans = NumberCalc.getMin(this.objPipetaVolumetrica.volume_atual, this.objBequer.volumeAceito());

        var animP = new BoxAnimacaoPipetaPipetador();
        animP.volume_total = this.objPipetaVolumetrica.volume_max;
        animP.init(this);
        animP.estado = 'liberar';
        animP.setMaxVolumeTrans(this.objPipetaVolumetrica.volume_atual);

        this.objPipetaVolumetrica.volume_atual = parseFloat(this.objPipetaVolumetrica.volume_atual);
        if (this.objPipetaVolumetrica.volume_atual > parseFloat(this.objBequer.volumeAceito())){
            animP.setMinVolumeTrans(max_vol_trans);
        }else
            animP.setMinVolumeTrans(0);

        animP.setVolumeAtual(this.objPipetaVolumetrica.volume_atual);
        //var html = HtmlDefaults.getHtmlTransferir(max_vol_trans, 'CLASS_INTERRACT_NOW.liberarLiquido()');
        //MenuInteract.montModalInteracHTML(html);
    }
}
