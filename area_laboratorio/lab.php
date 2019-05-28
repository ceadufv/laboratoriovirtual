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
    </script>
    <style>
      .on { background-color: #0f0;  }
      .on::after { content: "ON"; }
      .off { background-color: #f00; }
      .off::after { content: "OFF"; }
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
              <div class=""><img src="assets/actions/transferirFrasco_bequer.gif" /></div>
              <div class="botoes">
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
                      <a class="nav-link active" id="solucoes-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Soluções</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="vidrarias-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Vidrarias</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="solucoes-tab">
                      <div class="caixas">
<?php

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
  
<?php endforeach;?>

                     
                    </div>
                  </div>
                  <!--
                    <div class="classesdebotoes float-right">
                    <button type="button" class="botaocircular">1</button>
                    <button type="button" class="botaocircular2">2</button>
                    <button type="button" class="botaocircular2">3</button>
                  </div>
                  -->
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">      
                    <div class="caixas">
<?php
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
?>                        
<style>
label:hover{
  /* text-shadow: #ea1f74 0px 0px 5px; */
  border: 1px solid #000;
}

</style>
<script>
</script>
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

    <div class="modal fade show modal-espectrofotometro" id="teste" tabindex="-1" role="dialog" aria-labelledby="LabelModal" style="display: block;">
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
    <input type="radio" name="rdtipo" id="tipo" value="vidro"/> Cubeta de Vidro
    <input type="radio" name="rdtipo" id="tipo" value="quartzo"/> Cubeta de Quartzo <br />
  <h2>Branco</h2>
    <input type="checkbox" name="comp" id="branco" value="on" />Branco
    <input type="checkbox" name="comp" id="azulbasico" value="on">Azul básico
    <input type="button" onclick="validarBranco()" value="OK" />
  </form>
    <h2>Lampadas</h2>
  <span class="deuterio off"></span> Deuterio <span class="tungstenio off"></span> Tungstenio
  <br /><br />
  <button onclick="ligar('deuterio')">Deutério</button>
  <button onclick="ligar('tungstenio')"> Tungstênio </button>
  <button onclick="status(1)"> Abrir </button>
  <button onclick="status(0)"> Fechar </button> <button onclick="medirBranco()"> Medir Branco </button>
  
  <form method="post" action="#" name="form1">
    <h2>Soluções</h2>
      <input type="checkbox" name="comp" id="azulacido" value="on">Azul ácido
      <input type="checkbox" name="comp" id="azulbasico" value="on">Azul básico
      <input type="checkbox" name="comp" id="violeta" value="on">Violeta de Metila
      <br />
    <input type="button" onclick="validarSolucao()" value="OK"></button>
    <input type="button" onclick="medir()" value="Medir" />
  </form>

<script>
//
var config = {
  lampada: {
    deuterio: false, tungstenio: false
  },
  status: 0,
  Lmed: 400,
  cubeta: 370
};

var branco = {
  branco: false,
  azulbasico: false,
  soma: 0
};

var comp = {
  azulacido: false,
  azulbasico: false,
  violetademetila: false,
  soma: 0
};

function validarBranco (){
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
  
  if((form0.comp[0].checked == true)&&(form0.comp[1].checked == false)){
    branco = {
      branco: true,
      azulbasico: false
    }
  console.log(branco)
  }

  if((form0.comp[0].checked == true)&&(form0.comp[1].checked == true)){
    branco = {
      branco: true,
      azulbasico: true
    }
  console.log(branco)
  }

  if((form0.comp[0].checked == false)&&(form0.comp[1].checked == true)){
    branco = {
      branco: false,
      azulbasico: true
    }
  console.log(branco)
  }
}

function validarSolucao (){
  //return;

  if((form1.comp[0].checked == true)&&(form1.comp[1].checked == false)&&(form1.comp[2].checked == false)){
    comp = {
      azulacido: true,
      azulbasico: false,
      violetademetila: false
    }
    console.log(comp)
  }

  if((form1.comp[0].checked == true)&&(form1.comp[1].checked == true)&&(form1.comp[2].checked == false)){
    comp = {
      azulacido: true,
      azulbasico: true,
      violetademetila: false
    }
    console.log(comp)
  } 

  if((form1.comp[0].checked == true)&&(form1.comp[1].checked == true)&&(form1.comp[2].checked == true)){
    comp = {
      azulacido: true,
      azulbasico: true,
      violetademetila: true
    }
    console.log(comp)
  } 

  if((form1.comp[0].checked == false)&&(form1.comp[1].checked == true)&&(form1.comp[2].checked == false)){
    comp = {
      azulacido: false,
      azulbasico: true,
      violetademetila: false
    }
    console.log(comp)
  } 

  if((form1.comp[0].checked == false)&&(form1.comp[1].checked == true)&&(form1.comp[2].checked == true)){
    comp = {
      azulacido: false,
      azulbasico: true,
      violetademetila: true
    }
    console.log(comp)
  }

  if((form1.comp[0].checked == false)&&(form1.comp[1].checked == false)&&(form1.comp[2].checked == true)){
    comp = {
      azulacido: false,
      azulbasico: false,
      violetademetila: true
    }
    console.log(comp)
  }

  if((form1.comp[0].checked == true)&&(form1.comp[1].checked == false)&&(form1.comp[2].checked == true)){
    comp = {
      azulacido: true,
      azulbasico: false,
      violetademetila: true
    }
    console.log(comp)
  }

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

function medirBranco(){

  console.log('branco', branco);

  var dados = [];

  if (branco.branco) dados.push({ id: 'branco', volume: 1 });
  if (branco.azulbasico) dados.push({ id: 'azulbasico', volume: 1 });

  solucao(dados).done(function (sol) {
    console.log(config);

    espectrofotometro()
      .lampada('deuterio', config.lampada.deuterio)
      .lampada('tungstenio', config.lampada.tungstenio)
      .status(config.status)
      .comprimentoMedio(config.Lmed)
      .cubeta(config.cubeta)
      .medir(sol).done(function (data) {
        
        branco.soma = data;
        console.log('somabranco', branco.soma)

      })
  });
}

function medir(){

  console.log('Comp', comp);

  var dados = [];

  if (comp.azulacido) dados.push({ id: 'azulacido', volume: 1 });
  if (comp.azulbasico) dados.push({ id: 'azulbasico', volume: 1 });
  if (comp.violetademetila) dados.push({ id: 'violetademetila', volume: 1 });

  solucao(dados).done(function (sol) {
    console.log(config);

    espectrofotometro()
      .lampada('deuterio', config.lampada.deuterio)
      .lampada('tungstenio', config.lampada.tungstenio)
      .status(config.status)
      .comprimentoMedio(config.Lmed)
      .cubeta(config.cubeta)
      .medir(sol).done(function (data) {
        
        comp.soma = data
        console.log('somasolucao', comp.soma)

        var Tmed = 100 * comp.soma/ branco.soma; 
            var Amed = 2 - Math.log10(Tmed);

        console.log(Amed, Tmed);
        
        //FUNCAO DISPLAY
        var mc = LabPhmetro.mc
        for (var t = 0; t < 200; t++){
          
           // CALCULO TDISPLAY
          console.log(t)// tempo em minutos apos o fechamento da tampa
          var ruido = mc(0.0005) + 0.05*Math.exp(-1*t) + 0.4*Math.exp(-0.5*t) + 0.02*Math.exp(-0.33*t)
          var Tdisplay = Tmed + Math.pow(10,-ruido);

          // CALCULO ADISPLAY
          if(Amed >= 1.9){
            ruido = mc(0.3) + 0.05*Math.exp(-1*t) + 0.4*Math.exp(-0.5*t) + 0.02*Math.exp(-0.33*t)
            var Adisplay = 1.9 + ruido;
          } else {
            ruido = mc(0.0005) + 0.05*Math.exp(-1*t) + 0.4*Math.exp(-0.5*t) + 0.02*Math.exp(-0.33*t)
            var Adisplay = Amed + ruido;
          }
                        
          console.log(Adisplay, Tdisplay)

        }

      })
  });
}
</script>
  

          </div>
        </div>
      </div>
    </div>

    
    <div id="AreaJogo">    
      <script type="text/javascript" src="js/LabMain.js"></script>         
    </div>
</body>
</html>
