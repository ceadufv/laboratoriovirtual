<?php
  include('../../banco/conexao.php');
  session_start();
  header("Content-type: application/json; charset=utf-8");
  
  
  $id_disciplina = @$_REQUEST['id_disciplina'];
  $resultado = array();
  $resultado['id_disciplina'] = $id_disciplina;
  $resultado['status'] = $lab->apagarDisciplina($id_disciplina);
  
  echo json_encode($resultado);

?>
