<script type="text/javascript" src="../plugins/vendor/bootbox/bootbox.js"></script>
<script type="text/javascript" src="js/abas/alunos.js"></script>

<?php
$objUsuario = new Usuario();
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h3>
        <span>Meus Alunos</span>
      </h3>

      <p>Gerenciamento de alunos</p>
      <table id="tabela" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th scope="col">Usuário</th>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col">Resetar Senha</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // Lista as praticas disponiveis para o aluno
            $dados = $objUsuario->getAlunos();

            if (!empty($dados)) {
              foreach ($dados as $row) {
          ?>
              <tr>
                <td><?php echo $row['usuario'] ?></td>
                <td><?php echo $row['nome'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td>
                  <button class='btn btn-danger reset_senha' nome-usuario='<?php echo $row["nome"] ?>' cod-usuario='<?php echo $row["id_usuario"] ?>'>Resetar</button>
                </td>
              </tr>
          <?php
            }
          } else {
            echo "Nenhum aluno cadastrado";
          }
          ?>
        </tbody>
      </table>
      <?php
        if ($_POST["acao"] == 'salvar') {
          if($objUsuario->insertAluno($_POST)) {
            if ($_GET["cadastro"] == 'ok')
              echo ('<div class="alert alert-success" role="alert">Aluno salvo com sucesso! A senha padrão é 123456, aconselhe seus alunos a alterarem a senha no primeiro acesso.</div>');
            }
        }
        ?>

      <div class="adicionaraluno">
        <button class="btn azul" type=button data-toggle="collapse" href="#adicionarAluno"><i class="fas fa-plus-circle"></i> Cadastrar novo aluno</button>
        <div class="collapse" id="adicionarAluno">
          <form id="aluno" name="aluno" method="post" action="<?php echo URL_SITE; ?>area_professor/index.php?aba=alunos&cadastro=ok" enctype="multipart/form-data">
            <table class="table">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Usuário</th>
                  <th>E-mail</th>
                </tr>
              </thead>
              <tbody>
                <td><input id="nome_aluno" name="nome_aluno" class="form-control input-disciplina" type="text" placeholder="Insira o nome" focus required></td>
                <td><input id="usuario_aluno" name="usuario_aluno" class="form-control input-disciplina" type="text" placeholder="Insira o nome de usuário" required></td>
                <td><input type="email" id="email_aluno" name="email_aluno" class="form-control input-disciplina" type="email" placeholder="Digite o email" required></td>
              </tbody>
            </table>
            <input type="submit" class="btn btn-primary" value="Salvar">
            <input type="hidden" name="acao" value="salvar">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
//se confirmado, reseta a senha do aluno para 123456
if ($_POST['resetar'] == 'S') {
  //reseta a senha para 123456

  $objUsuario->resetarSenhaAluno($_POST['cod_usuario']);
  exit();
}
?>