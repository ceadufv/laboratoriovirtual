<?php
/**
 * @author Wellerson
 */
include('../lab-config.php');
$aba_s = $_REQUEST['aba']; 
include_once(URL_SYSTEM.'banco/conexao.php');
include(URL_SYSTEM."area_professor/abas/".$aba_s.".php");
?>