<?php
if ($_POST['acao'] == 'insert') {
    $objModeloPraticaSolucao = new ModeloPraticaSolucao();
    $composicao = array();
    foreach ($_POST['composicao_id'] as $key => $value) {
        $composicao[] = array(
            "id" => $_POST['composicao_id'][$key],
            "nome" => $_POST['composicao_nome'][$key],
            "concentracao" => $_POST['composicao_concentracao'][$key],
        );
    }
    $_POST['composicoes'] = json_encode($composicao);
    if ($objModeloPraticaSolucao->insertSolucaoPratica($_POST)) {

        $solucoes = $objModeloPraticaSolucao->getSolucoesPratica($_POST['id_pratica']);
        $html = $objModeloPraticaSolucao->getItensHtml($solucoes);

        $resp = array('success' => true, 'msg' => 'Inserido com Sucesso!', 'html' => $html);
    } else
        $resp = array('success' => true, 'msg' => 'Erro ão inserir!');

    echo json_encode($resp);
    exit();
}

if ($_POST['acao'] == 'update') {
    $objModeloPraticaSolucao = new ModeloPraticaSolucao();
    $composicao = array();
    foreach ($_POST['composicao_id'] as $key => $value) {
        $composicao[] = array(
            "id" => $_POST['composicao_id'][$key],
            "nome" => $_POST['composicao_nome'][$key],
            "concentracao" => $_POST['composicao_concentracao'][$key],
        );
    }
    $_POST['composicoes'] = json_encode($composicao);
    if ($objModeloPraticaSolucao->updateSolucaoPratica($_POST)) {
        $solucoes = $objModeloPraticaSolucao->getSolucoesPratica($_POST['id_pratica']);
        $html = $objModeloPraticaSolucao->getItensHtml($solucoes);
        $resp = array('success' => true, 'msg' => 'Salvo com sucesso!', 'html' => $html);
    } else
        $resp = array('success' => true, 'msg' => 'Erro ão salvar!');

    echo json_encode($resp);
    exit();
}

$objModeloPraticaSolucao = new ModeloPraticaSolucao();
if (!empty($_GET['cod_moprsi'])) {
    $solucao_s = $objModeloPraticaSolucao->getSolucao($_GET['cod_moprsi']);
    $composicoes = json_decode($solucao_s['composicoes'], true);
}

?>
<form method="post" id="form-solucoes">
    <?php if (empty($_GET['cod_moprsi'])) { ?>
        <input type="hidden" value="insert" name="acao" />
    <?php } else { ?>
        <input type="hidden" value="update" name="acao" />
        <input type="hidden" value="<?php echo $_GET['cod_moprsi']; ?>" name="cod_moprsi" />
    <?php } ?>

    <input type="hidden" value="<?php echo $_GET['id_pratica']; ?>" name="fk_cod_mopr" />
    <input type="hidden" value="<?php echo $_GET['id_pratica']; ?>" name="id_pratica" />

    <section class="criarnovasolucao">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if (empty($_GET['cod_moprsi'])) { ?>
                        <h3>Criar nova solução</h3>
                    <?php } else { ?>
                        <h3>Editar solução</h3>
                    <?php } ?>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="col-12">
                    <div class="box">
                        <h4>Rótulo</h4>
                        <h5>Nome:</h5>
                        <textarea required name="nome_moprsi" rows="1" cols="20" placeholder="Insira o nome da solução"><?php echo $solucao_s['nome_moprsi'] ?></textarea>
                        <h5>Descrição:</h5>
                        <textarea required name="desc_moprsi" rows="3" cols="20" placeholder="Insira a descrição da solução"><?php echo $solucao_s['desc_moprsi'] ?></textarea>
                        <h5>Responsável pelo preparo:</h5>
                        <input required name="resp_moprsi" type="text" value="<?php echo $solucao_s['resp_moprsi'] ?>">
                        <h5>Data de criação:</h5>
                        <select name="data_criacao_moprsi" class="custom-select" required>
                            <option value="1" <?php echo ($solucao_s['data_criacao_moprsi'] == 1 ? 'selected' : ''); ?>>Dia da aula </option>
                            <option value=2 <?php echo ($solucao_s['data_criacao_moprsi'] == 2 ? 'selected' : ''); ?>>Dia anterior à aulas </option>
                            <option value=3 <?php echo ($solucao_s['data_criacao_moprsi'] == 3 ? 'selected' : ''); ?>>Cerca de uma semana antes da aula </option>
                            <option value=4 <?php echo ($solucao_s['data_criacao_moprsi'] == 4 ? 'selected' : ''); ?>>Cerca de um mês antes da aula </option>
                            <option value=5 <?php echo ($solucao_s['data_criacao_moprsi'] == 5 ? 'selected' : ''); ?>>Cerca de dois meses antes da aula </option>
                        </select>

                        <br />
                        <div class="form-group">
                            <label><b>Adicionar no armario?</b></label>
                            <select name="armario_moprsi" class="form-control" required>
                                <option value="S" <?php echo ($solucao_s['armario_moprsi'] == 'S' ? 'selected' : ''); ?>>SIM</option>
                                <option value="N" <?php echo ($solucao_s['armario_moprsi'] == 'N' ? 'selected' : ''); ?>>NÃO</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <hr />         
            <div class="row">
                <div class="col-6 concentracao" style="margin: 20px 0;">
                    <div class="box">
                        <h4>Composição</h4>
                        <select id="especies_disponiveis" name="especies_disponiveis" class="custom-select">
                            <?php
                            $objSubstancias = new Substancias();
                            $substancias = $objSubstancias->getAllSubstancias();
                            foreach ($substancias as $res) {
                                ?>
                                <option value="<?php echo $res['id_substancia'] ?>"><?php echo $res['nome'] ?></option>
                            <?php };
                            ?>
                        </select>
                    </div>

                    <div class="box">
                        <h4>Concentração (mol/L)</h4>
                        <input name="especies_concentracao" id="especies_concentracao" autofocus min="0" value="0.1" type="number" step="0.1" />
                        <button type="button" onclick="adicionar_especie()" class="btn verde">Adicionar</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="especienasolucao">
                        <h5>Espécies na Solução</h5>
                        <table>
                            <tbody id="especies_na_solucao">
                                <tr>
                                    <td class="align-self-center" width=350 colspan=4></td>
                                </tr>
                                <?php
                                foreach ($composicoes as $key => $composicao) { ?>
                                    <tr class="linha_composicao" data-id="<?php echo $composicao['id']; ?>" data-nome="<?php echo $composicao['nome']; ?>" data-value="<?php echo $composicao['concentracao']; ?>">
                                        <td class="nomes_composicao"><?php echo $composicao['nome']; ?></td>
                                        <td class="conc_lista_solucao"><?php echo $composicao['concentracao']; ?></td>
                                        <td> mol/L</td>
                                        <td><button class="btn vermelho" onclick="deletar_linha(this)">Excluir </button></td>
                                        <input type="hidden" name="composicao_id[]" value="<?php echo $composicao['id']; ?>">
                                        <input type="hidden" name="composicao_nome[]" value="<?php echo $composicao['nome']; ?>">
                                        <input type="hidden" name="composicao_concentracao[]" value="<?php echo $composicao['concentracao']; ?>">
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr />
                    <button type="submit" class="btn btn-primary btn-criar btn-lg"> Salvar </button>
                    <button type="button" class="btn btn-primary btn-criar" onclick="$('#modal_solucao').modal('hide')"> Cancelar </button>
                </div>

            </div>
    </section>
</form>

<script src="<?php echo URL_SITE; ?>area_professor/js/abas/xhr-solucao-pratica.js"></script>