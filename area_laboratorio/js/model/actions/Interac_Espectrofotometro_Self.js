class Interac_Espectrofotometro_Self {
    constructor() {
        console.error('Interac_Espectrofotometro_Self constructor');
    }
    init(objClass) {
        this.objClass = objClass;
        var menu = [
            {
                text: 'CONFIGURAR EQUIPAMENTO',
                func: 'configurar'
            }
        ];
        
        if (objClass.tampa_aberta) {
            menu.push({
                text: 'FECHAR TAMPA',
                func: 'fecharTampa'
            });
        } else {
            menu.push({
                text: 'ABRIR TAMPA',
                func: 'abrirTampa'
            });
        }
        MenuInteract.montModalInteracMenu(menu);
    }

    abrirTampa() {
        this.objClass.tampa_aberta = true;
        this.objClass.changeTexture();
    }

    fecharTampa() {
        this.objClass.tampa_aberta = false;
        this.objClass.changeTexture();
    }

    ligarEquipamento() {
        console.log('ligando...');
        this.objClass.ligado = true;
        this.objClass.changeTexture();
        MenuInteract.hideAllModal();
    }
    configurar() {
        console.log('configurar...');
        var html = '';
        html += '<div class="col-md-12">';
        html += '<form method="post">';

        html += '<div class="well">';
        html += '<h3> Configurar espectrofotômetro </h3>';
        html += '<div class="form-group">';
        html += '<label>Comprimento de onda médio:</label>';
        html += '<input class="form-control" type="number" min="190" max="1100" value="190"><br>';
        html += '</div>';
        html += '</div>';

        html += '<div class="well">';
        html += '<h3>Escolha o modo de medição: </h3>';
        html += '<label><input type="radio" name="modo" id="modo" value="abs"> Absorbância </label>';
        html += '<label><input type="radio" name="modo" id="modo" value="trans"> Transmitância</label></br>';
        html += '</div>';

        html += '<div class="well">';
        html += '<h3> Escolha quais lâmpadas deseja ligar:</h3>';
        html += '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="customCheck1"><label class="custom-control-label" for="customCheck1">Deutério</label></div>';
        html += '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="customCheck2"><label class="custom-control-label" for="customCheck2">Tungstênio</label></div>';
        html += '</div>';

        html += '<div class="well">';
        html += '<button type="button" class="btn btn-success" onclick="CLASS_INTERRACT_NOW.ligarEquipamento()">Ligar Equipamento</button>';
        html += '</div>';

        html += '</form>';
        html += '</div>';
        MenuInteract.montModalInteracHTML(html);
    }
}