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
            var url = URL_SITE+'area_professor/index.php?aba=aulas&id_disciplina='+$('[name=id_disciplina]').val();
            //console.log(location);
            window.location.href = url;
        }
    });
    return false;
});