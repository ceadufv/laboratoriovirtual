<?php
 header("Content-type: application/json; charset=utf-8");
 include(URL_SYSTEM.'banco/conexao.php');

  $id_pratica = @$_REQUEST['id_pratica'];
  $resultado = array();

  $sql = "DELETE FROM modelo_pratica WHERE id_modelo_pratica = ? LIMIT 1";
  $stmt = $dbh->prepare($sql);
  $del = $stmt->execute( array( $id_pratica ) );

  $resultado['status'] = ($stmt->rowCount())?true:false;

  echo json_encode($resultado);