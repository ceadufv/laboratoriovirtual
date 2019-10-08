<?php
/**
 * @author Wellerson
 */
include_once ("../lab-config.php");
Login::$permissao_usuario = [1,2,3];
Login::checkUser();
include_once URL_SYSTEM."area_aluno/app/".$_GET['app'].'/'.$_GET['file'].'.php';
?>