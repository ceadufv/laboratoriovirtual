<?php
  session_start();
  header("Content-type: application/json; charset=utf-8");

  include('../../banco/conexao.php');

  $nome = @$_REQUEST['nome'];
  $id_usuario = $_SESSION['id_usuario'];

  $resultado = array();

  $resultado['status'] = $lab->insertDisciplina($nome, $id_usuario);

  /*$sql_pratica = "INSERT INTO disciplinas (nome, id_professor) 
                  VALUES (?,?)";

  $stmt1 = $dbh->prepare($sql_pratica);
  $stmt1->bindValue(1,$nome);
  $stmt1->bindValue(2,$id_usuario);

  if($stmt1->execute()){  
    $resultado['status'] = true;
  }
  else{
    $resultado['status'] = false;
  }*/
  echo json_encode($resultado);
  

?>
