<?php include(dirname(__FILE__).'/funcoes/cabecalho.php'); 
      include_once(dirname(__FILE__).'/../banco/conexao.php');
      if($_REQUEST['acao']=="editaraula") print_r('a');

      $aba = (empty(@$_REQUEST['aba']))?"inicio":@$_REQUEST['aba'];
?>
<body>
  <div class="interno criacaopraticas">
    <div class="container">
      <div class="row menu p-2">
        <div class="col">
          <h1><span>Laboratório de Química</span></h1>
          <h2 id="nomedoprofessor">Professor <?php echo @$_SESSION['nome']?></h2>
        </div>
      </div>

      <section class="menu">
        <div class="botoes">
          <button class="opcoes ativo tab-inicio tab-disciplina" onclick="window.location = 'index.php?aba=inicio'">Início</button>
          <button class="opcoes tab-alunos" onclick="window.location = 'index.php?aba=alunos'">Meus Alunos</button>
          <button class="opcoes tab-perfil" onclick="window.location = 'index.php?aba=perfil'">Meu perfil</button>
          <button class="opcoes tab-sobre" onclick="window.location = 'index.php?aba=sobre'">Sobre o projeto</button>
          <button class="opcoes tab-sair" onclick="logoff()">Sair</button>
        </div>
      </section>

      <section class="conteudoabas"> 

        <div class="section div-secoes div-inicio opcoeslogin">
          <?php include("abas/inicio.php") ?>            
        </div>

        <div class="section div-secoes div-aulas oculta">
          <?php include("abas/aulas.php") ?>    
        </div>

        <div class="section div-secoes div-alunos oculta">
          <?php include("abas/alunos.php") ?>            
        </div>

        <div class="section div-secoes div-registros oculta">
          <?php include("abas/registros.php") ?>       
        </div>

        <div class="section div-secoes div-perfil oculta">
          <?php include("abas/perfil.php") ?>       
        </div>

        <div class="section div-secoes div-sobre oculta">
          <?php include("abas/sobre.php") ?>       
        </div>

        <div class="section div-secoes div-editaula oculta">
          <?php include("abas/editaula.php") ?>            
        </div>

      </section>
    </div>
  </div>            

<script>
var bd = {
  id_disciplina: parseInt('<?php echo @$_REQUEST['id_disciplina']; ?>'),
  id_pratica: parseInt('<?php echo @$_REQUEST['id_pratica']; ?>'||0),
  aba: '<?php echo $aba; ?>'
};

<?php
$id_disciplina = @$_REQUEST['id_disciplina'];
$id_pratica = @$_REQUEST['id_pratica'];

if (!empty( $id_disciplina )) {
  $consulta = $dbh->prepare('SELECT nome FROM disciplinas WHERE id_disciplina=?');
  $consulta -> execute(array($id_disciplina));
  $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
  $nome_disciplina = $resultado[0]['nome'];

  echo "bd.nome_disciplina='$nome_disciplina';\n";
}

if (!empty( $id_pratica )) {
  $consulta = $dbh->prepare('SELECT nome_pratica as nome FROM modelo_pratica WHERE id_modelo_pratica=?');
  $consulta -> execute(array($id_pratica));
  $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
  $nome_pratica = $resultado[0]['nome'];
  echo "bd.nome_pratica='$nome_pratica';\n";
}
?>

$(function () {
  aba(bd.aba);
  
  var breadcrumb = [];
  if (bd.id_disciplina) {
    breadcrumb.push('<a href="?aba=aulas&id_disciplina='+bd.id_disciplina+'">'+bd.nome_disciplina+'</a>');
  }

  if (bd.id_pratica) {
    breadcrumb.push('<a href="?aba=aulas&id_disciplina='+bd.id_disciplina+'&id_pratica='+bd.id_pratica+'">'+bd.nome_pratica+'</a>');
  }

  $('.navegacao').append(breadcrumb.join(' &gt; '));

  if (bd.id_pratica) {
    load_pratica(bd.id_pratica);
  }
});

function toggle(o) {
	// 
	var tr = $(o).parents('tr');
	var itens = tr.find('*[data-name]');
	var checked = $(o).prop('checked');

	// Desabilita os objetos irmaos do atual, pertencentes a mesma tr
	for (var i =  0 ; i < itens.length ; i++) {
		if ($(itens[i]).attr('name') == $(o).attr('name'))
			continue;

		if ($(itens[i]).prop('tagName') == 'IMG') {
			//
			//$(itens[i]).removeClass('disabled');

			//
			//if (!checked) $(itens[i]).addClass('disabled');			
		} else
			$(itens[i]).prop('disabled', !checked);
	}
}
</script>

 <?php include('funcoes/rodape.php'); ?>