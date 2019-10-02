<?php
include('../lab-config.php');
$aba_s = $_REQUEST['aba'];
$aba_s = (empty($aba_s))?"inicio":$aba_s;

include(URL_SYSTEM.'area_professor/funcoes/cabecalho.php'); 
include_once(URL_SYSTEM.'banco/conexao.php');

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
      
      <!-- retirando gambiarras -->
      <section class="conteudoabas"> 
          <div class="section">
            <?php include("abas/".$aba_s.".php") ?>            
          </div>
      </section>
      <!-- /retirando gambiarras -->
    </div>
  </div>            
<script>
const URL_SITE = "<?php echo URL_SITE;?>";

var bd = {
  id_disciplina: parseInt('<?php echo @$_REQUEST['id_disciplina']; ?>'),
  id_pratica: parseInt('<?php echo @$_REQUEST['id_pratica']; ?>'||0),
  aba: '<?php echo $aba_s; ?>'
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
</script>

 <?php include('funcoes/rodape.php'); ?>