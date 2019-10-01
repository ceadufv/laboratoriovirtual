<?php
/**
 * @author Wellerson
 */
error_reporting(0);
include('../lab-config.php'); 
spl_autoload_register(function ($class_name) {
  require URL_SYSTEM.'classes/'.$class_name . '.class.php';
});
$aba_s = $_REQUEST['aba'];
include(URL_SYSTEM.'funcoes/cabecalho.php'); 
include_once(URL_SYSTEM.'/../banco/conexao.php');
include(URL_SYSTEM."area_professor/abas/".$aba_s.".php");
?>