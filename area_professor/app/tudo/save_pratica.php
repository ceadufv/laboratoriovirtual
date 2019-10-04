<?php
  // Insere ou altea uma pratica no banco.
  // Se receber ID, a acao sera de UPDATE. Senao, sera de criacao de novo registro
  header("Content-type: application/json; charset=utf-8");
  include(URL_SYSTEM.'banco/conexao.php');

  $id_pratica = !empty(@$_REQUEST['id_pratica'])?@$_REQUEST['id_pratica']:0;
  $bequer = @$_REQUEST['bequer'];
  $balao = @$_REQUEST['balao'];
  $pipeta = @$_REQUEST['pipeta'];
  $pipetador = @$_REQUEST['pipetador'];
  $micropipeta = @$_REQUEST['micropipeta'];
  $pratica = @$_REQUEST['pratica'];
  $id_solucoes_pratica = @$_REQUEST['id_solucoes_pratica'];
  $disciplina = @$_REQUEST['disciplina'];
  $resumo = @$_REQUEST['resumo'];
  $disponivel = @$_REQUEST['disponivel'];
  $bancada = @$_REQUEST['bancada'];

  $id_usuario = $_SESSION['id_usuario'];

  $praticadisponivel = ($disponivel=='true')? 1: 0;
  $resultado = array();

  $json = array(
    "bequer" => json_decode($bequer),
    "balao" => json_decode($balao),
    "pipeta" => json_decode($pipeta),
    "pipetador" => json_decode($pipetador),
    "micropipeta" => json_decode($micropipeta),
    "id_solucoes_pratica" => json_decode($id_solucoes_pratica)
  );

  $data = json_encode($json);

  // Inserir
  if (empty($id_pratica)) {
    $sql_pratica = "INSERT INTO modelo_pratica (nome_pratica, id_disciplina, id_usuario, resumo, disponivel, id_cenario, data) VALUES (?,?,?,?,?,?,?)";
    $stmt = $dbh->prepare($sql_pratica);
    $stmt->execute(array(
      $pratica, $disciplina, $id_usuario, $resumo, $praticadisponivel, $bancada, $data
    ));
    $id_pratica = $dbh->lastInsertId();
  }
  // Atualizar
  else {
    $sql_pratica = "UPDATE modelo_pratica SET nome_pratica=?, id_disciplina=?, id_usuario=?, resumo=?, disponivel=?, id_cenario=?, data=? WHERE id_modelo_pratica=?";
    $stmt = $dbh->prepare($sql_pratica);
    $stmt->execute(array(
      $pratica, $disciplina, $id_usuario, $resumo, $praticadisponivel, $bancada, $data, $id_pratica
    ));

    //$count = $stmt->rowCount();
    //$id_pratica = ($count)?$id_pratica:0;
  }

  echo json_encode(
    array(
      "status" => $id_pratica
    )
  );
?>
