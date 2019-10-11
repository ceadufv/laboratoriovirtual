<?php 
header("Content-type: application/json; charset=utf-8");
include(URL_SYSTEM.'banco/conexao.php');

	$id_pratica = !empty(@$_REQUEST['id_pratica'])?@$_REQUEST['id_pratica']:0;

	// Inserir
	$sql_pratica = "SELECT * FROM modelo_pratica WHERE id_modelo_pratica=?";
	$stmt = $dbh->prepare($sql_pratica);
	$stmt->execute(array( $id_pratica ));

	$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$data = $res[0];

	if (!count($data)) die("{\"status\":false}");

	$json = json_decode($data['data']);

	$resultado = $json;
	$resultado->pratica = $res;

	$data['nome_pratica'];

	$lista_solucao=array();
	$p = $resultado->id_solucoes_pratica;

	foreach ($p as $value){
	    $nome_solucao = $banco -> prepare("SELECT * FROM solucoes WHERE id_solucao=$value");
	    $nome_solucao -> execute();
	    $lista_solucao[] = $nome_solucao->fetchAll(PDO::FETCH_ASSOC)[0];
	}

	$resultado->lista_solucao = $lista_solucao;
	$resultado->status = true;

	echo json_encode($resultado);

/*


$resultado = array();
$id_pratica = @$_REQUEST['id_pratica'];
$id_solucao = 2;
$id_bequer = 4;
$id_balaovolumetrico = 5;
$id_pipetavolumetrica = 6;
$id_pipetador = 7;
$id_micropipeta = 8;

$id_categoria = $id_solucao;
global $banco;
$solucoes_selecionadas = $banco -> prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
$solucoes_selecionadas -> execute();
$solucao = $solucoes_selecionadas -> fetchAll(PDO::FETCH_ASSOC);

$lista_solucao=array();
$p = json_decode($solucao[0]['json_dados']);

foreach ($p as $value){
    $nome_solucao = $banco -> prepare("SELECT * FROM solucoes WHERE id_solucao=$value");
    $nome_solucao -> execute();
    $lista_solucao[] = $nome_solucao -> fetchAll(PDO::FETCH_ASSOC)[0];
}

$id_categoria = $id_bequer;
global $banco;
$solucoes_selecionadas = $banco -> prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
$solucoes_selecionadas -> execute();
$bequer = $solucoes_selecionadas -> fetchAll(PDO::FETCH_ASSOC);

$id_categoria = $id_balaovolumetrico;
global $banco;
$solucoes_selecionadas = $banco -> prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
$solucoes_selecionadas -> execute();
$balaovolumetrico = $solucoes_selecionadas -> fetchAll(PDO::FETCH_ASSOC);

$id_categoria = $id_pipetavolumetrica;
global $banco;
$solucoes_selecionadas = $banco -> prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
$solucoes_selecionadas -> execute();
$pipetavolumetrica = $solucoes_selecionadas -> fetchAll(PDO::FETCH_ASSOC);

$id_categoria = $id_pipetador;
global $banco;
$solucoes_selecionadas = $banco -> prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
$solucoes_selecionadas -> execute();
$pipetador = $solucoes_selecionadas -> fetchAll(PDO::FETCH_ASSOC);

$id_categoria = $id_micropipeta;
global $banco;
$solucoes_selecionadas = $banco -> prepare("SELECT * FROM objeto WHERE id_pratica=$id_pratica and id_categoria=$id_categoria");
$solucoes_selecionadas -> execute();
$micropipeta = $solucoes_selecionadas -> fetchAll(PDO::FETCH_ASSOC);

//Nome Prática
global $banco;
$g = $banco -> prepare("SELECT nome_pratica, resumo, id_disciplina, disponivel FROM modelo_pratica WHERE id_modelo_pratica=$id_pratica");
$g -> execute();
$pratica = $g -> fetchAll(PDO::FETCH_ASSOC);


$resultado['solucao'] = $solucao;
$resultado['bequer'] = $bequer;
$resultado['balaovolumetrico'] = $balaovolumetrico;
$resultado['pipetavolumetrica'] = $pipetavolumetrica;
$resultado['pipetador'] = $pipetador;
$resultado['micropipeta'] = $micropipeta;
$resultado['pratica'] = $pratica;


$resultado['lista_solucao'] = $lista_solucao;

$resultado['status'] = true;

echo json_encode($resultado);
// print_r($resultado);
*/
?>