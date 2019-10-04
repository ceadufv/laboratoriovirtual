<?php
header("Content-type: application/json; charset=utf-8");
include(URL_SYSTEM.'banco/conexao.php');

  $nome = @$_REQUEST['nome'];
  $id_usuario = $_SESSION['id_usuario'];

  $resultado = array();

  $resultado['status'] = $lab->insertDisciplina($nome, $id_usuario);

  echo json_encode($resultado);