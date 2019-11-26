$('#form-solucoes').submit(function () {
    var dados = $(this).serializeArray();
    $.ajax({
        type: "post",
        url: URL_SITE + "area_professor/index_new.php?aba=xhr-solucao-pratica",
        data: dados,
        success: function (response) {
            var data = JSON.parse(response);
            alert(data.msg);
            if (data.success) {
                $('#modal_solucao').modal('hide');
                $('#modal_solucao .modal-content').html('');
                $('#solucoes-preparadas').html(data.html);
            }
        }
    });
    return false;
});

function deletar_linha(obj) {
    $(obj).parents('tr').remove();
}

function adicionar_especie() {
    var concentracao = parseFloat($('#especies_concentracao').val());

    if(concentracao <= 0 || isNaN(concentracao))
        return;

    var atual = {
        id: $('#especies_disponiveis').val(),
        nome: $('#especies_disponiveis option:selected').text(),
        concentracao: concentracao,
    };
    adicionar_especie_lista(atual);
};

function adicionar_especie_lista(dado) {
    var html_s = '';
    html_s = "<tr class=\"linha_composicao\" data-id=\"" + dado.id + "\" data-nome=\"" + dado.nome + "\" data-value=\"" + dado.concentracao + "\">";
    html_s += "<td class='nomes_composicao'>" + dado.nome + "</td><td class='conc_lista_solucao'>" + dado.concentracao + "</td><td> mol/L</td><td><button class='btn vermelho' onclick='deletar_linha(this)'>Excluir </button></td>";
    html_s += '<input type="hidden" name="composicao_id[]" value="'+dado.id+'" />';
    html_s += '<input type="hidden" name="composicao_nome[]" value="'+dado.nome+'" />';
    html_s += '<input type="hidden" name="composicao_concentracao[]" value="'+dado.concentracao+'" />';
    html_s += '</tr>';
    $("#especies_na_solucao").append(html_s);
}