<?php
header("Content-type: application/json; charset=utf-8");

$id_pratica = $_REQUEST['id_pratica'];
if(empty($id_pratica)){
    echo json_encode(array('success'=>true));
}

$objCenario = new Cenario();
$objSubstancias = new Substancias();
$objModeloPratica = new ModeloPratica();
$objModeloPraticaSolucao = new ModeloPraticaSolucao();
$objLaboratorioVirtual = new LaboratorioVirtual();
$objModeloPraticaArquivo = new ModeloPraticaArquivo();


$resultado = $objModeloPratica->getJsonLabPratica($id_pratica);
$resultado['cenario'] = $objCenario->getCenario($resultado['id_cenario'])['data'];
$resultado['substancias'] = $objSubstancias->getAllSubstancias();
$resultado['armario']['solucoes'] = $objModeloPraticaSolucao->getSolucoesPratica($id_pratica);

//arquivos
$resultado['arquivos'] = array();
$resultado['arquivos']['caderno'] = $objModeloPraticaArquivo->getArquivosPratica($id_pratica, 'CADERNO');
$resultado['arquivos']['roteiro'] = $objModeloPraticaArquivo->getArquivosPratica($id_pratica, 'ROTEIRO');

$resultado = $objLaboratorioVirtual->formatTolab($resultado);
echo json_encode($resultado);
?>