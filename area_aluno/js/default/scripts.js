$(function () {
  $('[data-toggle="popover"]').popover()
})
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

// Função de troca de abas
function aba(tela) {
  $('.tab-' + tela).addClass('ativo');
}

function logoff() {
  window.location.href = URL_SITE + 'logout.php';
};