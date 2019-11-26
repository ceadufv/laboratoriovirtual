class Interac_Frasco_Self{
    init(objSolucao){
        this.objSolucao = objSolucao;
        if(this.objSolucao.etiqueta != ''){
            var menu = [
                {
                    text: 'Rotular',
                    func: 'modalEtiqueta'
                },
                {
                    text: 'Colocar no armário',
                    func: 'salvarArmario'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);
        }else{
            var menu = [
                {
                    text: 'Rotular',
                    func: 'modalEtiqueta'
                }
            ];
            MenuInteract.montModalInteracMenu(menu);
        }
    }
    
    salvarArmario(){
        var item = this.objSolucao.datadefault;
        item.qtd_maxima = 1;
        item.nome = this.objSolucao.etiqueta;
        item.volume_atual = this.objSolucao.volume_atual;
        console.log('salvarArmario', item);
        ArmarioTabs.construirItem('solucoes', item);
        this.objSolucao.destroy();
    }

    modalEtiqueta(){
        var html = '';
        html += '<div class="form-group">';
        html += '<label for="form-transferencia">Rótulo do frasco:</label>';
        html += '<input type="text" id="etiqueta-frasco" value="'+this.objSolucao.etiqueta+'" class="form-control" maxlength="20"/>';
        html += '</div>';
        html += '<button class="btn btn-primary" type="button" onClick="CLASS_INTERRACT_NOW.salvarEtiqueta();">Salvar</button>';
        MenuInteract.montModalInteracHTML(html);
    }

    salvarEtiqueta(){
        var etiqueta = $('#etiqueta-frasco').val();
        MenuInteract.hideAllModal();
        this.objSolucao.etiqueta = etiqueta;
    }
}