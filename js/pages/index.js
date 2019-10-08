function fecharJanelaSessao() {
    $('.div-login').addClass('oculta');
}

function abrirCadastro() {
    $('.conteudo').addClass('oculta');
    $('.div-cadastro').removeClass('oculta');
    $('.conteudo').removeClass('visivel');
}

function abrirLogin() {
    $('#listaTipoUsuario').val(1);      // Login de usuario
    $('.log-login').text('');
    $('.botao-anonimo').show();
    $('.titulo-sessao').text('Área do Aluno');
    $('.texto-sessao').text('Aluno, forneça seu usuário e senha para acessar o laboratório, ou entre de maneira anônima se quiser apenas conhecer o ambiente');
    $('.conteudo').addClass('oculta');
    $('.div-login').removeClass('oculta');
    $('.conteudo').removeClass('visivel');
    $('.botao-cadastrar').show();

}

function abrirLoginProfessor() {
    $('#listaTipoUsuario').val(2); // Login de professor      
    $('.log-login').text('');
    $('.botao-anonimo').hide();
    $('.titulo-sessao').text('Área do Professor');
    $('.texto-sessao').text('Professor, forneça seu usuário e senha para entrar na área de administração do laboratório');
    $('.conteudo').addClass('oculta');
    $('.div-login').removeClass('oculta');
    $('.conteudo').removeClass('visivel');
    $('.botao-cadastrar').hide();
}

function login() {
    //Remove texto informativo
    $('.log-login').show();

    var tipo = parseInt($('#listaTipoUsuario').val());

    // Recupera valores informados
    let user = $('#usuarioLogin').val();
    let pass = $('#senhaLogin').val();

    // Validação
    if (user == '' || pass == '') {
        $('.log-login').text('Campos vazios encontrados, por favor reveja.');
        return;
    }

    // Envio para confirmação
    $.ajax({
        url: 'banco/data.php',
        type: 'POST',
        data: { acao: 'validar_login', usuario: user, senha: pass, tipo: tipo },
        dataType: 'json',
        success: function (res) {
            if (res.sucesso) {
                $('.log-login').text('Sucesso, você será redirecionado para a sua página.');
                if (res.tipo === 3) {
                    // Sessão de aluno
                    window.location.href = 'area_aluno/index.php?aba=inicio';
                } else {
                    // Sessão de professor, criação e administração
                    window.location.href = 'area_professor/index.php?aba=inicio';
                }
                $('#usuarioLogin').val('');
                $('#senhaLogin').val('');
            } else {
                $('.log-login').text(res.log);
            }
        },
        error: function (res) {
            console.log(res);
        }
    });
}
function passagem(destino) {
    if (destino === 'laboratorio') {
        window.location.href = 'area_laboratorio/index.php'
    } else if (destino === 'administrador') {
        window.location.href = 'area_professor/index.html';
    }
}

function cadastrarUsuario() {
    cadastrar('banco/data.php', function () {
        abrirLogin();
        alterarIconeTipo();
    });
}

$("#usuarioLogin").keypress(function (e) {
    if (e.which == 13) {
        login();
    }
});
$("#senhaLogin").keypress(function (e) {
    if (e.which == 13) {
        login();
    }
});

$('.log-login').hide();