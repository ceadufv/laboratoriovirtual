<?php
include_once('../lab-config.php');
Login::$permissao_usuario = array(1, 2, 3);
Login::checkUser();
$login = Login::getSession();

$objModeloPratica = new ModeloPratica();
$pratica_s = $objModeloPratica->getPraticaPorCod($_REQUEST['id_pratica']);
?>
<!DOCTYPE html>
<html lang="pt" id="full-screen-html">

<head>
  <meta name="viewport" content="width=device-width, user-scalable=no" />
  <title>NeoAlice</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo URL_SITE; ?>imagens/icons/favicon.png" />
  <link rel="manifest" href="<?php echo URL_SITE; ?>assets/manifest/manifest.json" />
  <!-- fontes -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,700,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
  <script>
    const URL_SITE = '<?php echo URL_SITE; ?>';
    const ID_USUARIO = parseInt('<?php echo $login['id_usuario'] ?>');
    const TIPO_USUARIO = parseInt('<?php echo $login['tipo_usuario'] ?>');
    const ID_PRATICA = parseInt('<?php echo $pratica_s['id_modelo_pratica']; ?>');
    const TIPO_ACESSO = '<?php echo $_REQUEST['tipo_acesso']; ?>';
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
  <link rel="stylesheet" href="<?php echo URL_SITE; ?>plugins/vendor/fontawesome-5.11.2/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URL_SITE; ?>area_laboratorio/css/style.css">
  <link rel="stylesheet" href="<?php echo URL_SITE; ?>area_laboratorio/css/lab.css">

  <!-- BOOTBOX -->
  <script src="<?php echo URL_SITE; ?>plugins/vendor/bootbox/bootbox.all.min.js"></script>
</head>

<body>
  <header>
    <nav class="navbar">
      <h1>NeoAlice</h1>
      <h1 id="titulopratica" class="text-center"></h1>
      <div class="controle">

        <?php if ($login['tipo_usuario'] == 2) { ?>
          <button type="button" class="bg-success" onclick="window.location.href='<?php echo URL_SITE;?>area_professor/index.php?aba=editaula&id_pratica=<?php echo $pratica_s['id_modelo_pratica'];?>&id_disciplina=<?php echo $pratica_s['id_disciplina']?>';">
            <i class="far fa-window-restore"></i> Editar Pratica
          </button>
          <button type="button" class="bg-success" onclick="PracticeRegistration.saveWorld('Save manual', 'SAVE');">
            <i class="far fa-save"></i> Salvar
            <b class="resp-save-id"></b>
          </button>
          <button type="button" class="bg-primary" onclick="PractiveRestore.clickRestore();">
            <i class="far fa-window-restore"></i> Restaurar
          </button>
        <?php } ?>

        <button type="button" class="bg-new btn-expand" onclick="Pratica.clickBtnFullScreen();">
          <i class="fas fa-expand"></i> Expandir
        </button>

        <button type="button" class="bg-new" onclick="Pratica.openLandscapescreen();">
          <i class="fa fas fa-sync"></i> Girar
        </button>

        <button id="info" type="button" style="background-color: grey" data-container="body" data-placement="bottom">
          <i class="fas fa-book"></i>
        </button>
        <button class="fechar" onclick="Pratica.sairLaboratorio(<?php echo $_SESSION['tipo_usuario'] ?>)">
          <i class="fas fa-window-close"></i>
          SAIR <i class="fa fa-sign-out" aria-hidden="true"></i></button>
      </div>
    </nav>
  </header>

  <?php include 'views/lab-modais.php'; ?>
  <div id="area_jogo"></div>
  <?php include 'views/lab-scripts.php'; ?>
</body>

</html>