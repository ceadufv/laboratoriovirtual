<?php 
  include('../banco/conexao.php');

  header("Content-type: application/json; charset=utf-8");

  $data = array();

  $sql = $banco->prepare("SELECT id_substancia as id, nome, dados FROM substancias order by id_substancia asc");
  $sql->execute();
  $data = $sql->fetchAll( PDO::FETCH_ASSOC );

  $result = array();

  foreach ($data as $key => $value) {
    $result[] = array(
      "id" => (int) $value['id'],
      "nome" => $value['nome'],
      "dados" => json_decode($value['dados'])
    );
    /*
    ['id'] = (int) $data[$key]['id'];
    $data[$key]['data'] = json_decode($data[$key]['data']);
    */
  }

  echo json_encode($result, JSON_PRETTY_PRINT);