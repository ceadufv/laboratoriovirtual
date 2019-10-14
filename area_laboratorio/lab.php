<?php
include_once('../lab-config.php');
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <title>NeoAlice</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo URL_SITE; ?>imagens/icons/favicon.png" />
  
  <!-- fontes -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,700,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">

  <script>
    const URL_SITE = '<?php echo URL_SITE; ?>';
    var ID_PRATICA = parseInt('<?php echo $_REQUEST['id_pratica']; ?>');
    var TIPO_ACESSO = '<?php echo $_REQUEST['tipo_acesso']; ?>';
  </script>

  <!-- jquery -->
  <script src="<?php echo URL_SITE; ?>plugins/vendor/jquery/3.4/jquery-3.4.1.min.js"></script>
  <script src="<?php echo URL_SITE; ?>plugins/vendor/jquery/3.4/jquery-migrate-1.4.1.min.js"></script>

  <!-- bootstrap -->
  <script src="<?php echo URL_SITE; ?>plugins/vendor/bootstrap/4.3.1/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo URL_SITE; ?>plugins/vendor/bootstrap/4.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="<?php echo URL_SITE; ?>plugins/vendor/bootstrap/4.3.1/dist/css/bootstrap.min.css">

  <!--vendors-->
  <script src="<?php echo URL_SITE; ?>plugins/vendor/phaser/3.19.0/phaser.min.js"></script>
  <!--<script src="<?php echo URL_SITE; ?>plugins/vendor/phaser/3.12.0/GameScalePlugin.js"></script>-->
 
  <!-- estilos -->
  <link rel="stylesheet" href="<?php echo URL_SITE; ?>plugins/vendor/awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo URL_SITE; ?>area_laboratorio/css/style.css">
  <link rel="stylesheet" href="<?php echo URL_SITE; ?>area_laboratorio/css/lab.css">
</head>

<body>
  <header>
    <nav class="navbar">
      <h1>NeoAlice</h1>
      <h1 id="titulopratica" class="text-center"></h1>
      <div class="controle">
        <button id="info" type="button" style="background-color: grey" data-container="body" data-placement="bottom">
          <i class="fa fa-info-circle" aria-hidden="true"></i>
        </button>
        <button class="fechar" onclick="Pratica.sairLaboratorio(<?php echo $_SESSION['tipo_usuario'] ?>)">SAIR <i class="fa fa-sign-out" aria-hidden="true"></i></button>
      </div>
    </nav>
  </header>

  <?php include 'views/lab-modais.php';?>
  <div id="area_jogo"></div>

  <!-- 
      #########
      SCRIPTS 
      #########
    -->

  <!-- VARS globais -->
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/VarsGlobal.js"></script>

  <!-- DEFT-->
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/default/armario-default.js"></script>
  
  <!--DROP ZONES -->
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/DropZone.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/DropZones.js"></script>

  <!-- OBJETOS  -->
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/ObjetoDefault.js"></script>
  <?php
  $path = URL_SYSTEM . "area_laboratorio/js/model/objetos/";
  $diretorio = dir($path);
  while ($arquivo = $diretorio->read()) {
    if ($arquivo == '.' || $arquivo == '..')
      continue;
    echo '<script type="text/javascript" src="' . URL_SITE . 'area_laboratorio/js/model/objetos/' . $arquivo . '"></script>';
  }
  $diretorio->close();
  ?>

  <!-- business-rule -->
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/business-rule/QuimicaFormulas.js"></script>

  <!-- COMPONENTS  -->
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/components/Debug.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/components/PageAnimation.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/components/MenuInteract.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/components/PracticeRegistration.js"></script>

  <!-- OTHERS  -->
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/Armario.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/ArmarioTabs.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/Pratica.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/Laboratorio.js"></script>
  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/LaboratorioDefault.js"></script>

  <script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/SceneObjectsSLab.js"></script>
  <!-- ACTIONS  -->
  <?php
  $path = URL_SYSTEM . "area_laboratorio/js/model/actions/";
  $diretorio = dir($path);
  while ($arquivo = $diretorio->read()) {
    if ($arquivo == '.' || $arquivo == '..')
      continue;
    echo '<script type="text/javascript" src="' . URL_SITE . 'area_laboratorio/js/model/actions/' . $arquivo . '"></script>';
  }
  $diretorio->close();
  ?>

  <script>
    $(document).ready(function() {
      Pratica.initPratica();
    });
  </script>
</body>
</html>