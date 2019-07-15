/**
* @name	Realizar medição
* @description Essa ação abre o modal para medição o branco e da solução de acordo com a configuração escolhida
* @valid_source ["frasco_estoque", "cheio(cubeta_cheia)"]
* @valid_target ["espectrofotometro"]
*
* @error {"fechado(espectrofotometro)" : "Abra o equipamento para realizar a medição"}
*/
var cubeta = [];

function medirEspectrofotometro(interacao) {

	var source = interacao.source();
	var target = interacao.target();

  // Inserir animação de inserção da cubeta
  $('#animacao').modal('show');

  // Move o objeto para um "lixo" que é um lugar fora da tela
  source.moveTo('lixo');

  // Criacao do conteudo
  limparTela();

  $('#animacao .modal-body .conteudo')
    .append('<div class="page page-1"><img src="assets/actions/inserircubeta.gif" /></a>');

  $('#animacao .modal-body .conteudo')
    .append('<div class="page page-2 sem-botoes">'+
    '<form method="post" action="#" name="form2">'+
    '<h3>Selecione a composição a ser medida</h3>'+
    '<input type="checkbox" name="comp" id="azulacido" value="on">Azul ácido'+ ' ' +
    '<input type="checkbox" name="comp" id="azulbasico" value="on">Azul básico'+ ' ' +
    '<input type="checkbox" name="comp" id="violeta" value="on">Violeta de Metila'+
    '<br />'+
    '<h3>Deseja utilizar essa composição como branco ou como solução?</h3>'+
    '<input type="button" class="btn" onclick="validarSolucao(); medirBranco(); " value="Medir Branco" data-dismiss="modal" aria-label="Close"/>'+ ' ' +
    '<input type="button" class="btn" onclick="validarSolucao(); medir(); " value="Medir Solução" data-dismiss="modal" aria-label="Close"/>'+
    '</form>'+
  '</div>');

  exibirPagina(1);

  //FECHA O EQUIPAMENTO
  LabUtils.buscarPorConceito("tampa_espectrofotometro")[0].data().alpha = 0.001
  config.status = 0;

  // Marca checkbox de acordo com a substância na cubeta
  var nome = source.data('json').nome.toLowerCase();

  switch (nome) {
    case "cubetaazul ácido":
      escolher('azulacido');
    break;
    case "cubetaazul básico":
      escolher('azulbasico');
    break;
    case "cubetavioleta de metila":
      escolher('violeta');
    break;
  }

  // Passa para a global qual a cubeta que está chegando
  cubeta.push(source.data('json').volume.toLowerCase());
}

function escolher(id) {
  //
  $('#azulacido').prop('checked',false);
  $('#azulbasico').prop('checked',false);
  $('#violeta').prop('checked',false);

  //
  $('#'+id).prop('checked',true);

}

var somabranco = 0;

var comp = {
  azulacido: false,
  azulbasico: false,
  violetademetila: false,
  soma: 0
};

function validarSolucao (){

  if((form2.comp[0].checked == true)&&(form2.comp[1].checked == false)&&(form2.comp[2].checked == false)){
    comp = {
      azulacido: true,
      azulbasico: false,
      violetademetila: false
    }
  }

  if((form2.comp[0].checked == true)&&(form2.comp[1].checked == true)&&(form2.comp[2].checked == false)){
    comp = {
      azulacido: true,
      azulbasico: true,
      violetademetila: false
    }
  } 

  if((form2.comp[0].checked == true)&&(form2.comp[1].checked == true)&&(form2.comp[2].checked == true)){
    comp = {
      azulacido: true,
      azulbasico: true,
      violetademetila: true
    }
  } 

  if((form2.comp[0].checked == false)&&(form2.comp[1].checked == true)&&(form2.comp[2].checked == false)){
    comp = {
      azulacido: false,
      azulbasico: true,
      violetademetila: false
    }
  } 

  if((form2.comp[0].checked == false)&&(form2.comp[1].checked == true)&&(form2.comp[2].checked == true)){
    comp = {
      azulacido: false,
      azulbasico: true,
      violetademetila: true
    }
  }

  if((form2.comp[0].checked == false)&&(form2.comp[1].checked == false)&&(form2.comp[2].checked == true)){
    comp = {
      azulacido: false,
      azulbasico: false,
      violetademetila: true
    }
  }

  if((form2.comp[0].checked == true)&&(form2.comp[1].checked == false)&&(form2.comp[2].checked == true)){
    comp = {
      azulacido: true,
      azulbasico: false,
      violetademetila: true
    }
  }

}


function medirBranco(){

  console.log('Componentes', comp);

  var dados = [];

  // Seleciona a cubeta do branco
  if (cubeta[0] == 'cubeta de vidro'){
    config.cubeta = 370;
    console.log('vidro')
  } else {
    config.cubeta = 160;
    console.log('quartzo')
  }

  if (comp.azulacido) dados.push({ id: 'azulacido', volume: 1 });
  if (comp.azulbasico) dados.push({ id: 'azulbasico', volume: 1 });
  if (comp.violetademetila) dados.push({ id: 'violetademetila', volume: 1 });

  solucao(dados).done(function (sol) {
    console.log('Configuração', config);

    espectrofotometro()
      .lampada('deuterio', config.lampada.deuterio)
      .lampada('tungstenio', config.lampada.tungstenio)
      .status(config.status)
      .comprimentoMedio(config.Lmed)
      .cubeta(config.cubeta)
      .medir(sol).done(function (data) {
        
        comp.soma = data;
        console.log('somabranco', comp.soma)
        somabranco = comp.soma;

      })
  });

  LabEspectrofotometro._loop = function () {

    var handlerEspectrofotometro = LabUtils.buscarPorConceito('espectrofotometro')[0];  

    // Ao medir o branco o equipamento dará um sinal de tramsitancia 100% e absorbancia 0
    if (config.modo == 0){
          handlerEspectrofotometro.data('espectroVisor').text = '0,000';
          handlerEspectrofotometro.data('modo').text = "Absorbância";
    } else {
          handlerEspectrofotometro.data('espectroVisor').text = '100%';
          handlerEspectrofotometro.data('modo').text = "Transmitância";
    }

  }

}

function medir(){

  console.log('Componentes', comp);

  var dados = [];

  // Seleciona a cubeta da solução, que é a segunda a ser inserida
  if (cubeta[1] == 'cubeta de vidro'){
    config.cubeta = 370;
  } else {
    config.cubeta = 160;
  }

  if (comp.azulacido) dados.push({ id: 'azulacido', volume: 1 });
  if (comp.azulbasico) dados.push({ id: 'azulbasico', volume: 1 });
  if (comp.violetademetila) dados.push({ id: 'violetademetila', volume: 1 });

  solucao(dados).done(function (sol) {
    console.log('Configuração', config);

    espectrofotometro()
      .lampada('deuterio', config.lampada.deuterio)
      .lampada('tungstenio', config.lampada.tungstenio)
      .status(config.status)
      .comprimentoMedio(config.Lmed)
      .cubeta(config.cubeta)
      .medir(sol).done(function (data) {
        
        console.log('somabranco', somabranco)
        comp.soma = data
        console.log('somasolucao', comp.soma)
        

        var Tmed = 100 * comp.soma/ somabranco; 
        var Amed = 2 - Math.log10(Tmed);     


        // EXECUTA LOOP MEDIÇÃO
        var tempo = 0;
        LabEspectrofotometro._loop = function () {
          var mc = LabPhmetro.mc

          var handlerEspectrofotometro = LabUtils.buscarPorConceito('espectrofotometro')[0];

          if (tempo >= 60) return;
            
            if (config.modo == 0){

              if(Amed >= 1.9){
                var ruido = mc(0.3) + 0.05*Math.exp(-1*tempo) + 0.4*Math.exp(-0.5*tempo) + 0.02*Math.exp(-0.33*tempo)
                var Adisplay = 1.9 + ruido;
              } else {
                var ruido = mc(0.0005) + 0.05*Math.exp(-1*tempo) + 0.4*Math.exp(-0.5*tempo) + 0.02*Math.exp(-0.33*tempo)
                var Adisplay = Amed + ruido;
              }

              handlerEspectrofotometro.data('espectroVisor').text = Adisplay.toFixed(3);
              handlerEspectrofotometro.data('modo').text = "Absorbância";

            } else {

              var ruido = mc(0.0005) + 0.05*Math.exp(-1*tempo) + 0.4*Math.exp(-0.5*tempo) + 0.02*Math.exp(-0.33*tempo)
              var Tdisplay = Tmed + Math.pow(10,-ruido);
            
              handlerEspectrofotometro.data('espectroVisor').text = Tdisplay.toFixed(2) + '%';
              handlerEspectrofotometro.data('modo').text = "Transmitância";

            }

            tempo ++;
        }

      })
  });



}






