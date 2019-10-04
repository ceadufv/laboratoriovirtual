function selecionar_disciplina() {
    var disciplina_acessada = $('#listaDisciplinas').val();
    if (disciplina_acessada == '' || disciplina_acessada == undefined) {
        alert('Selecione uma disciplina!');
        return false;
    }
    window.location = URL_SITE + 'area_professor/index.php?aba=aulas&id_disciplina=' + disciplina_acessada;
};

function salvarDisciplina() {
    var nome = $('#nome_disciplina_nova').val();
    $.ajax({
        url: URL_SITE + "area_professor/index-app.php?app=tudo&file=insert_disciplina",
        type: 'POST',
        data: {
            nome: nome
        },
    }).done(function (data) {
        console.log(data);
        if (data.status == true) {
            //Se for positivo, mostra ao utilizador uma janela de sucesso.
            alert('Informações salvas com sucesso!');
            location.href = URL_SITE + "area_professor/index.php?aba=inicio";
        } else {
            //Caso contrário dizemos que aconteceu algum erro.
            alert('Erro com banco de dados. Tente novamente mais tarde. Se persistir o erro, contate o administrador.');
        }
    });
}

function remover_disciplina() {
    disciplina_acessada = $('#listaDisciplinas').val();
    $.ajax({
        url: URL_SITE + "area_professor/index-app.php?app=tudo&file=apagar_disciplina",
        type: 'POST',
        data: {
            id_disciplina: disciplina_acessada,
        },
        success: function (data) {
            console.log(data);
            if (data.status == true) {
                window.location = URL_SITE + "area_professor/index.php?aba=inicio";
            }
            else {
                alert("Erro no banco de dados. Se o problema permitir, contate o administrador");
            }
        },
        error: function (data) {
            alert('Erro na conexão. Se o problema permitir, contate o administrador');
        }
    });
}

$(document).ready(function () {
    $('[data-toggle=confirmation-disciplina]').confirmation({
        rootSelector: '[data-toggle=confirmation-disciplina]',
        container: 'body',
        onConfirm: function () {
            remover_disciplina();
        },
        onCancel: function () {
        },
    });
});