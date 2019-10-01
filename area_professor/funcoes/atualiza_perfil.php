<?php
  session_start();
  header("Content-type: application/json; charset=utf-8");

  include('../../banco/conexao.php');

  $nome = @$_REQUEST['nome'];
  $senha = @$_REQUEST['senha'];
  $email = @$_REQUEST['email'];
  $id_usuario = $_SESSION['id_usuario'];
  $_SESSION['nome'] = $nome;
  $resultado = array();
  $resultado['status'] = $lab->setPerfil($nome, $senha, $email, $id_usuario);

  echo json_encode($resultado);

?>
