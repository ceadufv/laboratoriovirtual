<div class="modal fade" id="animacao" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-dark">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="conteudo"></div>
        <div class="botoes">
          <a href="javascript:void(0)" class="btn btn-success" id="animation-previous-page" onclick="PageAnimation.previousPage()"><i class="fa fa-step-backward"></i> Anterior</a>
          <a href="javascript:void(0)" class="btn btn-success" id="animation-next-page" onclick="PageAnimation.nextPage()"><i class="fa fa-step-forward"></i> Próximo</a>
          <a href="javascript:void(0)" class="btn btn-success" data-dismiss="modal">Concluir</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- interacao-1 -->
<!-- Não fechar data-keyboard="false" data-backdrop="static" -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="interacao-1" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-dark">
        <h5 class="modal-title">Interação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class=""></div>
        <div class="botoes">

        </div>
      </div>
    </div>
  </div>
</div>

<!-- interacao-2 -->
<div class="modal fade" id="interacao-2" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-dark">
        <h5 class="modal-title">Interação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class=""></div>
        <div class="botoes">

        </div>
      </div>
    </div>
  </div>
</div>

<div id="armario" data-keyboard="false" data-backdrop="static" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10">
            <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
              <li class="nav-item">
                <a id="solucoes-tab" href="#solucoes-content" class="nav-link active" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">Soluções</a>
              </li>

              <li class="nav-item">
                <a href="#bequers-content" id="bequers-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">
                  Bequers
                </a>
              </li>

              <li class="nav-item">
                <a href="#baloes-content" id="baloes-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">
                  Balões
                </a>
              </li>

              <li class="nav-item">
                <a href="#micropipetas-content" id="micropipetas-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">
                  Micropipetas
                </a>
              </li>

              <li class="nav-item">
                <a href="#pipetas-content" id="pipetas-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">
                  Pipetas volumétrica
                </a>
              </li>

              <li class="nav-item">
                <a href="#pipetadores-content" id="pipetadores-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">
                  Pipetadores
                </a>
              </li>

              <li class="nav-item">
                <a href="#cubetas-content" id="cubetas-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">
                  Cubetas
                </a>
              </li>

              <!--
                <li class="nav-item">
                  <a id="vidrarias-tab" href="#vidrarias-content" class="nav-link" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">
                    Outros
                  </a>
                </li>
-->
            </ul>
            <div class="tab-content" id="myTabContent">
              <div aria-labelledby="solucoes-tab" id="solucoes-content" class="tab-pane fade show active" role="tabpanel">
                <div class="caixas">

                </div>
              </div>

              <div aria-labelledby="vidrarias-tab" id="vidrarias-content" class="tab-pane fade" role="tabpanel">
                <div class="caixas">
                </div>
              </div>

              <div aria-labelledby="micropipetas-tab" id="micropipetas-content" class="tab-pane fade" role="tabpanel">
                <div class="caixas">
                </div>
              </div>

              <div aria-labelledby="bequers-tab" id="bequers-content" class="tab-pane fade" role="tabpanel">
                <div class="caixas">
                </div>
              </div>

              <div aria-labelledby="baloes-tab" id="baloes-content" class="tab-pane fade" role="tabpanel">
                <div class="caixas">
                </div>
              </div>

              <div aria-labelledby="pipetas-tab" id="pipetas-content" class="tab-pane fade" role="tabpanel">
                <div class="caixas">
                </div>
              </div>

              <div aria-labelledby="pipetadores-tab" id="pipetadores-content" class="tab-pane fade" role="tabpanel">
                <div class="caixas">
                </div>
              </div>
              
              <div aria-labelledby="cubetas-tab" id="cubetas-content" class="tab-pane fade" role="tabpanel">
                <div class="caixas">
                </div>
              </div>

            </div>
          </div><!-- fecha primeira coluna -->
          <div class="col-2">
            <div class="rotulo mt-2 p-2">
              <h4 class="armario-contador">0 selecionados</h4>
              <p class="armario-disponiveis"></p>
              <p>
                <div class="armario-lotado alert alert-danger" role="alert" style="display:none">
                  Não é possível acrescentar novos itens à sua lista, pois ela já ocupará todo o espaço livre na bancada
                </div>
              </p>
            </div>
            <div class="botoesfinais">
              <div class="float-left">
                <button type="button" class="btn btn-default mt-2 mb-2" onclick="Armario.fecharArmario();">Cancelar</button>
              </div>
              <div class="float-right">
                <button type="button" class="btn btn-primary mt-2 mb-2" onclick="Armario.addItensSelecionadosScene();">Adicionar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>