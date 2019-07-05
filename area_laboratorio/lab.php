<?php 
  include('data.php');

  //include('../banco/conexao.php');    
  include('../banco/sessao.php');
?>
<!DOCTYPE html>
<html lang="pt">
  <head>

     <script src="../js/phaser/3.12.0/phaser.min.js"></script>
    <script src="../js/phaser/GameScalePlugin.js"></script>

    <script src="../js/jquery.js"></script>
    <script src="../js/popper.js/1.14.3/popper.min.js"></script>
    <script src="../js/bootstrap/4.1.3/bootstrap.min.js"></script>

    <script type="text/javascript" src="dist/scripts.js"></script>
    <script type="text/javascript" src="js/LabJogo.js"></script>        
    <script type="text/javascript" src="js/LabElemento.js"></script>    
    <script type="text/javascript" src="js/LabSubstancia.js"></script>        
    <script type="text/javascript" src="js/LabSolution.js"></script>    
    <script type="text/javascript" src="js/LabAction.js"></script>    
    <script type="text/javascript" src="js/LabInteraction.js"></script>    
    <script type="text/javascript" src="js/LabUtils.js"></script>
    <script type="text/javascript" src="js/LabState.js"></script>
    <script type="text/javascript" src="js/LabHandler.js"></script>    
    <script type="text/javascript" src="js/LabError.js"></script>        
    <script type="text/javascript" src="js/LabActions.php"></script>
    <script type="text/javascript" src="js/LabPhmetro.js"></script>        
    <script type="text/javascript" src="js/LabArmario.js"></script> 
    <script type="text/javascript" src="js/LabEspectrofotometro.js"></script>             
    <script type="text/javascript" src="js/LabEspectrofotometro.class.js"></script>  

    <!-- <script type="text/javascript" src="js/rotinas/medirPotencial.js"></script> -->

    <link rel="stylesheet" href="../estilos/bootstrap/4.1.3/bootstrap.min.css">
    <link rel="stylesheet" href="../awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
    <script>
      var id_pratica = parseInt('<?php echo @$_REQUEST['id_pratica']; ?>');
      var tipo_acesso = '<?php echo @$_REQUEST['tipo_acesso']; ?>';

      function exibirPagina(n) {
        //
        $('.botoes').show();

        var alvo = $('#animacao .modal-body .conteudo .page-'+n);

        if ($(alvo).length == 0) return false;

        if (alvo.hasClass('sem-botoes')) {
          $('.botoes').hide();
        }

        //if ($(alvo).attr('data-extra')) {
        //  exibirPagina();
        //}

        $('#animacao .modal-body').attr('data-pagina',n);
        $('#animacao .modal-body .conteudo .page').hide();
        $('#animacao .modal-body .conteudo .page-'+n).show();
      }

      function proximaPagina() {
        var atual = parseInt($('#animacao .modal-body').attr('data-pagina'));
        exibirPagina(atual+1);
      }

      function paginaAnterior() {
        var atual = parseInt($('#animacao .modal-body').attr('data-pagina'));
        if (atual > 1) exibirPagina(atual-1); 
      }

      function limparTela() {
        // Criacao do conteudo
        $("#animacao .modal-body .conteudo .page:not('.page-0')").remove();
      }
    </script>
    <style>
      .on { background-color: #0f0;  }
      .on::after { content: "ON"; }
      .off { background-color: #f00; }
      .off::after { content: "OFF"; }

      label:hover{
        /* text-shadow: #ea1f74 0px 0px 5px; */
        border: 1px solid #000;
      }

    </style>
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
            <button class="fechar" onclick="sair_laboratorio(<?php echo $_SESSION['tipo_usuario']?>)"><i class="fa fa-sign-out" aria-hidden="true"></i>VOLTAR</button>
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
              <div class="conteudo">
                
              </div>
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
<!--
      <div class="modal fade" id="praticas" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header text-dark">
            Qual o seu objetivo?
            </div>
            <div class="modal-body">
              <button id="btn-treinar" type="submit" class="btn btn-primary float-left mt-4 mb-2" data-dismiss="modal">Treinar</button>
              <button id="btn-fazer" type="submit" class="btn btn-primary float-right mt-4 mb-2" data-dismiss="modal">Fazer e enviar</button>
            </div>
          </div>
        </div>
      </div> 
-->
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
<?php
/*
  // TODO: Informar a priori para a instancia da classe
  // qual o id da pratica atual
  $solucoes = $lab->getSolucoesPratica( $_REQUEST['id_pratica'] );
  

  foreach ($solucoes as $solucao): ?>
  <label class="opcao" data-id="<?php echo $solucao['id'];?>" data-descricao="<?php echo $solucao['descricao']?>">    
    <input type="checkbox" style="display:none" value="<?php echo $solucao['id']?>" />
    <p><?php echo $solucao['nome'];?></p>   
    <img src="assets/frasco_estoque.png" height="120px">
    <button data-id="<?php echo $solucao['id'];?>" type="button" class="btn btn-dark m-3 botao btn-armario-pegar" >Selecionar</button>
  </label>
  
<?php
endforeach;
*/
?>                    
                    </div>
                  </div>
                  <!--
                    <div class="classesdebotoes float-right">
                    <button type="button" class="botaocircular">1</button>
                    <button type="button" class="botaocircular2">2</button>
                    <button type="button" class="botaocircular2">3</button>
                  </div>
                  -->
                  <div class="tab-pane fade" id="tab_vidrarias" role="tabpanel" aria-labelledby="vidrarias-tab">      
                    <div class="caixas">
<?php
/*
$lista = $lab->getVidrariasPratica(@$_REQUEST['id_pratica']);
foreach ($lista as $val):
?>
                      <label class="opcao" data-id="<?php echo $val['id']?>">    
                      <input type="checkbox" style="display:none" value="<?php echo $val['id']?>" />
                        <p><?php echo $val['nome']; ?></p>   
                        <img src="assets/<?php echo $val['conceito']; ?>.png" height="120px">

                        <button type="button" data-id="<?php echo $val['id']; ?>" class="btn btn-dark m-3 botao btn-armario-pegar">Selecionar</button>
                        <!-- <input value="1" placeholder="0" type="number" name="quantity" min="0" max="5" class="numeroinput"> -->
                      </label>
<?php
endforeach;
*/
?>                        

                    </div>
                  </div>
                </div>
                <!-- <div class="classesdebotoes float-right classesdebotoes2">
                  <button type="button" class="botaocircular">1</button>
                  <button type="button" class="botaocircular2">2</button>
                  <button type="button" class="botaocircular2">3</button>
                </div> -->
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

    <div class="modal fade" id="teste" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true" >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-dark">
            <h5 class="modal-title">Interação</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">

<form method="post" action="#" name="form0" >
  <label for="Lmed">Comprimento de onda médio:</label>    
  <input type="number" name="Lmed" min="190" max="1100" value="190">
  <br /><br />
    <input type="radio" name="rdtipo" id="tipo" value="vidro" /> Cubeta de Vidro
    <input type="radio" name="rdtipo" id="tipo" value="quartzo"/> Cubeta de Quartzo <br /> 
    <h2>Modo</h2>
    <input type="radio" name="modo" id="modo" value="abs" /> Absorbância
    <input type="radio" name="modo" id="modo" value="trans"/> Transmitância <br /> 

</form>

  <h2>Lampadas</h2>
  <span class="deuterio off"></span> Deutério <span class="tungstenio off"></span> Tungstênio
  <br /><br />
  <button onclick="ligar('deuterio')" class="btn">Deutério</button>
  <button onclick="ligar('tungstenio')" class="btn"> Tungstênio </button>
  
  <input type="button" class="btn" onclick="validarConfig()" value="Ligar" data-dismiss="modal" aria-label="Close" />


<script>
//
var config = {
  lampada: {
    deuterio: false, tungstenio: false
  },
  status: 0,
  Lmed: 400,
  cubeta: 370,
  modo: 0
};


function validarConfig (){
  var Lmed = form0.Lmed.value;
  if (Lmed == "") {
    alert('Preencha o campo com comprimento de onda');
    form1.Lmed.focus();
    return false;
  }
  
  if (Lmed > 1100 || Lmed < 190){
    alert('Insira um valor válido');
    form1.Lmed.focus();
    return false;
  }
  
  config.Lmed = Lmed*1


  if((form0.rdtipo[0].checked == false)&&(form0.rdtipo[1].checked == false)){
    alert('Informe o tipo de cubeta');
      form1.rdtipo[0].focus();
      return false;
  }

  if((form0.rdtipo[0].checked == true)&&(form0.rdtipo[1].checked == false)){
      config.cubeta = 370
  }

  if((form0.rdtipo[0].checked == false)&&(form0.rdtipo[1].checked == true)){
      config.cubeta = 160
  }

  if((form0.modo[0].checked == true)&&(form0.modo[1].checked == false)){
      config.modo = 0
  }

  if((form0.modo[0].checked == false)&&(form0.modo[1].checked == true)){
      config.modo = 1
  }

  console.log(config)

  //Roda a função de loop como um sinal de que o aparelho ligou
  setInterval(function () {
    LabEspectrofotometro._loop();
  }, 1000);
}

function status(v) { config.status = v; }

function ligar (objeto){
  switch (objeto) {
    case "deuterio":
      config.lampada.deuterio = !config.lampada.deuterio;
    break;
    case "tungstenio":
      config.lampada.tungstenio = !config.lampada.tungstenio;
    break;
  }

  // 
  $('.deuterio')
    .removeClass('off').removeClass('on')
      .addClass((config.lampada.deuterio)?'on':'off');

  //        
  $('.tungstenio')
    .removeClass('off').removeClass('on')
      .addClass((config.lampada.tungstenio)?'on':'off'); 

}
</script>
  

          </div>
        </div>
      </div>
    </div>


<div class="modal fade" id="teste3" tabindex="-1" role="dialog" aria-labelledby="LabelModal" aria-hidden="true" >
      <div class="modal-dialog" role="document">
        
      </div>
    </div>

    
    <div id="AreaJogo">    
      <script type="text/javascript" src="js/LabMain.js"></script>         
    </div>
</body>
</html>
