<div class="card">
    <div class="card-header" id="headingOne">
        <h5 class="mb-0">
            <button <?php echo (empty($pratica_sel['id_modelo_pratica']) ? 'disabled' : '')?> type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#solucoes" aria-expanded="true" aria-controls="collapseOne">
                <strong><i class="fas fa-check-circle ativo"></i> Soluções</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="solucoes" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
            <div class="solucoes">
                <div class="solucoespreparadas">
                    <h3>
                        <span>Soluções já preparadas:</span>
                        <button type="button" cod_moprsi="" class="btn btn-primary botao_criar_solucao btn azul nova-solucao" id_pratica="<?php echo $pratica_sel['id_modelo_pratica'];?>" data-toggle="modal" data-target=".modal-edit-solucao"><i class="fas fa-plus-circle"></i> CRIAR NOVA SOLUÇÃO</button>
                    </h3>

                    <div class="composicao">
                        <div id="solucoes-preparadas">
                            <?php
                            $objModeloPraticaSolucao = new ModeloPraticaSolucao();
                            $solucoes = $objModeloPraticaSolucao->getSolucoesPratica($pratica_sel['id_modelo_pratica']);
                            echo $objModeloPraticaSolucao->getItensHtml($solucoes);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_solucao" class="modal fade bd-example-modal-lg modal-edit-solucao" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- modal -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>