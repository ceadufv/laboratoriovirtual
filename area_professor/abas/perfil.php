<?php
  $objUsuario = new Usuario();

  if ($_POST["acao"] == 'atualizar') {
    $_POST["id_usuario"] = $_SESSION['id_usuario'];

    if($_POST["senha"] == $_POST["senha2"]) {
        $objUsuario->atualizarDadosPerfil($_POST);
    } else {
        echo ('<div class="alert alert-danger" role="alert">As senhas digitadas não conferem!</div>');  
    }
  }
  $dados = $objUsuario->getAlunoEspecifico($_SESSION['id_usuario']);
?>

<div class="container">
  <h3>Meu perfil</h3>
  <p>Aqui é possível atualizar os dados da sua conta.</p>
  <form id="aluno" name="aluno" method="post">
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="far fa-user"></i></span>
          </div>      
            <input type="text" class="form-control" name="nome" placeholder="Digite seu nome..." value="<?php echo $dados["nome"]?>" required>
        </div>
      </div>
      <div class="form-group col-md-4">
        <label for="usuario">Login</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="far fa-user"></i></span>
          </div>      
          <input type="text" class="form-control" name="usuario" placeholder="Digite seu nome de usuário..." value="<?php echo $dados["usuario"]?>" required>
        </div>
      </div>      
      <div class="form-group col-md-4">
        <label for="email">E-mail</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-envelope"></i></span>
            </div>               
            <input type="email" class="form-control" name="email" placeholder="Digite seu e-mail..." value="<?php echo $dados["email"]?>" required>
          </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="senha">Senha</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
          </div>              
          <input type="password" class="form-control" name="senha" placeholder="Digite sua senha..." required>
        </div>
      </div>
      <div class="form-group col-md-4">
        <label for="senha2">Digite novamente sua senha</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
          </div>              
          <input type="password" class="form-control" name="senha2" placeholder="Digite a mesma senha..." required>
        </div>
      </div>
    </div>
    <input type="submit" class="btn btn-primary" value="Salvar">
    <input type="hidden" name="acao" value="atualizar">
  </form>
</div>

<script type="text/javascript" src="js/abas/perfil.js"></script>