<?php 
include('../banco/conexao.php');
header("Content-type: application/json; charset=utf-8");
$id = @$_REQUEST['id_pratica'];
$resultado = $lab->getResumo($id);
echo json_encode($resultado);
?>