function cadastrar(url, f) {

  //Remove texto informativo
  $('.log-cadastrar').remove();

  // Recolhe informações digitadas
  let nome = $('#nomeCadastro').val();
  let email = $('#emailCadastro').val();
  let usuario = $('#usuarioCadastro').val();
  let senha = $('#senhaCadastro').val();
  let tipo = $('#listaTipoUsuario').val();

  var emailValido = validarEmail(email);
  console.log(emailValido)

  // Controle de erros
  if(nome === '' || email === '' || usuario === '' || senha === '' || tipo === '') {
    $('#logCadastrar').append('<p class="log-cadastrar">Informações insuficientes, por favor revise</p>');
    return;
  }
  if(!emailValido) {
    $('#logCadastrar').append('<p class="log-cadastrar">Informe um endereço de e-mail válido.</p>');
    return;
  }

  // Envio de informações para o banco
  $.ajax({
    url: url,
    type: 'POST',
    data: { acao: 'cadastrar_usuario', nome: nome, email: email, usuario: usuario, senha: senha, acesso: tipo },
    dataType: 'json',
    success: function(res) {
      if(res.sucesso) {
              // Exibe log
              $('.log-login').text('Cadastro efetuado com sucesso, você já pode utilizar as funcionalidades do sistema.');

              // Apaga os dados na tela
              $('#nomeCadastro').val('');
              $('#emailCadastro').val('');
              $('#usuarioCadastro').val('');
              $('#senhaCadastro').val('');
              $('#listaTipoUsuario').val('');

              f(res);
            } else {
              $('#logCadastrar').append('<p class="log-cadastrar">' + res.log + '</p>');
            }
          },
          error: function(res) {
            console.log(res);
          }
        });
}

// https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
function validarEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function alterarIconeTipo() {
  let tipo = $('#listaTipoUsuario').val();
  $('.icone-alt').remove();
  if(tipo === '1') {
    $('#iconeAlt1').append('<i class="fas fa-user-graduate icone-alt"></i>');
  } else if(tipo === '2') {
    $('#iconeAlt1').append('<i class="fas fa-chalkboard-teacher icone-alt"></i>');
  } else {
    $('#iconeAlt1').append('<i class="fas fa-question icone-alt"></i>');
  }
}
