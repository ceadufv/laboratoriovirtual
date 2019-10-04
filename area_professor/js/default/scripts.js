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