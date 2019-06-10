<?php
  session_start();

  header("Content-type: application/json; charset=utf-8");

  include( dirname(__FILE__) . '/../../banco/conexao.php');

  $nome = @$_REQUEST['nome'];
  $id_usuario = $_SESSION['id_usuario'];

  $resultado = array();

  $resultado['status'] = $lab->insertDisciplina($nome, $id_usuario);

  echo json_encode($resultado);