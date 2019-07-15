$(function () {
  $('[data-toggle="popover"]').popover()
})
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

$(document).ready(function () {
  editar = -1;
  disciplina_acessada = -1;

  if (bd) {
    if (bd.id_disciplina) disciplina_acessada = bd.id_disciplina;
  }
});

function salvaOuAtualiza() {
  // 
  post("funcoes/save_pratica.php");
  /*
  if(editar == -1) post("funcoes/insert_pratica.php");
  else post("funcoes/update_pratica.php");
  */
}

function cadastraAula() {

  //configuracao_inicial();
  //  $('.cadastra_edita').text('Cadastrar nova aula');
  $('.dadospratica').attr('data-id',-1);
  aba('editaula');

  //  editar = -1;
  //carregar();
}

function edit_pratica(id_pratica) {
  window.location = 'index.php?aba=editaula&id_disciplina=' + disciplina_acessada + '&id_pratica=' + id_pratica;
}

/*
function load_pratica(id_pratica) {  
  editar = id_pratica;
  configuracao_inicial();
  $.ajax({
    url:"funcoes/load_pratica.php",
    type: 'POST',
    data: {
      id_pratica: id_pratica,
    },
  }).done(function (data) {
    if(data.status == true) {

      $('.cadastra_edita').text(data.nome_pratica);
      $('#nome_aula').val(data.pratica[0].nome_pratica);
      $('#resumo_aula').val(data.pratica[0].resumo);
      $('#pratica-disponivel')[0].checked = ((data.pratica[0].disponivel==0)?false : true);

      $("input[name=bancada][value=" + data.pratica[0].id_cenario + "]").prop('checked', true);
      console.log(data.pratica[0].id_cenario)

      $('.lista_disciplina_editaula').val( data.pratica[0].id_disciplina );

      var a = data.bequer;
      var b = data.balaovolumetrico;
      var c = data.pipetavolumetrica;
      var d = data.pipetador;
      var e = data.micropipeta;
      var f = data.lista_solucao;

      //var a = (JSON.parse(data.bequer[0].json_dados));
      $(a).each(function()
      {
        var o = $(this)[0];
        $('.bequer-disponivel.bequer-'+o.id)[0].checked = o.disponivel;
        $('.bequer-qtd_maxima.bequer-'+o.id)[0].value = o.qtd_maxima;
        $('.bequer-ambientacao')[0].value = o.ambientacao;
        $('.bequer-qtd_ambientes')[0].value = o.qtd_ambientes;
        $('.bequer-agitacao')[0].value = o.agitacao;
        $('.bequer-volume_maximo.bequer-'+o.id)[0].value = o.volume_maximo;
        $('.bequer-desvio_padrao.bequer-'+o.id)[0].value = o.desvio_padrao;
        $('.bequer-mistura')[0].value = o.mistura;
      });
      
      //var b = JSON.parse(data.balaovolumetrico[0].json_dados);
      $(b).each(function()
      {
        var o = $(this)[0];
        $('.balaovolumetrico-disponivel.balaovolumetrico-'+o.id)[0].checked = o.disponivel;
        $('.balaovolumetrico-qtd_maxima.balaovolumetrico-'+o.id)[0].value = o.qtd_maxima;
        $('.balaovolumetrico-ambientacao')[0].value = o.ambientacao;
        $('.balaovolumetrico-qtd_ambientes')[0].value = o.qtd_ambientes;
        $('.balaovolumetrico-agitacao')[0].value = o.agitacao;
        $('.balaovolumetrico-faixa_aceitavel.balaovolumetrico-'+o.id)[0].value = o.faixa_aceitavel;
        $('.balaovolumetrico-desvio_padrao.balaovolumetrico-'+o.id)[0].value = o.desvio_padrao;
        $('.balaovolumetrico-mistura')[0].value = o.mistura;
      });

      //var c = JSON.parse(data.pipetavolumetrica[0].json_dados);
      $(c).each(function()
      {
        var o = $(this)[0];
        $('.pipetavolumetrica-disponivel.pipetavolumetrica-'+o.id)[0].checked = o.disponivel;
        $('.pipetavolumetrica-qtd_maxima.pipetavolumetrica-'+o.id)[0].value = o.qtd_maxima;
        $('.pipetavolumetrica-ambientacao')[0].value = o.ambientacao;
        $('.pipetavolumetrica-qtd_ambientes')[0].value = o.qtd_ambientes;
        $('.pipetavolumetrica-agitacao')[0].value = o.agitacao;
        $('.pipetavolumetrica-faixa_aceitavel.pipetavolumetrica-'+o.id)[0].value = o.faixa_aceitavel;
        $('.pipetavolumetrica-desvio_padrao.pipetavolumetrica-'+o.id)[0].value = o.desvio_padrao;
        $('.pipetavolumetrica-mistura')[0].value = o.mistura;
      });

      //var d = JSON.parse(data.pipetador[0].json_dados);
      $(d).each(function()
      {
        var o = $(this)[0];
        $('.pipetador-disponivel.pipetador-'+o.id)[0].checked = o.disponivel;
        $('.pipetador-tamanho.pipetador-'+o.id)[0].value = o.tamanho;
        $('.pipetador-qtd_maxima.pipetador-'+o.id)[0].value = o.qtd_maxima;
        $('.pipetador-animacao')[0].value = o.animacao;
      });

      //var e = JSON.parse(data.micropipeta[0].json_dados);
      $(e).each(function()
      {
        var o = $(this)[0];
        $('.micropipeta-disponivel.micropipeta-'+o.id)[0].checked = o.disponivel;
        $('.micropipeta-qtd_maxima.micropipeta-'+o.id)[0].value = o.qtd_maxima;
        $('.micropipeta-animacao')[0].value = o.animacao;
      });

      // console.log(JSON.parse(data.solucao[0].json_dados));
      // var linha = $(":checkbox:checked").parent().parent();
      
      //var f = data.lista_solucao;
      for (i=0;i<f.length; i++){
        var nome = data.lista_solucao[i].nome;
        var id_solucao = data.lista_solucao[i].id_solucao;
        adicionar_solucao_armario_data({text:nome, value:id_solucao});
        /*
        var novalinha = "<tr class="+id_solucao;
        novalinha+= "><td class='id_solucoes_pratica' data-id="+id_solucao;
        novalinha+= ">"+nome+"</td><td>";
        novalinha+= "<button onclick='remover_solucao_armario(this)'>Excluir </button>";
        novalinha+= "</td></tr>";
        $("#lista_solucoes_pratica").append(novalinha); 
        //$("#select_solucoes option:contains("+nome+")")[0].disabled = true;

      }
      
      aba('editaula');

    } else {
      //Caso contrário dizemos que aconteceu algum erro.
      console.log('Aconteceu algum erro. Contate o suporte.');
    }
  })
}

function configuracao_inicial()
{
  bequer();    
  balaovolumetrico();
  pipetavolumetrica();
  pipetador();
  micropipeta();
  $('#nome_aula').val("");
  $('#resumo_aula').val("");
}

function bequer()
{
  
  //Béquer
  //Itens selecionados e preenchidos
  var bequer_preenchidos = [50,100,250];
  bequer_preenchidos.forEach(id => {
      $(".bequer-"+id)[0].checked = true;
      $(".bequer-"+id)[1].value = 3;
  });  
  $(".bequer-250")[1].value = 2;

  //Itens não selecionados
  var bequer_naoselecionados = [5,10];
  bequer_naoselecionados.forEach(id => {
    for (i = 1; i < 4; i++) { 
      $(".bequer-"+id)[i].disabled = true;
    }
  });

  //Itens desabilitados
  var bequer_desabilitados = [400,500,600,1000,2000,'mistura'];
  bequer_desabilitados.forEach(id => {
    $(".bequer-"+id).each(function(){this.disabled=true});
  });
  
}

function balaovolumetrico()
{
  /*
  //Balão volumétrico
  //Itens selecionados e preenchidos
  var balao_preenchidos = [25, 50, 100];
  balao_preenchidos.forEach(id => {
    $(".balaovolumetrico-"+id)[0].checked = true;
    $(".balaovolumetrico-"+id)[1].value = 3;
  });  

    //Itens não selecionados
  var balao_naoselecionados = [5,10,200,250];
  balao_naoselecionados.forEach(id => {
    for (i = 1; i < 3; i++) { 
      $(".balaovolumetrico-"+id)[i].disabled = true;
    }
  });

  //Itens desabilitados
  var balaovolumetrico_desabilitados = [500, 1000, 2000, 'mistura'];
  balaovolumetrico_desabilitados.forEach(id => {
    $(".balaovolumetrico-"+id).each(function(){this.disabled=true});
  });    
}

function pipetavolumetrica()
{
  //Pipeta 
  //Itens selecionados e preenchidos
  var pipeta_preenchidos = [5, 10];
  pipeta_preenchidos.forEach(id => {
    $(".pipetavolumetrica-"+id)[0].checked = true;
    $(".pipetavolumetrica-"+id)[1].value = 3;
  });  

  //Itens desabilitados
  var pipeta_desabilitados = [1,2,3,4,6,7,8,9,15,20,25,50,100, 'mistura'];
  pipeta_desabilitados.forEach(id => {
    $(".pipetavolumetrica-"+id).each(function(){this.disabled=true});
  });
}

function pipetador()
{
  /*
  //Pipetador 
  //Habilitar pipetador de três vias
  $(".pipetador-disponivel:checkbox").each(function(){
    this.disabled = true;
    });
  $(".pipetador-disponivel:checkbox")[0].disabled=false;
  $(".nomepipetador")[0].textContent = "Pipetador de três vias";
  $(".nomepipetador")[1].textContent = "Pi-pump de até 2 ml";
  $(".nomepipetador")[2].textContent = "Pi-pump de até 5 ml";
  $(".nomepipetador")[3].textContent = "Pi-pump de até 10 ml";
  $(".nomepipetador")[5].textContent = "Pipetador automático";
}

function micropipeta()
{
  /*
  $(".micropipeta-100-1000")[1].value = 1;
  $(".micropipeta-100-1000")[0].checked = true;

  //Itens desabilitados
  var micropipeta_desabilitados = ["10-100", "50-200", "1000-5000"];
  micropipeta_desabilitados.forEach(id => {
    $(".micropipeta-"+id).each(function(){this.disabled=true});
  }); 
  
}

function ativacao_itens(checkbox,id) {
  var tamanho;
  for (j=0; j<checkbox.className.split(' ').length; j++){
    if(checkbox.className.split(' ')[j].includes(id)) {
      tamanho = $("."+checkbox.className.split(' ')[j]).length        
      for (i = 1; tamanho<5?i<tamanho:i<tamanho-1; i++) {
        $("."+checkbox.className.split(' ')[j])[i].disabled = !(checkbox.checked);
      };
    };
  };
}

function post(funcao){
  //PRÁTICA
  var pratica = $('#nome_aula').val();
  var resumo = $('#resumo_aula').val();
  // Caso o professor deseje mudar de disciplina uma pratica ja cadastrada
  var disciplina = disciplina_acessada;
  var disponivel = document.getElementById("pratica-disponivel").checked;
  var bancada = $("input[name='bancada']:checked").val();

  //SOLUÇÕES
  var id_solucoes_pratica=[];
  var a = $(".id_solucoes_pratica");
  for(i=0;i<a.length;i++){
      id_solucoes_pratica[i]=$(a[i]).attr('data-id');
  };

  //BEQUER
  var verificacaobequer = true;
  var listabequer = [];
  var bequer_ambientacao = $('.bequer-ambientacao').val();
  var bequer_qtd_ambientes = $('.bequer-qtd_ambientes').val();
  var bequer_agitacao = $('.bequer-agitacao').val();
  var bequer_mistura = $('.bequer-mistura').val();

  $('.linha-bequer').each(function()
    {
    var o = $(this);
    var bequer_disponivel = ($(o).find('.bequer-disponivel:checked').length)?true:false;
    var bequer_qtd_maxima = $(o).find('.bequer-qtd_maxima').val();
    var bequer_volume_maximo = $(o).find('.bequer-volume_maximo').val();
    var bequer_desvio_padrao =  $(o).find('.bequer-desvio_padrao').val();

    if(bequer_disponivel && (bequer_qtd_maxima<0 || bequer_qtd_maxima>10 || 
      bequer_volume_maximo<80 || bequer_volume_maximo>95 ||
      bequer_desvio_padrao<5 || bequer_desvio_padrao>20))  
          verificacaobequer = false;

    var bequer = {
      "id": $(o).attr('data-id'),
      "disponivel": bequer_disponivel,
      "qtd_maxima": bequer_qtd_maxima,
      "ambientacao": bequer_ambientacao,
      "qtd_ambientes":  bequer_qtd_ambientes,
      "agitacao":  bequer_agitacao,
      "volume_maximo": bequer_volume_maximo,
      "desvio_padrao":  bequer_desvio_padrao,
      "mistura": bequer_mistura,
    };
    //console.log(bequer);
    listabequer.push(bequer);
  });

  // BALÃO VOLUMÉTRICO
  var listabalaovolumetrico=[];
  var verificacaobalaovolumetrico = true;
  var balaovolumetrico_ambientacao = $('.balaovolumetrico-ambientacao').val();
  var balaovolumetrico_qtd_ambientes = $('.balaovolumetrico-qtd_ambientes').val();
  var balaovolumetrico_agitacao = $('.balaovolumetrico-agitacao').val();
  var balaovolumetrico_mistura = $('.balaovolumetrico-mistura').val();

  $('.linha-balaovolumetrico').each(function () {
    var o = $(this);
    var balao_disponivel = ($(o).find('.balaovolumetrico-disponivel:checked').length)?true:false;
    var balao_qtd_maxima = $(o).find('.balaovolumetrico-qtd_maxima').val();
    var balao_faixa_aceitavel = $(o).find('.balaovolumetrico-faixa_aceitavel').val();
    var balao_desvio_padrao =  $(o).find('.balaovolumetrico-desvio_padrao').val();

    if(balao_disponivel && (balao_qtd_maxima<0 || balao_qtd_maxima>10 || 
      balao_faixa_aceitavel<90 || balao_faixa_aceitavel>110 ||
      balao_desvio_padrao<0 || balao_desvio_padrao>1))  
        verificacaobalaovolumetrico = false;

    var balaovolumetrico = {
      "id": $(o).attr('data-id'),
      "disponivel": balao_disponivel,
      "qtd_maxima": balao_qtd_maxima,
      "ambientacao": balaovolumetrico_ambientacao,
      "qtd_ambientes":  balaovolumetrico_qtd_ambientes,
      "agitacao":  balaovolumetrico_agitacao,
      "faixa_aceitavel": balao_faixa_aceitavel,
      "desvio_padrao":  balao_desvio_padrao,
      "mistura":  balaovolumetrico_mistura,
    };
    //console.log(balaovolumetrico);
    listabalaovolumetrico.push(balaovolumetrico);
  });

  // PIPETA VOLUMÉTRICA
  var listapipetavolumetrica=[];
  var verificacaopipetavolumetrica = true;
  var pipetavolumetrica_ambientacao = $('.pipetavolumetrica-ambientacao').val();
  var pipetavolumetrica_qtd_ambientes = $('.pipetavolumetrica-qtd_ambientes').val();
  var pipetavolumetrica_agitacao = $('.pipetavolumetrica-agitacao').val();
  var pipetavolumetrica_mistura = $('.pipetavolumetrica-mistura').val();

  $('.linha-pipetavolumetrica').each(function () {
    var o = $(this);
    var pipeta_disponivel = ($(o).find('.pipetavolumetrica-disponivel:checked').length)?true:false;
    var pipeta_qtd_maxima = $(o).find('.pipetavolumetrica-qtd_maxima').val();
    var pipeta_faixa_aceitavel = $(o).find('.pipetavolumetrica-faixa_aceitavel').val();
    var pipeta_desvio_padrao =  $(o).find('.pipetavolumetrica-desvio_padrao').val();

    if(pipeta_disponivel && (pipeta_qtd_maxima<0 || pipeta_qtd_maxima>10 || 
      pipeta_faixa_aceitavel<90 || pipeta_faixa_aceitavel>110 ||
      pipeta_desvio_padrao<0 || pipeta_desvio_padrao>1))  
        verificacaopipetavolumetrica = false;

    var pipetavolumetrica = {
      "id": $(o).attr('data-id'),
      "disponivel": pipeta_disponivel,
      "qtd_maxima": pipeta_qtd_maxima,
      "ambientacao": pipetavolumetrica_ambientacao,
      "qtd_ambientes":  pipetavolumetrica_qtd_ambientes,
      "agitacao":  pipetavolumetrica_agitacao,
      "faixa_aceitavel": pipeta_faixa_aceitavel,
      "desvio_padrao":  pipeta_desvio_padrao,
      "mistura":  pipetavolumetrica_mistura,
    };
    //console.log(pipetavolumetrica);
    listapipetavolumetrica.push(pipetavolumetrica);
  });

  // PIPETADORES
  var listapipetador=[];
  var verificacaopipetador = true;
  var pipetador_animacao = $('.pipetador-animacao').val();

  $('.linha-pipetador').each(function () {
    var o = $(this);
    var pipetador_disponivel = ($(o).find('.pipetador-disponivel:checked').length)?true:false;
    var pipetador_qtd_maxima = $(o).find('.pipetador-qtd_maxima').val();

    if(pipetador_disponivel && (pipetador_qtd_maxima<0 || pipetador_qtd_maxima>2))  
        verificacaopipetador = false;

    var pipetador = {
      "id": $(o).attr('data-id'),
      "disponivel": pipetador_disponivel,
      "tamanho": $(o).find('.pipetador-tamanho').val(),
      "qtd_maxima": pipetador_qtd_maxima,
      "animacao": pipetador_animacao
    };
    //console.log(pipetador);
    listapipetador.push(pipetador);
  });

  // MICROPIPETA
  var listamicropipeta=[];
  var verificacaomicropipeta = true;
  var micropipeta_animacao = $('.micropipeta-animacao').val();

  $('.linha-micropipeta').each(function () {
    var o = $(this);
    var micropipeta_disponivel = ($(o).find('.micropipeta-disponivel:checked').length)?true:false;
    var micropipeta_qtd_maxima = $(o).find('.micropipeta-qtd_maxima').val();

    if(micropipeta_disponivel && (micropipeta_qtd_maxima<0 || micropipeta_qtd_maxima>10))
        verificacaomicropipeta = false;

    var micropipeta = {
      "id": $(o).attr('data-id'),
      "disponivel": micropipeta_disponivel,
      "qtd_maxima": micropipeta_qtd_maxima,
      "animacao": micropipeta_animacao,
    };
    //console.log(micropipeta);
    listamicropipeta.push(micropipeta);
  });

  
  if (verificacaopipetavolumetrica && verificacaobalaovolumetrico && verificacaobequer && verificacaopipetador && verificacaomicropipeta) { 
    $.ajax({
      url: funcao,
      type: 'POST',
      data: {
        bequer: JSON.stringify(listabequer),
        balao: JSON.stringify(listabalaovolumetrico),
        pipeta: JSON.stringify(listapipetavolumetrica),
        pipetador: JSON.stringify(listapipetador),
        micropipeta: JSON.stringify(listamicropipeta),
        id_solucoes_pratica:JSON.stringify(id_solucoes_pratica),
        pratica: pratica,
        resumo: resumo,
        disciplina: disciplina,
        disponivel: disponivel,
        bancada: bancada,
        id_pratica: (bd)?bd.id_pratica:0
      },
    }).done(function (data) {
      if(data.status) {
        bd.id_pratica = parseInt(data.status);
        //Se for positivo, mostra ao utilizador uma janela de sucesso.
        alert('Informações salvas com sucesso!');
        window.location = 'index.php?aba=editaula&id_disciplina='+disciplina+'&id_pratica='+bd.id_pratica
      } else {
        //Caso contrário dizemos que aconteceu algum erro.
        alert('Erro com banco de dados. Tente novamente mais tarde. Se persistir o erro, contate o administrador.');
      }
    });
  } else {
    alert('Por favor, verifique os dados inseridos');
  }   
}
*/
function selecionar_disciplina() {
  //  var nomedisciplina = $('#listaDisciplinas').find("option:selected").text();
  disciplina_acessada = $('#listaDisciplinas').val();
  window.location = 'index.php?aba=aulas&id_disciplina=' + disciplina_acessada;
};


function salvarDisciplina() {
  var nome = $('#nome_disciplina_nova').val();
  //$sql = $lab->insertDisciplina();
  $.ajax({
    url: "funcoes/insert_disciplina.php",
    type: 'POST',
    data: {
      nome: nome
    },
  }).done(function (data) {
    console.log(data);
    if (data.status == true) {
      //Se for positivo, mostra ao utilizador uma janela de sucesso.
      alert('Informações salvas com sucesso!');
      location.href = "index.php"
    } else {
      //Caso contrário dizemos que aconteceu algum erro.
      alert('Erro com banco de dados. Tente novamente mais tarde. Se persistir o erro, contate o administrador.');
    }
  });
}

function remover_disciplina(){
  disciplina_acessada = $('#listaDisciplinas').val();
    $.ajax({
        url:"funcoes/apagar_disciplina.php",
        type: 'POST',
        data: {
          id_disciplina: disciplina_acessada,
        },
        success: function (data) {
          console.log(data);
           if(data.status == true) {
              //  $('#listaDisciplinas').find("option:selected").remove()  
               window.location="index.php?aba=inicio";
           }
           else {
               alert("Erro no banco de dados. Se o problema permitir, contate o administrador");
           }
        },
        error: function(data) {
            alert('Erro na conexão. Se o problema permitir, contate o administrador');
        }
    });
}
/*
function toggle_visibility(id) {
  var e = document.getElementById(id);
  if(e.style.display == 'block')
     e.style.display = 'none';
  else
     e.style.display = 'block';
}


function formularioAcessarLaboratorio(){
  location.href="../area_laboratorio/lab.php"
}

// Script de solucoes.php
var solucao_selecionada;
function criar_solucao(){
  $(".btn-criar").show();
  $(".btn-editar").hide();
  $("#nome_tecnico")[0].value = 'Técnico da CEAD';
  $("#descricao_solucao")[0].value = '';
  $("#nome_solucao")[0].value = '';
  $("#data_de_criacao")[0].value = '1';
  $("#especies_na_solucao").empty();
}

function editar_solucao(){
    $(".btn-criar").hide()
    $(".btn-editar").show()
  
  var b=$("#especies_disponiveis option:disabled");
  for(i=0; i<b.length; i++){ 
    b[i].disabled = false;
  }
  var id_solucao = $("#select_solucoes option:selected")[0].value;
  console.log(id_solucao);
  $.ajax({
    url: "funcoes/consulta_edit_solucao.php",
    data: { 
      id_solucao:id_solucao,
        },
    }).done(function(data){
      console.log(data);
        if(data.status){

          $("#nome_tecnico")[0].value =  data.nome_tecnico;
          $("#descricao_solucao")[0].value =  data.descricao_solucao;
          $("#nome_solucao")[0].value =  data.nome_solucao;
          $("#data_de_criacao")[0].value =  data.data_de_criacao;
          
          $("#especies_na_solucao").empty();
          for(i=0;i<data.nomes_composicao.length;i++){
          var novalinha = "<tr class="+data.ids_composicao[i]+"><td class='nomes_composicao'>"+data.nomes_composicao[i]+"</td><td class='conc_lista_solucao'>"+data.conc_lista_solucao[i]+"</td><td> mol/L</td><td><button onclick='deletar_linha(this)'>Excluir </button></td></tr>";
          
          $("#especies_na_solucao").append(novalinha); 
          };
        }else{
          alert("Erro");
        }
    });
}

function concluir_editar_solucao(){
  var nomes_composicao=[];
  var ids_composicao=[];
  var concentracoes=[];
  var id_solucao = $("#select_solucoes option:selected")[0].value;

  for(i=0;i<$(".nomes_composicao").length;i++){
      nomes_composicao[i]=$(".nomes_composicao")[i].textContent;
      concentracoes[i]=Number($(".conc_lista_solucao")[i].textContent);
      ids_composicao[i]=Number($(".nomes_composicao").parent()[i].className);
  }
  var nome_tecnico = $("#nome_tecnico")[0].value;
  var descricao_solucao = $("#descricao_solucao")[0].value;
  var nome_solucao = $("#nome_solucao")[0].value;
  var data_de_criacao = $("#data_de_criacao")[0].value;
  $.ajax({
      url: "funcoes/insert_edit_solucao.php",
      data: { 
          nomes_composicao:nomes_composicao,
          nome_solucao:nome_solucao,
          conc_lista_solucao:concentracoes,
          descricao_solucao:descricao_solucao,
          nome_tecnico:nome_tecnico,
          data_de_criacao:data_de_criacao,
          ids_composicao:ids_composicao,
          id_solucao:id_solucao,
          },
      }).done(function(data){
        console.log(data)

          if(data.status){
              alert("Concluído com sucesso!");
              location.href="index.php"
          }else{
              alert("Erro");
          }
      });
}

function adicionar_solucao_armario_data(o) {
    var nome = o.text;
    var id_solucao = o.value;

    var novalinha = "<tr class="+id_solucao;
    novalinha+= "><td class='id_solucoes_pratica' data-id="+id_solucao;
    novalinha+= ">"+nome+"</td><td>";
    novalinha+= "<button onclick='remover_solucao_armario(this)' class='btn vermelho'>Excluir </button>";
    novalinha+= "</td></tr>";
    $("#lista_solucoes_pratica").append(novalinha); 
    //$("#select_solucoes option:selected")[0].disabled = true;
    // $("#select_solucoes option:not(:selected) + option:not(:disabled)")[0].selected = true

    //$(".botao_adicionar")[0].disabled = true;
}

function adicionar_solucao_armario(){
    var nome = $("#select_solucoes option:selected")[0].text;
    var id_solucao = $("#select_solucoes option:selected")[0].value;

    // Nao permite que uma mesm solucao
    // seja adicionada ao armario mais de uma vez
    if ($('.id_solucoes_pratica[data-id="'+id_solucao+'"]').length) return;

    adicionar_solucao_armario_data({text:nome, value:id_solucao});
};

function remover_solucao_armario(a){
    $("#select_solucoes option:contains("+a.parentNode.parentNode.children[0].textContent+")")[0].disabled = false
    a.parentNode.parentNode.remove();
};

$(document).ready(function(){

$("#select_solucoes").change(function(){
    $('.composicao_solucao_option').html(" Composição: \n "+ $("#select_solucoes option:selected").attr('descricao'));
    $(".botao_adicionar")[0].disabled = false;
});
});  

// Script de criar_solucao.php

function deletar_linha(a){
    $("#especies_disponiveis option:contains("+a.parentNode.parentNode.children[0].textContent+")")[0].disabled = false
    a.parentNode.parentNode.remove();
};

function concluir_criar_solucao(){
    var nomes_composicao=[];
    var ids_composicao=[];
    var concentracoes=[];
    for(i=0;i<$(".nomes_composicao").length;i++){
        nomes_composicao[i]=$(".nomes_composicao")[i].textContent;
        concentracoes[i]=Number($(".conc_lista_solucao")[i].textContent);
        ids_composicao[i]=Number($(".nomes_composicao").parent()[i].className);
    }
    var nome_tecnico = $("#nome_tecnico")[0].value;
    var descricao_solucao = $("#descricao_solucao")[0].value;
    var nome_solucao = $("#nome_solucao")[0].value;
    var data_de_criacao = $("#data_de_criacao")[0].value;
    $.ajax({
        url: "funcoes/insert_nova_solucao.php",
        data: { 
            nomes_composicao:nomes_composicao,
            nome_solucao:nome_solucao,
            conc_lista_solucao:concentracoes,
            descricao_solucao:descricao_solucao,
            nome_tecnico:nome_tecnico,
            data_de_criacao:data_de_criacao,
            ids_composicao:ids_composicao,
          },
        }).done(function(data){
            if(data.status){
                alert("Concluído com sucesso!")
                //location.href="index.php"
            }else{
                alert("Erro");
            }
        });
}

function atualizarPerfil(){
  var nome = $('#nome_novo').val();
  var senha = $('#senha1').val();
  var confsenha = $('#senha2').val();
  var email = $('#email_novo').val();
  if(senha != confsenha)
  {
    alert('As senhas digitadas devem ser idênticas. Tente novamente');
  }
  else if(nome === "" && senha === "" && email === "")
  {
    alert('Por favor, insira os dados que deseja alterar');
  }
  else{
    $.ajax({
      url:"funcoes/atualiza_perfil.php",
      type: 'POST',
      data: {
        nome: nome,
        senha: senha,
        email: email
      },
    }).done(function (data) {
      console.log(data);
        if(data.status == true) {
          //Se for positivo, mostra ao utilizador uma janela de sucesso.
          alert('Informações salvas com sucesso!');
          window.location='index.php?aba=inicio'
      } else {
          //Caso contrário dizemos que aconteceu algum erro.
          alert('Erro com banco de dados. Tente novamente mais tarde. Se persistir o erro, contate o administrador.');
      }
    });
  }
}

function salvarAluno()
{
  var nome = $('#nome_aluno').val();
  var usuario = $('#usuario_aluno').val();
  var email = $('#email_aluno').val();
  
  user = email.substring(0, email.indexOf("@"));
  dominio = email.substring(email.indexOf("@")+ 1, email.length);
  

  if(email === "" || usuario === "" || email === "")
  
  {
    alert('Por favor, preencha todos os dados');
  }
  else
  {
    if (
    (user.length >=1) &&
    (dominio.length >=3) && 
    (user.search("@")==-1) && 
    (dominio.search("@")==-1) &&
    (user.search(" ")==-1) && 
    (dominio.search(" ")==-1) &&
    (dominio.search(".")!=-1) &&      
    (dominio.indexOf(".") >=1)&& 
    (dominio.lastIndexOf(".") < dominio.length - 1)) { 
    $.ajax({
    url:"funcoes/insert_aluno.php",
    type: 'POST',
      data: {
        nome: nome,
        usuario: usuario,
        email: email
      },
    }).done(function (data) {
      console.log(data);
        if(data.status == true) {
          //Se for positivo, mostra ao utilizador uma janela de sucesso.
        alert('Aluno salvo com sucesso! A senha padrão é 123456, aconselhe seus alunos a alterarem a senha no primeiro acesso.');
        location.href="index.php"
      } else {
          //Caso contrário dizemos que aconteceu algum erro.
          alert('Usuário já existe');
      }
    });
} else {alert("Endereço de e-mail inválido")};
}
  
}

function editaDisciplina(id)
{
  //alert(id);
  toggle_visibility('novo_nome-'+id);
  toggle_visibility('nome_disciplina-'+id);
  toggle_visibility('deditar-'+id);
  toggle_visibility('dexcluir-'+id);
  toggle_visibility('datualizar-'+id);

}

function atualizaDisciplina(id)
{
  var nome = $('#novo_nome-'+id).val();
  if(nome != "")
  {
    $.ajax({
      url:"funcoes/atualiza_disciplina.php",
      type: 'POST',
      data: {
        nome: nome,
      id: id
      },
    }).done(function (data) {
      console.log(data);
        if(data.status == true) {
          //Se for positivo, mostra ao utilizador uma janela de sucesso.
          $('#nome_disciplina-'+id).text(nome);
      } else {
          //Caso contrário dizemos que aconteceu algum erro.
          alert('Erro com banco de dados. Tente novamente mais tarde. Se persistir o erro, contate o administrador.');
      }
    });
  }
  
  editaDisciplina(id);
}

function selecionar_aula_pratica(){

  nome = $(".active")[0].textContent;
  var novalinha = "<tr><td class='item_lista_aula_pratica'>"+nome+"</td><td>";
      novalinha+= "<button onclick='remover_item_aula_pratica(this)'>Excluir </button>";
      novalinha+= "</td></tr>";
  $("#lista_praticas_disponiveis").append(novalinha); 
  $(".selecao")[0].disabled = true;

}

function remover_item_aula_pratica(a){
}

$(document).ready(function(){
    
  $(".option").on("click", function() { 

      $('.option').addClass( 'inactive' );  
      $('.option').removeClass( 'active' );  
      $( this ).toggleClass('active');
      $( this ).toggleClass('inactive');
      getResumo($( this ).attr('id'));
  });

  $("#mostrar-resumo").on("click", function() { 
      var x = document.getElementById("show_resumo");
      if (x.style.display === "none") {
          x.style.display = "block";
      } else {
          x.style.display = "none";
      }    
  });

}); 

function getResumo(id)
{
  $.ajax({
      url:"funcoes/busca_resumo.php",
      type: 'POST',
      data: {
        id_pratica: id
      },

      success: function (data) {
          $("#show_resumo").text(data[0].resumo);
      }
  });
}

function deletar_pratica(id)
{
  $("#modal_confirmar_exclusao").modal('hide')

  $.ajax({
      url:"funcoes/apagar_pratica.php",
      type: 'POST',
      data: {
        id_pratica: id
      },
      success: function (data) {
         if(data.status == true) {
             $("#"+id).remove();
             $("#modal_confirmar_exclusao").modal('hide')

         }
         else {
             alert("Erro no banco de dados. Se o problema permitir, contate o administrador");
         }
      },
      error: function(data) {
          alert('Erro na conexão. Se o problema permitir, contate o administrador');
      }
  });
}
*/