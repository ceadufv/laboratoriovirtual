$(function () {
  $('[data-toggle="popover"]').popover()
})
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

$(document).ready(function () {
  editar = -1;
  disciplina_acessada = -1;

  if (bd) {
    if (bd.id_disciplina) disciplina_acessada = bd.id_disciplina;
  }
});

function salvaOuAtualiza() {
  post("funcoes/save_pratica.php");
}

function cadastraAula() {
  $('.dadospratica').attr('data-id', -1);
  aba('editaula');
}

function edit_pratica(id_pratica) {
  window.location = 'index.php?aba=editaula&id_disciplina=' + disciplina_acessada + '&id_pratica=' + id_pratica;
}

function selecionar_disciplina() {
  disciplina_acessada = $('#listaDisciplinas').val();
  window.location = 'index.php?aba=aulas&id_disciplina=' + disciplina_acessada;
};


function salvarDisciplina() {
  var nome = $('#nome_disciplina_nova').val();
  $.ajax({
    url: "funcoes/insert_disciplina.php",
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
    url: "funcoes/apagar_disciplina.php",
    type: 'POST',
    data: {
      id_disciplina: disciplina_acessada,
    },
    success: function (data) {
      console.log(data);
      if (data.status == true) {
        window.location = "index.php?aba=inicio";
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