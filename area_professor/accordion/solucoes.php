
<div class="solucoes">

  <div class="solucoespreparadas">
    <h3>
      <span>Soluções já preparadas:</span>
      <button class="botao_criar_solucao btn azul" onclick="criar_solucao()" class="btn btn-primary" data-toggle="modal" data-target=".modal-edit-solucao"><i class="fas fa-plus-circle"></i> CRIAR NOVA SOLUÇÃO</button>
    </h3>

    <div class="composicao">

      <div>
        <select id="select_solucoes" class="custom-select">
          <?php 
          global $banco;
          try {
            $solucoes = $banco -> prepare('SELECT * FROM solucoes');
            $solucoes -> execute();
            $o = $solucoes -> fetchAll(PDO::FETCH_ASSOC);

            foreach ($o as $res) { ?>
              <option value=<?php echo $res['id_solucao']?> descricao="<?php echo $res['descricao'] ?>" ><?php echo $res['nome']?></option>
            <?php };
          } catch(PDOException $e) {
            echo json_encode(array('sucesso' => false, 'log' => $e -> getMessage()));
          }
          ?>
        </select>
        <div class="composicao_solucao_option"><h4>COMPOSIÇÃO: <?php echo $o[0]['descricao'] ?></h4></div>
      </div>
      <div>
        <button class="botao_adicionar btn verde" onclick="adicionar_solucao_armario()">Adicionar ao Armário de Soluções</button>
        <button class="botao_editar_solucao btn verde" onclick="editar_solucao()" class="btn btn-primary" data-toggle="modal" data-target=".modal-edit-solucao">EDITAR SOLUÇÃO</button>
      </div>

    </div>

  </div>
  <table class="armario form-row">
      <thead>
          <tr>
              <td class="align-self-center" width=350 colspan=4 >
              <h3>ARMÁRIO</h3>
              </td>
          </tr> 
      </thead>
      <tbody id="lista_solucoes_pratica">
          <tr>
              <td class="align-self-center" width=350 colspan=4 >
              </td>
          </tr>
      <tbody>
  </table>
  </div>

  <div class="modal fade bd-example-modal-lg modal-edit-solucao" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <?php include('funcoes/edit_solucao.php') ?>
      </div>
    </div>
  </div>