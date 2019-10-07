// Função de troca de telas
function aba(tela) {
    $('.opcoes').removeClass('ativo');
    $('.tab-' + tela).addClass('ativo');
    $('.div-secoes').hide();
    $('.div-secoes.div-' + tela).show();

    // Exibe modal, se houver
    if ($('.modal.div-' + tela).length) {
        $('.modal.div-' + tela).modal('show');
        $('.div-secoes').hide();
    }
}

function logoff() {
    window.location.href = URL_SITE + 'logout.php';
};
