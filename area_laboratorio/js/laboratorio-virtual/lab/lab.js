
function exibirPagina(n) {

    $('.botoes').show();
    var alvo = $('#animacao .modal-body .conteudo .page-' + n);

    if ($(alvo).length == 0) return false;

    if (alvo.hasClass('sem-botoes')) {
        $('.botoes').hide();
    }

    $('#animacao .modal-body').attr('data-pagina', n);
    $('#animacao .modal-body .conteudo .page').hide();
    $('#animacao .modal-body .conteudo .page-' + n).show();
}

function proximaPagina() {
    var atual = parseInt($('#animacao .modal-body').attr('data-pagina'));
    exibirPagina(atual + 1);
}

function paginaAnterior() {
    var atual = parseInt($('#animacao .modal-body').attr('data-pagina'));
    if (atual > 1) exibirPagina(atual - 1);
}

function limparTela() {
    // Criacao do conteudo
    $("#animacao .modal-body .conteudo .page:not('.page-0')").remove();
}


var config = {
    lampada: {
        deuterio: false,
        tungstenio: false
    },
    status: 0,
    Lmed: 400,
    cubeta: 370,
    modo: 0
};


function validarConfig() {
    var Lmed = form0.Lmed.value;
    if (Lmed == "") {
        alert('Preencha o campo com comprimento de onda');
        form1.Lmed.focus();
        return false;
    }

    if (Lmed > 1100 || Lmed < 190) {
        alert('Insira um valor válido');
        form1.Lmed.focus();
        return false;
    }

    config.Lmed = Lmed * 1
    console.log(config)

    //Roda a função de loop como um sinal de que o aparelho ligou
    setInterval(function () {
        LabEspectrofotometro._loop();
    }, 1000);
}

function status(v) {
    config.status = v;
}

function ligar(objeto) {
    switch (objeto) {
        case "deuterio":
            config.lampada.deuterio = !config.lampada.deuterio;
            break;
        case "tungstenio":
            config.lampada.tungstenio = !config.lampada.tungstenio;
            break;
    }

    // 
    $('.deuterio')
        .removeClass('off').removeClass('on')
        .addClass((config.lampada.deuterio) ? 'on' : 'off');
    //        
    $('.tungstenio')
        .removeClass('off').removeClass('on')
        .addClass((config.lampada.tungstenio) ? 'on' : 'off');

}