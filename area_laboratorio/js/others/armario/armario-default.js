/** botoes de quantidade + e - */
$(document).on( "click", ".number-add", function() {
    calValorInputQtds(this, 1);
});

$(document).on( "click", ".number-subtract", function() {
    calValorInputQtds(this, -1);
});
function calValorInputQtds(ele, num){
    var input = $(ele).closest('.number-spinner').find('.number-input');
    var val_atual = parseInt($(input).val());
    var valor_max = parseInt($(input).attr('max'));
    var valor_novo = val_atual+num;
    if(valor_novo >= valor_max){
        valor_novo = valor_max;
    }
    if(valor_novo <= 0 ){
        valor_novo = 0;
    }
    $(input).val(valor_novo);
    Armario.updateInterface();
}