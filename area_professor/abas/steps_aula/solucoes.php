<div class="card">
    <div class="card-header" id="headingOne">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#solucoes" aria-expanded="true" aria-controls="collapseOne">
                <strong><i class="fas fa-check-circle ativo"></i> Soluções</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="solucoes" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
            <!-- solucoes -->

            <div class="solucoes">

                <div class="solucoespreparadas">
                    <h3>
                        <span>Soluções já preparadas:</span>
                        <button type="button" class="botao_criar_solucao btn azul" onclick="editar_solucao(true)" class="btn btn-primary" data-toggle="modal" data-target=".modal-edit-solucao"><i class="fas fa-plus-circle"></i> CRIAR NOVA SOLUÇÃO</button>
                    </h3>

                    <div class="composicao">
                        <div>
                            <select id="select_solucoes" class="custom-select">
                                <?php
                                /*
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
*/
                                ?>
                            </select>
                            <div class="composicao_solucao_option">
                                <h4>COMPOSIÇÃO: <?php echo $o[0]['descricao'] ?></h4>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="botao_editar_solucao btn verde" onclick="editar_solucao(false)" class="btn btn-primary"><i class="fa fa-pen"></i> EDITAR SOLUÇÃO</button>
                            <button type="button" class="botao_adicionar btn verde" onclick="adicionar_solucao_armario()"><i class="fas fa-plus-circle"></i> Adicionar ao Armário</button>
                        </div>

                    </div>

                </div>
                <table class="armario form-row">
                    <thead>
                        <tr>
                            <td class="align-self-center" width=350 colspan=4>
                                <h3>ARMÁRIO</h3>
                            </td>
                        </tr>
                    </thead>
                    <tbody id="lista_solucoes_pratica">
                        <tr>
                            <td class="align-self-center" width=350 colspan=4>
                            </td>
                        </tr>
                    <tbody>
                </table>
            </div>

            <div class="modal fade bd-example-modal-lg modal-edit-solucao" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_solucao">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <section class="criarnovasolucao">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Criar nova solução</h3>
                                    </div>
                                </div>
                                <div class="row row-eq-height">
                                    <div class="col-4">
                                        <div class="box">
                                            <h4>Rótulo</h4>
                                            <h5>Nome:</h5>
                                            <textarea id="nome_solucao" rows="1" cols="20" placeholder="Insira o nome da solução"></textarea>
                                            <h5>Descrição:</h5>
                                            <textarea id="descricao_solucao" rows="3" cols="20" placeholder="Insira a descrição da solução"></textarea>
                                            <h5>Responsável pelo preparo:</h5>
                                            <input id="nome_tecnico" type="text" value="Técnico do NeoAlice">
                                            <h5>Data de criação:</h5>
                                            <select id="data_de_criacao" class="custom-select">
                                                <option value=1>Dia da aula </option>
                                                <option value=2>Dia anterior à aulas </option>
                                                <option value=3>Cerca de uma semana antes da aula </option>
                                                <option value=4>Cerca de um mês antes da aula </option>
                                                <option value=5>Cerca de dois meses antes da aula </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="box">
                                            <h4>Composição</h4>
                                            <select id="especies_disponiveis" class="custom-select">
                                                <?php
                                                global $banco;
                                                $solucoes_selecionadas = $banco->prepare('SELECT * FROM substancias');
                                                $solucoes_selecionadas->execute();
                                                $item = $solucoes_selecionadas->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($item as $res) {
                                                    ?>
                                                    <option value="<?php echo $res['id_substancia'] ?>"><?php echo $res['nome'] ?></option>
                                                <?php };
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 concentracao">
                                        <div class="box">
                                            <h4>Concentração (mol/L)</h4>
                                            <input autofocus min="0" value="0.1" type="number" step="0.1" id="especies_concentracao" />
                                            <button type="button" onclick="adicionar_especie()" class="btn verde">Adicionar</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="especienasolucao">
                                            <h5>Espécies na Solução</h5>
                                            <table>
                                                <tbody id="especies_na_solucao">
                                                    <tr>
                                                        <td class="align-self-center" width=350 colspan=4></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-criar" onclick="concluir_criar_solucao()"> Salvar </button>
                                        <button type="button" class="btn btn-primary btn-criar" onclick="$('#modal_solucao').modal('hide')"> Cancelar </button>
                                    </div>
                                </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- /solucoes -->
        </div>
    </div>
</div>