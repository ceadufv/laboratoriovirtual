<?php
header("Content-type: application/json; charset=utf-8");
include(URL_SYSTEM.'banco/conexao.php');

$id_disciplina = @$_REQUEST['id_disciplina'];
$resultado = array();
$resultado['id_disciplina'] = $id_disciplina;
$resultado['status'] = $lab->apagarDisciplina($id_disciplina);

echo json_encode($resultado);
?>
