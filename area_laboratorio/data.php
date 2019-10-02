<?php
include("../banco/conexao.php");
$action = @$_REQUEST['action'];

switch ($action) {
  case "pratica":
    $resultado = $lab->jsonPratica(@$_REQUEST['id_pratica']);
    echo json_encode($resultado);
    break;

  case "pratica_jogo":
    header("Content-type: application/json; charset=utf-8");
    $objCenario = new Cenario();
    $objSubstancias = new Substancias();
    $objModeloPratica = new ModeloPratica();
    $objModeloPraticaSolucao = new ModeloPraticaSolucao();
    $objLaboratorioVirtual = new LaboratorioVirtual();
    $id_pratica = $_REQUEST['id_pratica'];
    $resultado = $objModeloPratica->getJsonLabPratica($id_pratica);
    $resultado['cenario'] = $objCenario->getCenario($resultado['id_cenario'])['data'];
    $resultado['substancias'] = $objSubstancias->getAllSubstancias();
    $resultado['solucoes'] = $objModeloPraticaSolucao->getSolucoesPratica($id_pratica);
    $resultado = $objLaboratorioVirtual->formatTolab($resultado);
    echo json_encode($resultado);
    break;

  case "salvar_pratica":
    header("Conten-type: application/json; charset=utf-8");
    $dados = $_REQUEST;
    if (empty($dados['nome'])) {
      echo json_encode(array('success' => false, 'msg' => 'Título da pratica é inválido', 'id' => 0));
      exit();
    }

    $id = $lab->salvarPratica($_REQUEST);
    if (empty($id)) {
      echo json_encode(array('success' => false, 'msg' => 'Dados inválidos', 'id' => $id));
    } else {
      echo json_encode(array('success' => true, 'msg' => 'A aula foi salva com sucesso', 'id' => $id));
    }
    exit();
    break;

  default:
    $sql = $dbh->prepare('select id_modelo_pratica as id, nome_pratica from modelo_pratica order by nome_pratica');
    $sql->execute();
    $praticas = $sql->fetchAll();
    break;
}

function armario()
{ }

function data()
{ }

function quebra($texto)
{
  $campos = explode(',', $texto);
  $array = [];
  $chave = 0;
  foreach ($campos as $campo) {
    $chave = $chave + 1;
    $array[$chave] = $campo;
  }
  return $array;
}

function substancias($composicoes, $ids, $concentracoes)
{

  $substancias = array();
  $chave = 0;
  foreach ($composicoes as $campo) {
    $chave = $chave + 1;

    $a = array(
      "substancias" =>
      array(
        array(
          "id" => (int) $ids[$chave],
          "concentracao" => (float) sprintf("%.2f", $concentracoes[$chave]),
          "volume" => 1000
          //"nome" => $composicoes[$chave]
        )
      )
    );

    array_push($substancias, array(

      "data" => array( //cada substancia
        $a
      )
    ));
  }
  return $substancias;
}
