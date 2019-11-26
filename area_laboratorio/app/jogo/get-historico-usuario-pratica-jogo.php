<?php
header("Content-type: application/json; charset=utf-8");
$objModeloPraticaUUsuario = new ModeloPraticaUUsuario();
$dados = $objModeloPraticaUUsuario->getHistoricoPorCod($_GET['id']);
echo json_encode(array('data'=>$dados['dados_mopr_u_us'], 'success'=> true));
?>