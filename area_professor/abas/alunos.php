<script type="text/javascript" src="../plugins/vendor/bootbox/bootbox.js"></script>
<script type="text/javascript" src="js/abas/alunos.js"></script>


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h3>
        <span>Meus Alunos</span>
      </h3>

      <p>Gerenciamento de alunos. Aqui é possível ver a lista de alunos que você acompanha, deletar do acompanhamento e adicionar novos.</p>

      <table class="table" id="tabela">
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
          $sql = $lab->getAlunos($_SESSION['id_usuario']);
          if (count($sql)) {
            foreach ($sql as $row) {
              echo "<tr>" .
                "<td>" . $row["usuario"] . "</td>" .
                "<td>" . $row["nome"] . "</td>" .
                "<td>" . $row["email"] . "</td>" .
                "<td>
                  <button id='reset' class='btn btn-danger reset_senha' nome-usuario=".$row["nome"]." cod-usuario=".$row["id_usuario"].">Resetar</button>
                </td>
                </tr>";
            }
          } else {
            echo "Nenhum aluno cadastrado";
          }
          ?>
        </tbody>
      </table>
      
      <div class="adicionaraluno">
      <?php 
        if($_GET['cadastro'] == 'ok') {
          echo ('<div class="alert alert-success" role="alert">Aluno salvo com sucesso! A senha padrão é 123456, aconselhe seus alunos a alterarem a senha no primeiro acesso.</div>');
        }
      ?>

        <button class="btn azul" type=button data-toggle="collapse" href="#adicionarAluno"><i class="fas fa-plus-circle" ></i> Cadastrar novo aluno</button>
        
        <div class="collapse" id="adicionarAluno">

          <form id="aluno" method="post" action="<?php echo URL_SITE;?>area_professor/index-app.php?app=usuario&file=insert-aluno" enctype="multipart/form-data">
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
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="hidden" name="acao" value="salvar">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  //se confirmado, reseta a senha do usuário para 123456
		if($_POST['confirmado'] == 'S') {
      $lab->resetarSenhaAluno($_POST['cod_usuario']);
			exit();
		}
?>