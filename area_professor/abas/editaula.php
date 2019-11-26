<?php
if ($_POST['acao'] == 'salvar-dados') {

  header("Conten-type: application/json; charset=utf-8");

  $objBequer = new Bequer();
  $objBalaoVolumetrico = new BalaoVolumetrico();
  $objModeloPratica = new ModeloPratica();
  $objPipetaVolumetrica = new PipetaVolumetrica();
  $objPipetador = new Pipetador();
  $objMicroPipeta = new MicroPipeta();
  $objCubeta = new Cubeta();

  $dados = $_POST;
  if (empty($dados['nome_pratica'])) {
    echo json_encode(array('success' => false, 'msg' => 'Título da pratica é inválido', 'id' => 0));
    exit();
  }

  if (empty($dados['resumo_pratica'])) {
    echo json_encode(array('success' => false, 'msg' => 'Título da pratica é inválido', 'id' => 0));
    exit();
  }

  //bequers
  $new_data = array();
  $new_data['bequers'] = $objBequer->getJsonForm($dados);

  //balao
  $new_data['baloes'] = $objBalaoVolumetrico->getJsonForm($dados);

  //pipeta
  $new_data['pipeta_volumetrica'] = $objPipetaVolumetrica->getJsonForm($dados);

  //pipetador
  $new_data['pipetadores'] = $objPipetador->getJsonForm($dados);

  //cubeta
  $new_data['cubetas'] = $objCubeta->getJsonForm($dados);

  //micropipeta
  $new_data['micropipetas'] = $objMicroPipeta->getJsonForm($dados);

  //outros

  //frascos default
  $new_data['frascos'] = (new Frasco())->getDefaultItens();
  
  //ponteira default
  $new_data['ponteiras'] = (new Ponteira())->getDefaultItens();

  $args = array();
  $args['nome'] = $dados['nome_pratica'];
  $args['resumo'] = $dados['resumo_pratica'];
  $args['fk_id_cenario'] = $dados['fk_id_cenario'];
  $args['id_disciplina'] = $dados['id_disciplina'];
  $args['id_modelo_pratica'] = $dados['id_modelo_pratica'];
  $args['disponivel_mopr'] = $dados['disponivel_mopr'];
  $args['fk_cod_mopr_u_us'] = $dados['fk_cod_mopr_u_us'];
  $args['data'] = json_encode($new_data);
  $id = $objModeloPratica->salvarPratica($args);
  if (empty($id)) {
    echo json_encode(array('success' => false, 'msg' => 'Dados inválidos', 'id_modelo_pratica' => $id));
  } else {
    echo json_encode(array('success' => true, 'msg' => 'A aula foi salva com sucesso', 'id_modelo_pratica' => $id));
  }
  exit();
}

//get pratica
$objModeloPratica = new ModeloPratica();
$objModeloPraticaArquivo = new ModeloPraticaArquivo();
if (!empty($_GET['id_pratica'])) {
  $pratica_sel = $objModeloPratica->getPraticaPorCod($_GET['id_pratica']);
  //arquivos caderno
  $arquivos = $objModeloPraticaArquivo->getArquivosPratica($pratica_sel['id_modelo_pratica'], 'CADERNO');
  $html_arquivos_caderno = $objModeloPraticaArquivo->getItensHtml($arquivos);
  //arquivos roteiro
  $arquivos = $objModeloPraticaArquivo->getArquivosPratica($pratica_sel['id_modelo_pratica'], 'ROTEIRO');
  $html_arquivos_roteiro = $objModeloPraticaArquivo->getItensHtml($arquivos);
} else {
  $pratica_sel = NULL;
}
?>
<form action="" method="post" id="formlulario-edita-aula">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3>
          <?php if (!$pratica_sel) { ?>
            <span>Cadastrar nova prática</span>
          <?php } else { ?>
            <span>Atualizar prática</span>
          <?php } ?>
          <div class="form">
            <a href='<?php echo URL_SITE; ?>area_professor/index.php?aba=aulas&id_disciplina=<?php echo $_REQUEST['id_disciplina']; ?>' class="btn btn-primary"><i class="fas fa-angle-left"></i> VOLTAR</a>
            <?php if ($pratica_sel['id_modelo_pratica']) { ?>
              <a href='<?php echo URL_SITE; ?>area_laboratorio/lab.php?id_pratica=<?php echo $pratica_sel['id_modelo_pratica']; ?>&tipo_acesso=treino' class="btn btn-success"><i class="far fas fa-eye"></i> VISUALIZAR</a>
            <?php } ?>
            <button type="submit" class="btn btn-success salvar-pratica">Salvar</button>
          </div>
        </h3>


        <div class="form-group">
          <label>ID SAVE</label>
          <input type="number" <?php echo (empty($_GET['id_pratica']) ? 'disabled' : '')?> name="fk_cod_mopr_u_us" value="<?php echo $pratica_sel['fk_cod_mopr_u_us']; ?>" class="form-control" placeholder="Digite aqui o id do save para carregar o laboratório montado para o aluno" />
        </div>

        <div class="form-group">
          <label>TÍTULO</label>
          <input name="nome_pratica" value="<?php echo $pratica_sel['nome_pratica']; ?>" class="form-control" type="text" placeholder="Digite aqui..." required />
        </div>

        <div class="form-group">
          <label>RESUMO</label>
          <textarea name="resumo_pratica" class="form-control" placeholder="Digite aqui..." required cols="12" rows="4"><?php echo $pratica_sel['resumo']; ?></textarea>
        </div>



        <input type="hidden" name="id_cenario" value="1" />
        <input type="hidden" name="id_modelo_pratica" value="<?php echo $_GET['id_pratica']; ?>" />
        <input type="hidden" name="id_disciplina" value="<?php echo $_GET['id_disciplina']; ?>" />

        <div id="accordion" class="accordion">
          <!-- solucoes --><?php include_once "abas/steps_aula/solucoes.php";  ?>
          <!-- /solucoes -->
          <!-- material --><?php include_once "abas/steps_aula/material_didatico.php"; ?>
          <!-- cenarios --><?php include_once "abas/steps_aula/cenarios.php"; ?>
          <!-- bequer --><?php include_once "abas/steps_aula/bequers.php"; ?>
          <!-- /bequer -->
          <!-- balao_volumetrico --><?php include_once "abas/steps_aula/balao_volumetrico.php"; ?>
          <!-- /balao_volumetrico -->
          <!-- pipeta_volumetrica --><?php include_once "abas/steps_aula/pipeta_volumetrica.php"; ?>
          <!-- /pipeta_volumetrica -->
          <!-- pipetador --><?php include_once "abas/steps_aula/pipetador.php"; ?>
          <!-- /pipetador -->
          <!-- micro_pipeta --><?php include_once "abas/steps_aula/micro_pipeta.php"; ?>
          <!-- /micro_pipeta -->
          <!-- proveta --><?php include_once "abas/steps_aula/proveta.php"; ?>
          <!-- /proveta -->
          <!-- cubeta --><?php include_once "abas/steps_aula/cubeta.php"; ?>
          <!-- /cubeta -->
          <!-- espatula --><?php include_once "abas/steps_aula/espatula.php"; ?>
          <!-- /micro_pipeta -->

          <div class="form-group">
            <label>Deixar aula disponivel aos alunos</label>
            <select name="disponivel_mopr" class="form-control">
              <option value="S">SIM</option>
              <option value="N" <?php echo ($pratica_sel['disponivel_mopr'] == 'N' ? 'selected' : ''); ?>>NÃO</option>
            </select>
          </div>

          <div style="padding-top:10px;">
            <button id="salvar" type="submit" class="btn btn-success">Salvar</button>
          </div>
        </div><!-- /acordion -->
      </div> <!-- /col -->
    </div><!-- /row -->
  </div><!-- /container -->
</form><!-- /form -->

<script type="text/javascript" src="js/abas/editaula.js"></script>