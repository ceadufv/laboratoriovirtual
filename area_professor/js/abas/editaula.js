$('#formlulario-edita-aula').submit(function () {
    $('input:disabled').attr("disabled", false);
    $('select:disabled').attr("disabled", false);
    var formData = new FormData(document.getElementById('formlulario-edita-aula'));
    formData.append('acao', 'salvar-dados');
    $.ajax({
        type: "post",
        url: URL_SITE+"area_professor/index_new.php?aba=editaula",
        processData: false,
        contentType: false,
        data: formData,
        success: function (data) {
            var response = JSON.parse(data);
            alert(response.msg);
            var url = URL_SITE+'area_professor/index.php?aba=editaula&id_disciplina='+$('[name=id_disciplina]').val();
            url += '&id_pratica='+response.id_modelo_pratica;
            console.log(url);
            window.location.href = url;
        }
    });
    return false;
});

$('.nova-solucao').click(function(){
    novaSolucao(this);
});

function novaSolucao(elem){
    var id_pratica = $(elem).attr('id_pratica');
    var cod_moprsi = $(elem).attr('cod_moprsi');
    $.ajax({
        type: "post",
        url: URL_SITE+"area_professor/index_new.php?aba=xhr-solucao-pratica&id_pratica="+id_pratica+'&cod_moprsi='+cod_moprsi,
        data: {},
        success: function (response) {
            $('#modal_solucao .modal-content').html(response);
        }
    });
}