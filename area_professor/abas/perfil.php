<?php
  $objUsuario = new Usuario();

  $dados = $objUsuario->getAlunoEspecifico($_SESSION['id_usuario']);

  if($_POST["acao"] == 'salvar') {

  }


?>
<script type="text/javascript" src="js/abas/perfil.js"></script>
<div class="container">
  <form>
    <div class="row">
      <div class="col">  
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" class="form-control" id="nome" placeholder="Digite seu nome...">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">    
        <div class="form-control">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" id="senha" placeholder="Digite sua senha...">

            <label for="senha2">Digite novamente a senha</label>
            <input type="password" class="form-control" id="senha2" placeholder="Digite novamente a mesma senha...">
        </div>    
      </div>
    </div>
    <div class="col">
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail...">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
  </div>
</div>