$('#formlulario-edita-aula').submit(function () {
    $('input:disabled').attr("disabled", false);
    $('select:disabled').attr("disabled", false);
    var formData = new FormData(document.getElementById('formlulario-edita-aula'));
    formData.append('acao', 'salvar-dados');
    $.ajax({
        type: "post",
        url: URL_SITE + "area_professor/index_new.php?aba=editaula",
        processData: false,
        contentType: false,
        data: formData,
        success: function (data) {
            var response = JSON.parse(data);
            alert(response.msg);
            var url = URL_SITE + 'area_professor/index.php?aba=editaula&id_disciplina=' + $('[name=id_disciplina]').val();
            url += '&id_pratica=' + response.id_modelo_pratica;
            console.log(url);
            window.location.href = url;
        }
    });
    return false;
});

$('.nova-solucao').click(function () {
    novaSolucao(this);
});

function novaSolucao(elem) {
    var id_pratica = $(elem).attr('id_pratica');
    var cod_moprsi = $(elem).attr('cod_moprsi');
    $.ajax({
        type: "post",
        url: URL_SITE + "area_professor/index_new.php?aba=xhr-solucao-pratica&id_pratica=" + id_pratica + '&cod_moprsi=' + cod_moprsi,
        data: {},
        success: function (response) {
            $('#modal_solucao .modal-content').html(response);
        }
    });
}

/* material didatico */
function deletarArquivoPratica(ele) {

    var confim = confirm('Tem certeza que deseja deletar este arquivo?');
    if (!confim)
        return false;


    var cod_moprar = $(ele).attr('cod_moprar');
    var formData = new FormData();
    formData.append('cod_moprar', cod_moprar);
    formData.append('acao', 'deletar');

    $.ajax({
        type: "post",
        url: URL_SITE + 'area_professor/index_new.php?aba=xhr-arquivos-pratica',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            var data = JSON.parse(response);
            alert(data.msg);
            if (data.success) {
                $('#file-' + cod_moprar).remove();
            }
        }
    });
}

$('#enviar-caderno').click(function () {
    var formData = new FormData();
    formData.append('imagem', $('[name="caderno_file_caderno"]')[0].files[0]);
    formData.append('tipo', 'CADERNO');
    formData.append('id_pratica', $('[name="id_modelo_pratica"]').val());
    formData.append('acao', 'salvar');

    $.ajax({
        type: "post",
        url: URL_SITE + 'area_professor/index_new.php?aba=xhr-arquivos-pratica',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            var data = JSON.parse(response);
            alert(data.msg);
            if (data.success) {
                $('[name="caderno_file_caderno"]').val('');
                $('#caderno-arquivos').html(data.html);
            }
        }
    });
});

$('#enviar-roteiro').click(function () {
    var formData = new FormData();
    formData.append('imagem', $('[name="material_file_roteiro"]')[0].files[0]);
    formData.append('tipo', 'ROTEIRO');
    formData.append('id_pratica', $('[name="id_modelo_pratica"]').val());
    formData.append('acao', 'salvar');

    $.ajax({
        type: "post",
        url: URL_SITE + 'area_professor/index_new.php?aba=xhr-arquivos-pratica',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            var data = JSON.parse(response);
            alert(data.msg);
            if (data.success) {
                $('[name="material_file_roteiro"]').val('');
                $('#roteiro-arquivos').html(data.html);
            }
        }
    });
});