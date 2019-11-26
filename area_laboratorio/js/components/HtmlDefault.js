class HtmlDefaults{

    /* Html de transferencia de liguido default */
    static getHtmlTransferir(vol_max, func){
        var html = '';
        html += '<div class="form-group">';
        html += '<label for="form-transferencia">Volume a ser transferido:</label>';
        html += '<input type="range" step="0.1" value="0"  min="0" max="' +vol_max+ '" class="form-control-range form-transferencia">';
        html += '<div class="val-form-transferencia">0</div>';
        html += '</div>';
        html += '<button class="btn btn-primary" type="button" onClick="'+func+'">Transferir</button>';
        return html;
    }
}