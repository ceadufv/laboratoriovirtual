<?php
header("Content-type: application/json; charset=utf-8");

$data = @$_REQUEST['data'];

if (empty($data)) exit;

function getEpslon($id) {
	$epslon_raw = file("../rotinas/$id.txt");
	$epslon = array();
	foreach ($epslon_raw as $item) {
		$eps = explode("\t", $item);
//		$epslon[] = array((int) $eps[0], (float) str_replace(",",".",$eps[1]));

		$epslon[] = array(
			"l" => (int) $eps[0],
			"I" => (float) str_replace(",",".",$eps[1])
		);

	}
	return $epslon;
}

function getIntensidadeFonte($id) {
	$result_raw = file("../rotinas/$id.txt");
	$result = array();
	foreach ($result_raw as $item) {
		$eps = explode("\t", $item);
		$result[] = array(
			"l" => (int) $eps[0],
			"I" => (float) str_replace(",",".",$eps[1])
		);
	}

	return $result;
}

$action = @$_REQUEST['action'];

switch ($action) {

	case "solucao":
		$data_json = json_decode($data);

		$nomes = array(
			"azulacido" => "Azul Ácido",
			"azulbasico" => "Azul Básico",
			"violetademetila" => "Violeta de Metila"
		);

		$concentracaoEstoque = array(
			"azulacido" => 0.0000001,
			"azulbasico" => 0.0000005,
			"violetademetila" => 0.0000005
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
	break;

	case "espectrofotometro":
		$result = array(
			"intensidadefonteVisivel" => getIntensidadeFonte("intensidadefonteVisivel"),
			"intensidadefonteUV" => getIntensidadeFonte("intensidadefonteUV"),
			"intensidadefonteUVeVisivel" => getIntensidadeFonte("intensidadefonteUVeVisivel")
		);

		echo json_encode($result);
	break;

}