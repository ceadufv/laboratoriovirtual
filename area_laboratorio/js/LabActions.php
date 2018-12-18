<?php
header('Content-Type: application/javascript; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
function newAction(data) {
    LabAction.add(data);
}

function rotinaExemplo() {
	console.log('Rotina Exemplo:',arguments);
}
<?php
// Inclui os arquivos JS
$path = "actions/";

$docs = array();

function docs($entry) {
	$file = file($entry);
	$info = pathinfo($entry);

	$res = array(
		"error" => array()
	);

	$counter = 1;

	foreach ($file as $line) {
		$exp = array();

		if (strpos($line,"@name")) {
			$exp = explode("@name", $line);
			$res['text'] = trim($exp[1]);
		}

		if (strpos($line,"@description")) {
			$exp = explode("@description", $line);
			$res['description'] = trim($exp[1]);	
		}

		if (strpos($line,"@valid_source")) {
			$exp = explode("@valid_source", $line);
			$res['source'] = trim($exp[1]);
		}

		if (strpos($line,"@valid_target")) {
			$exp = explode("@valid_target", $line);
			$res['target'] = trim($exp[1]);
		}

		if (strpos($line, "@error")) {
			$exp = explode("@error", $line);
			$json = array(
				"id" => "error_".$info['filename']."_$counter",
				"data" => json_decode(trim($exp[1]))
			);
			//$json['id'] = $counter;
			$res['error'][] = json_encode($json);
			$counter++;
		}

	}

	$json = '{
		"text": "'.$res['text'].'",
		"description": "'.$res['description'].'",
		"agents":{
			"source": '.$res['source'].',
			"target": '.$res['target'].'
		},
		"errors": [
		'.implode(",",$res['error']).'
		]
	}';

	return json_decode($json);
}

if ($handle = opendir($path)) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {
        	$f = "$path$entry";

			$info = pathinfo($f);
        	$ext = $info['extension'];

        	$docs[$info['filename']] = docs($f);

    		include($f);

    		echo "\n\n";
        }
    }

    closedir($handle);
}

function and_to_js($oo, $agent) {
	$out = array();
	$exp = explode("&&", $oo);
	foreach ($exp as $o) {
		$out[] = atom_to_js($o, $agent);
	}
	return '('.implode (' && ', $out).')';
}

function json_to_js($json, $agent) {
	$out = array();

	foreach ($json as $o) {
		if (strpos($o, "&&")) {
			$out[] = and_to_js($o, $agent);
			continue;
		}

		if (strpos($o, "(") === FALSE) {
			$out[] = "($agent.concept('$o'))";
			continue;
		}

		$out[] = atom_to_js($o, $agent);
	}
	return $out;
}

function atom_to_js($o, $agent = "a") {
	$e = explode("(", $o);
	$estado = $e[0];	
	$conceito = preg_replace("/[^a-zA-Z_]/", "", $e[1]);

	if ($estado == 'source' || $estado == 'target') {
		return "(interaction.$estado().concept() == '$conceito')";
	}

	if ($agent == 'interaction') {
		return "($agent.exists('".$conceito."', '".$estado."'))";
	}

	return "($agent.state('".$estado."') && $agent.concept('".$conceito."'))\n";
}

/*
TODO: Fazer com que essa funcao fique generica a ponto de ser
possivel passar valores como: "origem:cheio(bequer)&&nao_ambientado(bequer)"

Fazer tambem com que esses dados sejam embutidos em comentarios no javascript
*/
function errors_to_js($a) {
	$results = array();

	foreach ($a as $error) {
		foreach ($error->data as $rule => $message) {
			$js = atom_to_js($rule, "interaction");
			$results[] = "if $js return '$message';\n";
		//	echo "$rule => $message\n";
		}
	}

	return $results;
}

function interaction($id, $data) {
//	$data = json_decode($json);

	$source = json_to_js($data->agents->source, "a");
	$target = json_to_js($data->agents->target, "a");
	$errors = errors_to_js($data->errors);

	return 'newAction({'.
		'"id":"'.$id.'",'.
		'"text": "'.$data->text.'",'.
		'"source": function (a) { '.
		'return '.implode(" || ",$source).';'.
		'}'.','.
		'"target":function (a) {'.
		'return '.implode(" || ",$target).';'.		
		'},'.
		'"action": '.$id.','."\n".
		'"errors": function (interaction) { '.
			implode(" ", $errors).
		' }'.
	'})';
}

foreach ($docs as $id => $item) {
	echo "\n";
	echo interaction($id, $item);
	echo "\n";
}