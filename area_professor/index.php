<?php
include('../lab-config.php');
include_once(URL_SYSTEM.'banco/conexao.php');
Login::$permissao_usuario = [1,2];
Login::checkUser();
$aba_s = (empty($_REQUEST['aba'])) ? "inicio" : $_REQUEST['aba'];
include(URL_SYSTEM.'area_professor/header.php'); 
?>
<body>
  <div class="interno criacaopraticas">
    <div class="container">
      <div class="row menu p-2">
        <div class="col">
          <h1><span>Laboratório de Química</span></h1>
          <!--<h2 id="nomedoprofessor"></h2>-->
        </div>
      </div>

      <section class="menu">
        <div class="botoes">
          <button class="opcoes tab-inicio tab-disciplina <?php echo ($aba_s == 'inicio' ? 'ativo' : '')?>" onclick="window.location = 'index.php?aba=inicio'">Início</button>
          <button class="opcoes tab-alunos <?php echo ($aba_s == 'alunos' ? 'ativo' : '')?>" onclick="window.location = 'index.php?aba=alunos'">Alunos</button>
          <button class="opcoes tab-perfil <?php echo ($aba_s == 'perfil' ? 'ativo' : '')?>" onclick="window.location = 'index.php?aba=perfil'">Meu perfil</button>
          <button class="opcoes tab-sobre <?php echo ($aba_s == 'sobre' ? 'ativo' : '')?>" onclick="window.location = 'index.php?aba=sobre'">Sobre o projeto</button>
          <button class="opcoes tab-sair" onclick="window.location = URL_SITE+'logout.php'">Sair</button>
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
</script>
 <?php include('footer.php'); ?>