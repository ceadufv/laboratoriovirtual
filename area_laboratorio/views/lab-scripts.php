<!--
#########
  SCRIPTS 
#########
-->

<!-- VARS globais -->
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/VarsGlobal.js"></script>

<!-- DEFT-->
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/default/transferencia-default.js"></script>


<!-- Business -->
<?php
includeMDir("area_laboratorio/js/business-rule/");
?>

<!-- scenes -->
<?php
includeMDir("area_laboratorio/js/scenes/");
?>

<!-- controllers -->
<?php
includeMDir("area_laboratorio/js/controllers/");
?>


<script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/model/objetos/default/ObjetoDefaultEvents.js"></script>
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/model/objetos/default/ObjetoDefault.js"></script>
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/model/objetos/default/ObjetoDefaultVolume.js"></script>

<?php
includeMDir("area_laboratorio/js/model/objetos/");
?>

<!-- COMPONENTS  -->
<?php
includeMDir("area_laboratorio/js/components/");
?>

<!-- ARMARIO HTML  -->
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/armario/armario-default.js"></script>
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/armario/Armario.js"></script>
<script type="text/javascript" src="<?php echo URL_SITE; ?>area_laboratorio/js/others/armario/ArmarioTabs.js"></script>

<!-- ACTIONS  -->
<?php
includeMDir("area_laboratorio/js/model/actions/default/");
?>
<?php
includeMDir("area_laboratorio/js/model/actions/");
?>
<script>
$(document).ready(function() {
    Pratica.initPratica();
});
</script>


<?php
function includeMDir($dir_relative)
{
    $path = URL_SYSTEM . $dir_relative;
    $diretorio = dir($path);
    while ($arquivo = $diretorio->read()) {
        if (!is_file($path.$arquivo))
            continue;
        echo '<script type="text/javascript" src="' . URL_SITE . $dir_relative . $arquivo . '"></script>';
    }
    $diretorio->close();
}
?>