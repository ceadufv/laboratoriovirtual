<?php 
  include ("../banco/conexao.php");

  $action = @$_REQUEST['action'];

  switch ($action) {
    case "pratica":
        $lab->jsonPratica( @$_REQUEST['id_pratica'] );
    break;

    //case "armario":
    //   header("Content-type: application/json; charset=utf-8"); 
        
    //    exit;
    //    break;
    default:
      $sql = $dbh->prepare('select id_modelo_pratica as id, nome_pratica from modelo_pratica order by nome_pratica');
      $sql->execute();
      $praticas = $sql->fetchAll();  
    break;
  }

function armario() {}

function quebra($texto) {
    $campos = explode(',', $texto);
    $array = [];
    $chave = 0;
    foreach ($campos as $campo) {
        $chave = $chave + 1;
        $array[$chave] = $campo;
    }
    return $array;
}

function substancias($composicoes,$ids,$concentracoes) {

    $substancias = array();
    $chave = 0;
    foreach($composicoes as $campo) 
    {
        $chave = $chave + 1;

        $a = array( "substancias" =>
          array(
            array(
            "id" => (int) $ids[$chave],
            "concentracao" => (float) sprintf("%.2f", $concentracoes[$chave]),
            "volume" => 1000
            //"nome" => $composicoes[$chave]
            )
          )
        );

        array_push($substancias, array (

            "data" => array( //cada substancia
              $a
            )  
        ));
    }
   return $substancias;
}