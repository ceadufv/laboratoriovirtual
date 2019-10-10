<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="navegacao">
        <a href="<?php echo URL_SITE; ?>area_professor/index.php?aba=inicio">Administração</a> >
        <span class="disciplina_caminho"></span>
      </div>

      <h3>
        <span>Selecionar ambientes para práticas</span>
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

      <div class="minhasaulas">
        <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
        <h4>Práticas cadastradas</h4>
        <table id="tabela" class="table table-striped table-bordered table-data" style="width:100%">
          <thead>
            <tr>
              <th>Nome da Prática</th>
              <th>Resumo</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $objModeloPratica = new ModeloPratica();
            $praticas = $objModeloPratica->getPraticasDisciplina($_REQUEST['id_disciplina']);
            if (count($praticas)) {
              foreach ($praticas as $pratica) { ?>
                <tr>
                  <td><?php echo $pratica['nome_pratica'] ?></td>
                  <td><?php echo $pratica['resumo'] ?></td>
                  <td>
                    <a class="btn btn-primary" href="<?php echo URL_SITE; ?>area_professor/index.php?aba=editaula&id_disciplina=<?php echo $pratica['id_disciplina']; ?>&id_pratica=<?php echo $pratica['id_modelo_pratica']; ?>">
                      <i class="fas fa-edit" aria-hidden="true"></i> EDITAR
                    </a>
                  </td>
                  <td>
                    <a class="btn btn-success" href="<?php echo URL_SITE; ?>area_laboratorio/lab.php?id_pratica=<?php echo $pratica['id_modelo_pratica'] ?>&tipo_acesso=treino">
                      <i class="far fa-eye"></i> Visualizar
                    </a>
                  </td>
                  <td>
                    <button id="excluir-<?php echo $pratica["id_modelo_pratica"] ?>" class="btn vermelho" data-toggle="confirmation" data-title="Tem certeza que deseja excluir a prática?" data-placement="right" data-singleton="true" data-btn-ok-label="SIM " data-btn-ok-class="verde" data-btn-cancel-label="NÃO" data-btn-cancel-class="vermelho" data-title="Confirma exclusão?">
                      <i class="fas fa-trash-alt"></i>
                    </button>
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

<script type="text/javascript" src="<?php echo URL_SITE; ?>plugins\vendor\bootbox\bootbox.all.min.js"></script>
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_professor/js/abas/aulas.js"></script>