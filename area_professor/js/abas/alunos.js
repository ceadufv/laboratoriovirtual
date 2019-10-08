$(document).ready(function() {
    var url_site = URL_SITE;

    $(".reset_senha").click(function(dados) {
          var dados = new Array();
          dados.push({'value': $('#reset').attr('cod-usuario'), 'name': 'cod_usuario'});
          dados.push({'value': $('#reset').attr('nome-usuario'), 'name': 'nome_usuario'});
          confirmarResetSenhaAluno(dados);
    });


    function confirmarResetSenhaAluno(dados) {

        $.ajax({
            type: "POST",
            url: url_site+'area_professor/index.php?aba=alunos',
            data: dados,
            
            success: function(data) {
                var msg = 'Tem certeza que deseja resetar a senha desse aluno?';

                bootbox.confirm({
                    message: msg,
                    callback: function (result) {
                        if(dados){
                            if(result){
                                resetarSenhaAluno(dados);
                            } 
                        }
                    },
                    error: function(erro) {
                        alert('erro');
                    },
                });
            }
        });
    }

    function resetarSenhaAluno(dados) {
        dados.push({'value': 'S', 'name': 'confirmado'});

        $.ajax({
			method: "POST",
			url: url_site + 'area_professor/index.php?aba=alunos',
			data: dados
		})
		.done(function (dados) {
            alert('Senha alterada com sucesso para 123456');
			//$('.modal-content').html(dados);
		});
    }
});