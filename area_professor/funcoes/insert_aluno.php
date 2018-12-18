<?php
  session_start();
  header("Content-type: application/json; charset=utf-8");

  include('../../banco/conexao.php');

  $nome = @$_REQUEST['nome'];
  $email = @$_REQUEST['email'];
  $usuario = @$_REQUEST['usuario'];
  $resultado = array();

  $resultado['status'] = $lab->insertAluno($nome, $email, $usuario);

  /*$sql = "INSERT INTO usuarios_cadastrados (nome, email, usuario, senha, id_tipo_usuario) 
                  VALUES (?,?,?,?, 1)";
  $stmt1 = $dbh->prepare($sql);
  $stmt1->bindValue(1,$nome);
  $stmt1->bindValue(2,$email);
  $stmt1->bindValue(3,$usuario);
  $stmt1->bindValue(4,$senha);

  if($stmt1->execute()){  
    $resultado['status'] = true;
  }
  else{
    $resultado['status'] = false;
  }*/
  echo json_encode($resultado);

?>
