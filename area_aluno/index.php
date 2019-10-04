<?php 
include('../lab-config.php');
include('cabecalho.php');
include('../banco/conexao.php');
Login::checkUser();
?>

<body>
  <div class="interno">
    <div class="container">
      <div class="row menu p-2">
        <div class="col">
          <h1><span>Laboratório de Química</span></h1>
          <h2 id="nomedoaluno"> <?php echo @$_SESSION['nome']?></h2>
        </div>
      </div>

      <section class="menu">
        <div class="botoes">
          <button class="opcoes ativo tab-inicio tab-disciplina" onclick="aba('inicio')">Início</button>
          <button class="opcoes tab-registros" onclick="aba('registros')">Minhas ações</button>       
          <button class="opcoes tab-perfil" onclick="aba('perfil')">Meu perfil</button>      
          <button class="opcoes tab-sobre" onclick="aba('sobre')">Sobre o projeto</button>        
          <button class="opcoes tab-sair" onclick="logoff()">Sair</button>
        </div>
      </section>

      <section class="conteudoabas"> 

        <div class="section div-secoes div-inicio opcoeslogin">
          <?php include("abas/".$_REQUEST['aba'].".php") ?>            
        </div>
        
        <?php
        /*
        <div class="section div-secoes div-perfil oculta">
          <?php include("abas/perfil.php") ?>       
        </div>
        <div class="section div-secoes div-registros oculta">
          <?php include("abas/registros.php") ?>       
        </div>
        <div class="section div-secoes div-sobre oculta">
          <?php include("abas/sobre.php") ?>       
        </div>
        */
        ?>
        
      </section>
    </div>
  </div>
                      
 <?php include('rodape.php'); ?>