<?php
header("Content-type: application/json; charset=utf-8");

$data = @$_REQUEST['data'];
$data_json = json_decode($data);

if (empty($data)) exit;

function getEpslon($id) {
	$epslon_raw = file("../rotinas/$id.txt");
	$epslon = array();
	foreach ($epslon_raw as $item) {
		$eps = explode("\t", $item);
		$epslon[] = array((int) $eps[0], (float) str_replace(",",".",$eps[1]));
	}
	return $epslon;
}

$nomes = array(
	"azulacido" => "Azul Ácido",
	"azulbasico" => "Azul Básico"
);

$concentracaoEstoque = array(
	"azulacido" => 0.0001,
	"azulbasico" => 0.0005
);

$result = array();

foreach ($data_json as $d) {
	$result[] = array(
		"id" => $d->id,
		"nome" => $nomes[$d->id],
		"epslon" => getEpslon($d->id),
		"concentracaoEstoque" => $concentracaoEstoque[$d->id],
		"volume" => $d->volume
	);
}

echo json_encode($result);