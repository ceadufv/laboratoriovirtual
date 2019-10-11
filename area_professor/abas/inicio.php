<?php 
  $objDisciplina = new Disciplina();

  if($_POST["acao"] == 'salvarDisciplina') {
    $objDisciplina->insertDisciplina($_POST);

  }
?>

<div class="container">
  <div class="conteudocriacaopraticas">
    <div class="row">
      <div class="administrar col-md-12">
        <h3>
          <span>Administrar Disciplinas</span>
          <div class="form">
          </div>
        </h3>

        <button class="btn btn-primary" type=button data-toggle="collapse" href="#adicionarDisciplina"><i class="fas fa-plus-circle"></i> Adicionar disciplina</button>
        <br>
        <br>
        <div class="collapse" id="adicionarDisciplina">
          <div class="card card-body">
            <div class="form-row">
                <label class="my-1 mr-2" for="inlineFormCustomSelectPref"><b>Nome da disciplina:</b></label>
                <form id="formulario" method="post" action="<?php echo URL_SITE; ?>area_professor/index.php?aba=inicio" enctype="multipart/form-data">
                  <input autofocus id="nome_disciplina" name="nome_disciplina" class="input-disciplina" type="text" placeholder="Digite o nome" required>
                  <input type="submit" class="btn btn-primary salvarDisciplina" value="Salvar">
                  <input type="hidden" id="acao" name="acao" value="salvarDisciplina">
                  <input type="hidden" id="id_professor" name="id_professor" value="<?php echo $_SESSION['id_usuario'] ?>">
                </form>
              </div>
          </div>
        </div>

        <table id="tabela" class="table table-striped table-bordered table-data" style="width:100%">
          <thead>
            <tr>
              <th>Nome da disciplina</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // Lista as praticas disponiveis para o aluno
              $dados = $objDisciplina->getDisciplinasProfessor($_SESSION['id_usuario']);

              if (!empty($dados)) {
                foreach ($dados as $row) {
            ?>
                <tr>
                  <td><?php echo $row['nome'] ?></td>
                  <td>
                    <a class="btn btn-success" href="<?php echo URL_SITE; ?>area_professor/index.php?aba=aulas&id_disciplina=<?php echo $row['id_disciplina'];?>"><i class="far fa-eye"></i> Acessar</a>
                    <button class="btn btn-danger removerDisciplina" id_disciplina="<?php echo $row['id_disciplina'] ?>"><i class="fas fa-minus-circle"></i> Remover </button>
                  </td>
                </tr>
            <?php
              }
            } else {
              echo "Não há práticas disponíveis";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="../plugins/vendor/bootbox/bootbox.js"></script>
<script src="<?php echo URL_SITE; ?>area_professor/js/abas/inicio.js"></script>