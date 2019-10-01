$(document).ready(function() {
    $('#praticas').modal({backdrop: 'static', keyboard: false})  
    $('#praticas').modal('show');
  
    $("#fechar-armario").click(function(){
        $('#armario').modal('hide');
    });

    $('select[id="select_acessar_laboratorio"]').change(function(){
      getResumo($(this).val());
    });

    $('html').click(function(e) {
        $('#info').popover('hide');
    });
  
    $('#info').popover({
        title: "Menu",
        content: "<a href='#'>Roteiro da prática (.pdf)</a> <br /><a href='#'>Caderno didático (.pdf)</a> <br />  <a href='#'>Vídeo 1</a>  <br /> ",
        html: true,
        trigger: 'manual'
    }).click(function(e) {
        $(this).popover('toggle');
        e.stopPropagation();
    });
   
});

function getResumo(id)
{
  //alert(id);
  $.ajax({
      url:"busca_resumo.php",
      type: 'POST',
      data: {
        id_pratica: id
      },

      success: function (data) {
          $("#aula_resumo").text(data[0].resumo);
      }
  });
}

function sair_laboratorio(tipo_usuario){
  //if (confirm("Tem certeza que deseja sair")) {
  //window.history.back();
 //}
 if(tipo_usuario == 1)
 {
   window.location = 'index.php';
 }else
 {
  window.location = '../area_professor/index.php';
 } 
 
  
}

function logoff() {
   window.location.href = '../banco/logoff.php';
   
};

function atualizarPerfil(){
  
  var nome = $('#nome_novo').val();
  var senha = $('#senha1').val();
  var confsenha = $('#senha2').val();
  var email = $('#email_novo').val();
  
  if(nome === "" || senha === "" || email === "") {
    //alert('Por favor, insira os dados que deseja alterar');
    alert("Por favor, preencha todos os campos.");

  } else {

    if(senha != confsenha) {
      alert('As senhas digitadas devem ser idênticas. Tente novamente');
    } else {
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
        } else {
          //Caso contrário dizemos que aconteceu algum erro.
          alert('Erro com banco de dados. Tente novamente mais tarde. Se persistir o erro, contate o administrador.');
        }
      });
    }
  }
}

  function aba(tela) {
    $('.opcoes').removeClass('ativo');    
    $('.tab-'+tela).addClass('ativo');
    $('.div-secoes').hide();
    $('.div-secoes.div-'+tela).show();

    // Exibe modal, se houver
    if ($('.modal.div-' + tela).length) {
        $('.modal.div-' + tela).modal('show');        
        $('.div-secoes').hide();
    }
}
