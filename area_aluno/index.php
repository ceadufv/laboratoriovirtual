<?php
include('../lab-config.php');
include_once(URL_SYSTEM . 'banco/conexao.php');
Login::$permissao_usuario = [1, 2, 3];
Login::checkUser();
$aba_s = (empty($_REQUEST['aba'])) ? "inicio" : $_REQUEST['aba'];
include(URL_SYSTEM . 'area_aluno/header.php');
$sessao = Login::getSession();
?>

<body>
  <div class="interno criacaopraticas">
    <div class="container">
      <div class="row menu p-2">
        <div class="col">
          <h1><span>Laboratório de Química</span></h1>
          <h2 id="nomedoaluno"> <?php echo $sessao['nome'] ?></h2>
        </div>
      </div>
      
      <section class="menu">
        <div class="botoes">
          <button class="opcoes tab-inicio tab-disciplina" onclick="window.location ='index.php?aba=inicio'">Início</button>
          <button class="opcoes tab-aulas" onclick="window.location='index.php?aba=aulas'">Práticas</button>
          <button class="opcoes tab-registros" onclick="window.location='index.php?aba=registros'">Minhas ações</button>
          <button class="opcoes tab-perfil" onclick="window.location='index.php?aba=perfil'">Meu perfil</button>
          <button class="opcoes tab-sobre" onclick="window.location.href='index.php?aba=sobre'">Sobre o projeto</button>
          <button class="opcoes tab-sair" onclick="logoff()">Sair</button>
        </div>
      </section>

      <section class="conteudoabas">
        <div class="section">
          <?php include("abas/" . $aba_s . ".php") ?>
        </div>
      </section>
    </div>
  </div>

  <script>
    $(function() {
      aba('<?php echo $aba_s; ?>');
    });
  </script>
  <?php include('footer.php'); ?>