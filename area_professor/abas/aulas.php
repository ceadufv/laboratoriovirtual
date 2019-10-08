<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="navegacao">
        <a href="<?php echo URL_SITE;?>area_professor/index.php?aba=inicio">Administração</a> >
        <span class="disciplina_caminho"></span>
      </div>

      <h3>
        <span>Selecionar ambientes para práticas</span>
        <div class="form">
          <a href="../area_professor/index.php?aba=editaula&id_disciplina=<?php echo $_REQUEST['id_disciplina']; ?>" class="btn btn-primary">
            <span>Cadastrar nova prática</span>
            <i class="fas fa-angle-right"></i>
          </a>
        </div>
      </h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="minhasaulas">
        <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
        <h4>Práticas cadastradas</h4>

        <ul class="list-unstyled">
          <?php
          $sql = $lab->getAulas($_REQUEST['id_disciplina']);
          if (count($sql)) {

            foreach ($sql as $row) { ?>
              <li id='<?php echo $row["id"] ?>'>
                <span class="option inactive" id='<?php echo $row["id"] ?>'>
                  <h4><?php echo $row["nome_pratica"];?></h4>
                  <p><?php echo $row["resumo"];?></p>
                </span>
                <span>
                  <button type="button" class="btn btn-primary" onclick="edit_pratica(<?php echo $row['id'] ?>)"><i class="fas fa-edit" aria-hidden="true"></i> EDITAR</button>
                  <a type="button" class="btn btn-primary" href="<?php echo URL_SITE;?>area_laboratorio/lab.php?id_pratica=<?php echo $row['id'] ?>&tipo_acesso=treino">
                    <i class="far fa-eye"></i> Visualizar
                  </a>

                  <button id="excluir-<?php echo $row["id"] ?>" class="btn vermelho" data-toggle="confirmation" data-title="Tem certeza que deseja excluir a prática?" data-placement="right" data-singleton="true" data-btn-ok-label="SIM " data-btn-ok-class="verde" data-btn-cancel-label="NÃO" data-btn-cancel-class="vermelho" data-title="Confirma exclusão?">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                  <script>
                    $('[data-toggle=confirmation]').confirmation({
                      rootSelector: '[data-toggle=confirmation]',
                      container: 'body',
                      onConfirm: function() {
                        deletarPratica(<?php echo $row["id"] ?>);
                      },
                      onCancel: function() {},
                    });
                  </script>
                </span>
              </li>
          <?php }
          } else {
            echo "Não há práticas cadastradas";
          } ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo URL_SITE;?>area_professor/js/abas/aulas.js"></script>