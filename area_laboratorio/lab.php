<?php
include_once('../lab-config.php');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <title>NeoAlice</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo URL_SITE; ?>imagens/icons/favicon.png" />
  <!--vendors-->
  <script src="<?php echo URL_SITE;?>plugins/vendor/jquery/jquery.js"></script>
  <script src="<?php echo URL_SITE;?>plugins/vendor/phaser/3.12.0/phaser.min.js"></script>
  <script src="<?php echo URL_SITE;?>plugins/vendor/phaser/GameScalePlugin.js"></script>
  <script src="<?php echo URL_SITE;?>plugins/vendor/popper.js/1.14.3/popper.min.js"></script>
  <script src="<?php echo URL_SITE;?>plugins/vendor/bootstrap/4.1.3/bootstrap.min.js"></script>

  <script>
    const URL_SITE = '<?php echo URL_SITE; ?>';
    var id_pratica = parseInt('<?php echo $_REQUEST['id_pratica']; ?>');
    var tipo_acesso = '<?php echo $_REQUEST['tipo_acesso']; ?>';
  </script>

  <!-- estilos -->
  <link rel="stylesheet" href="<?php echo URL_SITE;?>plugins/vendor/bootstrap/4.1.3/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo URL_SITE;?>plugins/vendor/awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo URL_SITE;?>area_laboratorio/css/style.css">
  <link rel="stylesheet" href="<?php echo URL_SITE;?>area_laboratorio/css/lab.css">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,700,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
</head>

<body>
  <header>
    <nav class="navbar">
      <h1>NeoAlice</h1>
      <h1 id="tituloPratica" class="text-center"></h1>
      <div class="controle">
        <button id="info" type="button" style="background-color: grey" data-container="body" data-placement="bottom">
          <i class="fa fa-info-circle" aria-hidden="true"></i>
        </button>
        <button class="fechar" onclick="sair_laboratorio(<?php echo $_SESSION['tipo_usuario'] ?>)"><i class="fa fa-sign-out" aria-hidden="true"></i>VOLTAR</button>
      </div>
    </nav>
  </header>

  <div class="modal fade" id="animacao" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true">
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
            <a href="#" class="btn btn-success" data-dismiss="" onclick="paginaAnterior()"><i class="fa fa-step-backward"></i> Anterior</a>
            <a href="#" class="btn btn-success" data-dismiss="" onclick="proximaPagina()"><i class="fa fa-step-forward"></i> Próximo</a>
            <a href="#" class="btn btn-success" data-dismiss="modal">Concluir</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="interacao" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true">
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

  <div id="armario" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10">
              <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="solucoes-tab" data-toggle="tab" href="#tab_solucoes" role="tab" aria-controls="home" aria-selected="true">Soluções</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="vidrarias-tab" data-toggle="tab" href="#tab_vidrarias" role="tab" aria-controls="profile" aria-selected="false">Vidrarias</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab_solucoes" role="tabpanel" aria-labelledby="solucoes-tab">
                  <div class="caixas">

                  </div>
                </div>
                <div class="tab-pane fade" id="tab_vidrarias" role="tabpanel" aria-labelledby="vidrarias-tab">
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
                  <button type="button" id="fechar-armario" class="btn btn-default mt-2 mb-2">Cancelar</button>
                </div>
                <div class="float-right">
                  <button type="button" class="btn btn-primary mt-2 mb-2 btn-armario-adicionar">Adicionar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="teste" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-dark">
          <h5 class="modal-title">Interação</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <form method="post" action="#" name="form0">
            <h3> Configurar espectrofotômetro </h3>
            <label for="Lmed">Comprimento de onda médio:</label>
            <input type="number" name="Lmed" min="190" max="1100" value="190">
            <br />

            <h3>Escolha o modo de medição: </h3>
            <input type="radio" name="modo" id="modo" value="abs" /> Absorbância
            <input type="radio" name="modo" id="modo" value="trans" /> Transmitância <br />

          </form>
          <br />
          <h3>Escolha quais lâmpadas deseja ligar: </h3>
          <span class="deuterio off"></span> Deutério <span class="tungstenio off"></span> Tungstênio
          <br />
          <button onclick="ligar('deuterio')" class="btn">Deutério</button>
          <button onclick="ligar('tungstenio')" class="btn"> Tungstênio </button>
          <br /><br />
          <input type="button" class="btn-success" onclick="validarConfig()" value="Ligar Equipamento" data-dismiss="modal" aria-label="Close" />
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="teste3" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true">
    <div class="modal-dialog" role="document">

    </div>
  </div>

  <div id="AreaJogo"></div>

  <!-- 
    #########
    SCRIPTS 
    #########
  -->

  <!-- LABS -->
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabJogo.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabElemento.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabSubstancia.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabSolution.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabAction.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabInteraction.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabUtils.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabState.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabHandler.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabError.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabPhmetro.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabArmario.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabEspectrofotometro.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabEspectrofotometro.class.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/LabMain.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/LabActions.php"></script>

  <!-- default -->
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/default/scripts.js"></script>

  <!--DROP ZONES -->
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/others/DropZones.js"></script>
  
  <!--OBJETOS -->
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/others/ObjetoDefault.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/model/objetos/Pisseta.js"></script>


  <!-- OUTROS -->
  <script type="text/javascript" src="<?php echo URL_SITE;?>area_laboratorio/js/laboratorio-virtual/lab/lab.js"></script>

</body>
</html>