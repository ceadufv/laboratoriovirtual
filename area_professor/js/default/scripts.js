$(function () {
  $('[data-toggle="popover"]').popover()
})
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

function salvaOuAtualiza() {
  post("area_professor/index-app.php?app=tudo&file=save_pratica");
}

function cadastraAula() {
  $('.dadospratica').attr('data-id', -1);
  aba('editaula');
}

function edit_pratica(id_pratica) {
  window.location = 'index.php?aba=editaula&id_disciplina=' + disciplina_acessada + '&id_pratica=' + id_pratica;
}