<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h3>
        <span>Práticas cadastradas da disciplina</span>
        <div class="form">
          <a href="<?php echo URL_SITE; ?>area_professor/index.php?aba=editaula&id_disciplina=<?php echo $_REQUEST['id_disciplina']; ?>" class="btn btn-primary">
            <span>Cadastrar nova prática</span>
            <i class="fas fa-angle-right"></i>
          </a>
        </div>
      </h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div>
        <?php
        $objModeloPratica = new ModeloPratica();
        $praticas = $objModeloPratica->getPraticasDisciplina($_REQUEST['id_disciplina']);
        if (count($praticas)) {
        ?>
        <table id="tabela" class="table table-striped table-bordered table-data" style="width:100%">
          <thead>
            <tr>
              <th>ID Prática</th>
              <th>Nome da Prática</th>
              <th>Disciplina</th>
              <th>Resumo</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ($praticas as $pratica) { ?>
                <tr>
                  <td><?php echo $pratica['id_modelo_pratica'] ?></td>
                  <td><?php echo $pratica['nome_pratica'] ?></td>
                  <td><?php echo $pratica['nome'] ?></td>
                  <td><?php echo $pratica['resumo'] ?></td>
                  <td>
                    <a class="btn btn-primary" href="<?php echo URL_SITE; ?>area_professor/index.php?aba=editaula&id_disciplina=<?php echo $pratica['id_disciplina']; ?>&id_pratica=<?php echo $pratica['id_modelo_pratica']; ?>">
                      <i class="fas fa-edit" aria-hidden="true"></i> EDITAR
                    </a>
                    <a class="btn btn-success" href="<?php echo URL_SITE; ?>area_laboratorio/lab.php?id_pratica=<?php echo $pratica['id_modelo_pratica'] ?>&tipo_acesso=treino">
                      <i class="far fa-eye"></i> Visualizar
                    </a>
                    <button id_modelo_pratica="<?php echo $pratica["id_modelo_pratica"] ?>" class="btn btn-danger deletar-pratica">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
            <?php
              }
      
            ?>
          </tbody>
        </table>
        <?php
        } else {
                echo "Não há práticas disponíveis para essa disciplina";
              }
        ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo URL_SITE; ?>plugins\vendor\bootbox\bootbox.all.min.js"></script>
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_professor/js/abas/aulas.js"></script>