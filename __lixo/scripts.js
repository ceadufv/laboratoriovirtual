$(document).ready(function()
{
  $('[data-toggle="tooltip"]').tooltip();

  $(".titulo-pratica h1").text(document.title);
  
  configuracao_inicial();

  $("#salvar").on("click", function() {
    $(this).attr("disabled", "disabled");
    setTimeout('$("#salvar").removeAttr("disabled")', 1500);
  });

}); 

function configuracao_inicial() 
{
  //Itens selecionados e preenchidos

  var inicial = [5, 10 ];
  inicial.forEach(function (item){
    $(".item-"+item)[0].checked = true;
    
    $(".item-"+item)[1].value = 2;

    //SUGESTÃO FREIRE(COM ITENS INICIALMENTE DESABILITADOS NO HTML)
    $(".item-"+item).each(function(){
    this.disabled=false;
    });
    
    $(".item-"+item)[7].disabled = true; //MISTURA DESABILITADO


  });

 
  // SUGESTÃO DUDA (COM ITENS INICIALMENTE HABILITADOS NO HTML)

  //Itens não selecionados
  // var nao_selecionados = [5, 10]; //itens não selecionados
  // nao_selecionados.forEach(id => {
  //   document.getElementById('qtd_maxima-'+id).disabled = true;
  //   document.getElementById('ambientacao-'+id).disabled = true;
  //   document.getElementById('qtd_ambientes-'+id).disabled = true;
  //   document.getElementById('agitacao-'+id).disabled = true;
  //   document.getElementById('faixa_aceitavel-'+id).disabled = true;
  //   document.getElementById('desvio_padrao-'+id).disabled = true;
  // });
  // //Itens desabilitados
  // var desabilitados = [400,500,600,1000,2000,'mistura'];
  // desabilitados.forEach(id => {
  //   $(".item-"+id).each(function(){this.disabled=true});
  // });    

}

function ativacao_itens(checkbox,id)
{
  document.getElementById('qtd_maxima-'+id).disabled = !(checkbox.checked);
  document.getElementById('ambientacao-'+id).disabled = !(checkbox.checked);
  document.getElementById('qtd_ambientes-'+id).disabled = !(checkbox.checked);
  document.getElementById('agitacao-'+id).disabled = !(checkbox.checked);
  document.getElementById('faixa_aceitavel-'+id).disabled = !(checkbox.checked);
  document.getElementById('desvio_padrao-'+id).disabled = !(checkbox.checked);
}

function post(){
  var certo = true;
  var json = [];

  $('.linha').each(function () {
    
    var o = $(this);
    var disponivel = ($(o).find('.item-disponivel:checked').length)?true:false;
    var qtd_maxima = $(o).find('.item-qtd_maxima').val();
    var faixa_aceitavel = $(o).find('.item-faixa_aceitavel').val();
    var desvio_padrao =  $(o).find('.item-desvio_padrao').val();

    if(disponivel && (qtd_maxima<0 || qtd_maxima>10 || 
      faixa_aceitavel<90 || faixa_aceitavel>110 ||
      desvio_padrao<0 || desvio_padrao>1))  
          certo = false;

    var item = {
      "id": $(o).attr('data-id'),
      "disponivel": disponivel,
      "qtd_maxima": qtd_maxima,
      "ambientacao": $(o).find('.item-ambientacao').val(),
      "qtd_ambientes":  $(o).find('.item-qtd_ambientes').val(),
      "agitacao":  $(o).find('.item-agitacao').val(),
      "faixa_aceitavel": faixa_aceitavel,
      "desvio_padrao":  desvio_padrao,
      "mistura":  $(o).find('.item-mistura').val(),
    };
    json.push(item);
  });
  if (certo) { 
    $.ajax({
      url:"insert_pipetavolumetrica.php",
      // url:"teste.php", //Para testes
      type: 'POST',
      data: {
      json: JSON.stringify(json)
      },
    }).done(function (data) {
        if(data.status == true) {
          //Se for positivo, mostra ao utilizador uma janela de sucesso.
        alert('Prática criada com sucesso!');
        window.location.href="../editaula.php";

      } else {
          //Caso contrário dizemos que aconteceu algum erro.
          alert('Erro com banco de dados. Tente novamente mais tarde. Se persistir o erro, contate o administrador.');
      }
    });
  } else {
    alert('Por favor, verifique os dados inseridos');
  } 

}