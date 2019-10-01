<div class="container">
  <div class="row">
    <div class="col-md-12 meuperfil">
      <h3>Meu perfil</h3>
      <h4>Aqui é possível atualizar os dados da sua conta</h4>
      <div id="dados" class="dados">
        <form>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="validationDefault01">Nome</label>
              <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-user"></i></span>
                </div>
                <input id="nome_novo" class="form-control" type="text" value="<?php echo ($_SESSION['nome']);?>">
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-4 mb-3">
              <label for="validationDefaultUsername">Senha</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input id="senha1" class="form-control" type="password" placeholder="Digite aqui..." required >
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="validationDefaultUsername">Confirme sua senha</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input id="senha2" class="form-control" type="password" placeholder="Digite aqui..." required >
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-4 mb-3">
              <label for="validationDefaultUsername">E-mail</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-envelope"></i></span>
                </div>
                <input required id="email_novo" class="form-control" type="email" value="<?php echo $_SESSION['email'];?>">
              </div>
            </div>
          </div>
          <button id = "salvar" type="button" class="btn btn-outline-primary" onclick="atualizarPerfil()">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function atualizarPerfil() {

      var nome = $('#nome_novo').val();
      var senha = $('#senha1').val();
      var confsenha = $('#senha2').val();
      var email = $('#email_novo').val();

      var emailValido = validateEmail(email);

      if(nome === "" || senha === "" || email === "" || confsenha === "") {
        //alert('Por favor, insira os dados que deseja alterar');
        alert("Por favor, preencha todos os campos.");

      } else {

        if(senha != confsenha) {
          alert('As senhas digitadas devem ser idênticas. Tente novamente');
       
        } else if (!emailValido) {
          alert('E-mail Inválido');
       
        } else {
          $.ajax({
            url:"funcoes/atualiza_perfil.php",
            type: 'POST',
            data: {
              nome: nome,
              senha: senha,
              email: email
            },
          }).done(function (data) {
            console.log(data);
            if(data.status == true) {
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
    
</script>