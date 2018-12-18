<?php 
  include('../../banco/conexao.php');
  header("Content-type: application/json; charset=utf-8");

 
  $id = @$_REQUEST['id_pratica'];
  $resultado = $lab->getResumo($id);
  echo json_encode($resultado);
  
  
  /*$sql = $banco->prepare('SELECT resumo FROM modelo_pratica WHERE id_modelo_pratica = ?');
  $sql->bindValue(1,$id);
  $sql->execute();
  $resultado['status'] = $sql->fetch();
  echo json_encode($resultado);*/
 ?>