$(document).ready(function () {

    $(".atualizar").click(function(dados) {
        atualizarPerfil();
    });
    
    function atualizarPerfil() {
        var nome = $('#nome_novo').val();
        var senha = $('#senha1').val();
        var confsenha = $('#senha2').val();
        var email = $('#email_novo').val();

        var emailValido = validateEmail(email);

        if (nome === "" || senha === "" || email === "" || confsenha === "") {
            //alert('Por favor, insira os dados que deseja alterar');
            alert("Por favor, preencha todos os campos.");

        } else {

            if (senha != confsenha) {
                alert('As senhas digitadas devem ser idênticas. Tente novamente');

            } else if (!emailValido) {
                alert('E-mail Inválido');

            } else {
                $.ajax({
                    url: URL_SITE + "area_aluno/index-app.php?app=usuario&file=atualiza-perfil",
                    type: 'POST',
                    data: {
                        nome: nome,
                        senha: senha,
                        email: email
                    },
                }).done(function (data) {
                    console.log(data);
                    if (data.status == true) {
                        //Se for positivo, mostra ao utilizador uma janela de sucesso.
                        alert('Informações salvas com sucesso!');
                    } else {
                        //Caso contrário dizemos que aconteceu algum erro.
                        alert('Erro com banco de dados. Tente novamente mais tarde. Se persistir o erro, contate o administrador.');
                    }
                });
            }
        }
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});