<?php
$objUsuario = new Usuario();

$dados = $objUsuario->getAlunoEspecifico($_SESSION['id_usuario']);

if ($_POST["acao"] == 'atualizar') { 


  print_r($_POST);
  die;
  $objUsuario->atualizarDadosPerfil($_POST);
}
?>

<div class="container">
  <h3>Meu perfil</h3>
  <p>Aqui é possível atualizar os dados da sua conta.</p>
  <form id="aluno" name="aluno" method="post" action="<?php echo URL_SITE; ?>area_professor/index.php?aba=perfil&cadastro=ok" enctype="multipart/form-data">
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" placeholder="Digite seu nome..." value="<?php echo $dados["nome"]?>">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
          <label for="email">E-mail</label>
          <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail..." value="<?php echo $dados["email"]?>">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="senha">Senha</label>
        <input type="password" class="form-control" id="senha" placeholder="Digite sua senha...">
      </div>
      <div class="form-group col-md-4">
        <label for="senha2">Digite novamente sua senha</label>
        <input type="password" class="form-control" id="senha2" placeholder="Digite a mesma senha...">
      </div>
    </div>
    <input type="submit" class="btn btn-primary" value="Salvar">
    <input type="hidden" name="acao" value="atualizar">
  </form>
</div>

<script type="text/javascript" src="js/abas/perfil.js"></script>