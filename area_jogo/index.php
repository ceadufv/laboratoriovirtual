<!DOCTYPE html>
<html lang="en">
<head>
<title>three.js webgl - OBJLoader + MTLLoader</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<style>
	body {
		font-family: Monospace;
		background-color: #000;
		color: #fff;
		margin: 0px;
		overflow: hidden;
	}
	#info {
		color: #fff;
		position: absolute;
		top: 10px;
		width: 100%;
		text-align: center;
		z-index: 100;
		display:block;
	}
	#info a, .button { color: #f00; font-weight: bold; text-decoration: underline; cursor: pointer }
</style>

<!-- Framework Quimica -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="../classes_quimica/controladores.js"></script>
<script src="../classes_quimica/controle-vidraria.js"></script>
<script src="../classes_quimica/controle-instrumentos.js"></script>
<script src="../classes_quimica/quimica-estatica.js"></script>

<!-- Threejs -->
<script src="js/editor/three.js"></script>
<script src="js/threejs/libs/system.min.js"></script>

<script src="js/threejs/controls/EditorControls.js"></script>
<script src="js/threejs/controls/TransformControls.js"></script>

<script src="js/threejs/libs/jszip.min.js"></script>
<script src="js/threejs/libs/inflate.min.js"></script> <!-- FBX -->

<script src="js/threejs/loaders/AMFLoader.js"></script>
<script src="js/threejs/loaders/AWDLoader.js"></script>
<script src="js/threejs/loaders/BabylonLoader.js"></script>
<script src="js/threejs/loaders/ColladaLoader.js"></script>
<script src="js/threejs/loaders/FBXLoader.js"></script>
<script src="js/threejs/loaders/GLTFLoader.js"></script>
<script src="js/threejs/loaders/deprecated/LegacyGLTFLoader.js"></script>
<script src="js/threejs/loaders/KMZLoader.js"></script>
<script src="js/threejs/loaders/MD2Loader.js"></script>
<script src="js/threejs/loaders/OBJLoader.js"></script>
<script src="js/threejs/loaders/MTLLoader.js"></script>
<script src="js/threejs/loaders/PlayCanvasLoader.js"></script>
<script src="js/threejs/loaders/PLYLoader.js"></script>
<script src="js/threejs/loaders/STLLoader.js"></script>
<script src="js/threejs/loaders/SVGLoader.js"></script>
<script src="js/threejs/loaders/TGALoader.js"></script>
<script src="js/threejs/loaders/TDSLoader.js"></script>
<script src="js/threejs/loaders/UTF8Loader.js"></script>
<script src="js/threejs/loaders/VRMLLoader.js"></script>
<script src="js/threejs/loaders/VTKLoader.js"></script>
<script src="js/threejs/loaders/ctm/lzma.js"></script>
<script src="js/threejs/loaders/ctm/ctm.js"></script>
<script src="js/threejs/loaders/ctm/CTMLoader.js"></script>
<script src="js/threejs/exporters/OBJExporter.js"></script>
<script src="js/threejs/exporters/GLTFExporter.js"></script>
<script src="js/threejs/exporters/STLExporter.js"></script>

<script src="js/threejs/renderers/Projector.js"></script>
<script src="js/threejs/renderers/CanvasRenderer.js"></script>
<script src="js/threejs/renderers/RaytracingRenderer.js"></script>
<script src="js/threejs/renderers/SoftwareRenderer.js"></script>
<script src="js/threejs/renderers/SVGRenderer.js"></script>

<!-- -->
<script src="js/threejs/libs/stats.min.js"></script>
<script src="js/threejs/loaders/DDSLoader.js"></script>
<script src="js/threejs/controls/DragControls.js"></script>
<script src="js/threejs/controls/TrackballControls.js"></script>
<!-- -->

<script src="js/editor/libs/html2canvas.js"></script>
<script src="js/editor/libs/three.html.js"></script>
<script src="js/jquery-3.2.1.js"></script>

</head>

<body>
<script src="js/laboratorio3d.js"></script>
<script>
var data = {
	// Cenas disponiveis no ambiente
	cena: [
		{ id: 'bancada-esquerda', position: {x:-30, y:-50, z:0}, angle:-90, zoom:1, current:true },
		{ id: 'bancada-direita', position: {x:120, y:-50, z:0}, angle:-90, zoom:1  }
	],
	// Objetos disponiveis no ambiente
	objetos: [
		{
			concept:'bancada', position: {x:-5.2,y:0,z:0},
			data: {
				gavetas: [
					'bequer',
					'pipeta-volumetrica',
					'micropipeta',
					'pipetador',
					'ponteira',
					'solucoes'
				]
			}
		},
		{concept:'prateleira', position: {x:-3.1,y:3.7,z:0.2}},
		{concept:'armario', position: {x:12,y:0,z:31}},
		{concept:'chao', position: {x:0,y:0,z:0}},
		{concept:'capela', position: {x:-36,y:0,z:1.5}},
		{concept:'capela_parede', position: {x:-38,y:0,z:1}},
		{concept:'lixo', position: {x:14.5,y:0,z:0}},
		{concept:'cadeira', position: {x:-25.7,y:0,z:-1}},
		{concept:'cadeira', position: {x:-21.3,y:0,z:-6}},
		{concept:'cadeira', position: {x:-21.3,y:0,z:6.7}},

		// Prateleira de baixo
		{concept:'vazio', position: {x:10,y:3.9,z:-2.5},data:{relationships:[{concept:'partOf', data:'bancada'}]}},
		{concept:'vazio', position: {x:7,y:3.9,z:-2.5},data:{relationships:[{concept:'partOf', data:'bancada'}]}},
		{concept:'vazio', position: {x:4,y:3.9,z:-2.5},data:{relationships:[{concept:'partOf', data:'bancada'}]}},
		{concept:'vazio', position: {x:1,y:3.9,z:-2.5},data:{relationships:[{concept:'partOf', data:'bancada'}]}},

		// Prateleira de cima
		{concept:'vazio', position: {x:10,y:5.3,z:0},data:{relationships:[{concept:'partOf', data:'prateleira'}]}},
		{concept:'vazio', position: {x:7,y:5.3,z:0},data:{relationships:[{concept:'partOf', data:'prateleira'}]}},
		{concept:'vazio', position: {x:4,y:5.3,z:0},data:{relationships:[{concept:'partOf', data:'prateleira'}]}},
		{concept:'vazio', position: {x:1,y:5.3,z:0},data:{relationships:[{concept:'partOf', data:'prateleira'}]}},

		// Lugar onde ficam os instrumentos
		{concept:'instrumento', position: {x:-2,y:3.9,z:-2},data:{relationships:[{concept:'partOf', data:'prateleira'}]}},

		// Phmetro
		{concept:'phmetro', position: {x:0,y:0,z:0}},
		{concept:'vazio', position: {x:-2.85,y:3.9,z:-3},data:{relationships:[{concept:'partOf', data:'phmetro'}]}},
		//
		{concept:'bequer', position: {x:0,y:0,z:0}},
		{concept:'frasco', position: {x:0,y:0,z:0}},
	],
	debug: false
};

var laboratorio = new Laboratorio3D(data);

laboratorio.moveObject('phmetro','instrumento');
laboratorio.moveObject('bequer','phmetro');
//			laboratorio.moveObject('frasco','prateleira');
laboratorio.moveObject('lixo','bancada');
//			laboratorio.moveObject('frasco','prateleira');
//			laboratorio.moveObject('frasco','prateleira');

laboratorio.click(function (objeto) {
  console.log(objeto);  
});
</script>
<script>
var controlador = new Controlador();
var dados_pratica = {
	"descricao": "Esta é uma prática clone teste, feita para verificar se todas as funcionalidades estão funcionando. Por isso, não existe um objetivo geral, apenas um caos generalizado para que, talvez, seja possível avaliar o funcionamento de todas as vidrarias e suas interações. Divirta-se, claro, se estiver lendo isso. Caso contrário, perdi meu tempo.",
	"numeroDeAmbientes": 2,
	"instrumentos": [
		{ "id": "phmetro", "disponivel":true, "configuracao": { "calibrado": true, "casasDecimais": 2, "desvioPadrao": 0.01, "tmax": 20 } }
	],
	"frasco_estoque": [
		{ "id":1, "substancias": ["Amônia"], "concentracoes": [0.01], "volumeTotal": 1000 },
		{ "id":2, "substancias": ["Ácido Forte"], "concentracoes": [0.1], "volumeTotal": 1000 },
		{ "id":3, "substancias": ["Acetato"], "concentracoes": [0.01], "volumeTotal": 1000 },
		{ "id":4, "substancias": ["Base Forte"], "concentracoes": [0.1], "volumeTotal": 1000 },
		{"id":13, "substancias": ["Ácido Acético", "Base Forte"], "concentracoes": [0.05, 0.0075026], "volumeTotal": 1000 },
		{"id":14, "substancias": ["Acetato", "Ácido Forte"], "concentracoes": [0.05, 0.04297], "volumeTotal": 1000 },
		{"id":15, "substancias": ["Ácido Acético", "Acetato"], "concentracoes": [0.042597, 7.4026], "volumeTotal": 1000 },
		{"id":16, "substancias": ["Ácido Acético", "Base Forte"], "concentracoes": [0.05, 0.02617], "volumeTotal": 1000 },
		{"id":17, "substancias": ["Ácido Acético", "Base Forte"], "concentracoes": [0.05, 0.04205], "volumeTotal": 1000 },
		{"id":18, "substancias": ["Ácido Acético", "Base Forte"], "concentracoes": [0.05, 0.04971], "volumeTotal": 1000 }
	],
	"vidrarias": [
		{ "id":5, "nome":"bequer", "capacidadeMinima": 0, "capacidadeMaxima": 25, "preenchimentoMinimo": 0, "preenchimentoMaximo": 95, "desvioPadrao": 0.05 },
		{ "id":5, "nome":"bequer", "capacidadeMinima": 0, "capacidadeMaxima": 25, "preenchimentoMinimo": 0, "preenchimentoMaximo": 95, "desvioPadrao": 0.05 },
		{ "id":6, "nome":"bequer", "capacidadeMinima": 0, "capacidadeMaxima": 50, "preenchimentoMinimo": 0, "preenchimentoMaximo": 95, "desvioPadrao": 0.05 },
		{ "id":7, "nome":"pipeta", "capacidadeMinima": 0, "capacidadeMaxima": 5, "preenchimentoMinimo": 90, "preenchimentoMaximo": 105, "desvioPadrao": 0.01 },
		{ "id":8, "nome":"pipeta", "capacidadeMinima": 0, "capacidadeMaxima": 2, "preenchimentoMinimo": 90, "preenchimentoMaximo": 105, "desvioPadrao": 0.01 },
		{ "id":9, "nome":"pipeta", "capacidadeMinima": 0, "capacidadeMaxima": 3, "preenchimentoMinimo": 90, "preenchimentoMaximo": 105, "desvioPadrao": 0.01 },
		{ "id":10, "nome":"pipetador", "capacidadeMinima": 0, "capacidadeMaxima":0,"preenchimentoMinimo": 0 , "preenchimentoMaximo": 0, "desvioPadrao":0},
		{ "id":10, "nome":"pipetador", "capacidadeMinima": 0, "capacidadeMaxima":0, "preenchimentoMinimo": 0, "preenchimentoMaximo": 0, "desvioPadrao": 0},
		{ "id":11, "nome":"micropipeta", "capacidadeMinima": 0.001, "capacidadeMaxima": 0.1, "preenchimentoMinimo": 0, "preenchimentoMaximo": 100, "desvioPadrao": 0.001 },
		{ "id":12, "nome":"ponteira", "capacidadeMinima": 0, "capacidadeMaxima": 0, "preenchimentoMinimo": 0, "preenchimentoMaximo": 0, "desvioPadrao": 0 }

	]
}

function init() {
	controlador.criarVidraria(1, 'NaBancadapHmetro', 'bequer', 0, 50, 0, 100, 2, 0.1);
	controlador.criarVidraria(1, 'NaBancadapHmetro', 'bequer', 0, 50, 0, 100, 2, 0.1);
	controlador.criarVidraria(2, 'NaBancadapHmetro', 'pipeta', 0, 5, 90, 105, 2, 0.01);
	controlador.criarVidraria(3, 'NaBancadapHmetro', 'pipetador', 0, 0, 0, 0, 0, 0);
	controlador.criarVidraria(4, 'NaBancadapHmetro', 'micropipeta', 0.01, 0.1, 90, 105, 2, 0.001);
	controlador.criarVidraria(5, 'NaBancadapHmetro', 'ponteira', 0, 0, 0, 0, 2, 0.001);
	controlador.criarFrascoEstoque(6, 'NaBancadapHmetro', ['Ácido Forte'], [0.05], 1000);
	controlador.criarInstrumento('pHmetro', false, 0.01, 2, 100);
}

function teste1() {
	let bequer = controlador.filtrar('bequer', 'NaBancadapHmetro', 50, 'primeiro', 'Limpo');
	let frasco = controlador.filtrar('frasco-estoque', 'NaBancadapHmetro', '', 'primeiro');
	controlador.ambientar(frasco, bequer, 5);
	controlador.ambientar(frasco, bequer, 5);
	controlador.transferir(frasco, bequer, 40);
	let pipeta = controlador.filtrar('pipeta-volumetrica', 'NaBancadapHmetro', '', 'primeiro', 'SemPipetador');
	let pipetador = controlador.filtrar('pipetador', 'NaBancadapHmetro', '', 'primeiro', 'Livre');
	controlador.acoplarPipetador(pipeta, pipetador);
	controlador.ambientar(bequer, pipeta, 2);
	controlador.ambientar(bequer, pipeta, 2);
	controlador.sugar(pipeta, bequer, 5);
	let bequer2 = controlador.filtrar('bequer', 'NaBancadapHmetro', 50, 'primeiro', 'Limpo');
	controlador.ambientar(frasco, bequer2, 5);
	controlador.ambientar(frasco, bequer2, 5);
	controlador.expelir(pipeta, bequer2);
}

function load_pratica(json) {
	// Inicializa das vidrarias contentes no json
	for(let i = 0; i < json.vidrarias.length; i++) {
		controlador.criar({
			'conceito': 'vidraria',
			'id': json.vidrarias[i].id,
			'destino': 'NoArmario',
			'nome': json.vidrarias[i].nome,
			'capMin': json.vidrarias[i].capacidadeMinima,
			'capMax': json.vidrarias[i].capacidadeMaxima,
			'min': json.vidrarias[i].preenchimentoMinimo,
			'max': json.vidrarias[i].preenchimentoMaximo,
			'ambN': json.numeroDeAmbientes,
			'dp': json.vidrarias[i].desvioPadrao
		});
	}
	// Inicializa os frascos
	for(let i = 0; i < json.frasco_estoque.length; i++) {
		controlador.criar({
			'conceito': 'frasco_estoque',
			'id': json.frasco_estoque[i].id,
			'destino': 'NoArmario',
			'substancias': json.frasco_estoque[i].substancias,
			'concentracoes': json.frasco_estoque[i].concentracoes,
			'volumeTotal': json.frasco_estoque[i].volumeTotal
		});
	}
	// Inicializa os instrumentos
	for(let i = 0; i < json.instrumentos.length; i++) {
		controlador.criar({
			'conceito': 'instrumento',
			'id': json.instrumentos[i].id,
			'configuracao': json.instrumentos[i].configuracao
		});
	}
}

function load_interacoes() {
	let dados;
	$.ajax({
		url: '../banco/proposta.json',
		async: false,
		dataType: 'json',
		success: function(res) {
			dados = res;
		}
	});
	controlador.regras = dados;
}

function teste3() {
	let objetoSelecionado = 'bequer';
	let estadoSelecionado = 'ComAmostra';
	let idObjeto = -1;
	let idEstado = -1;
	let interacoes = { 'objetosAlvo': [], 'acoesPossiveis': [], 'acoesExecutaveis': [], 'objetosAtores': [] };
	// Preenche o objeto com as informações das regras
	for(let i = 0; i < controlador.regras.objetos.length; i++) { if(controlador.regras.objetos[i].tipo == objetoSelecionado) { idObjeto = i; break; } }
	for(let i = 0; i < controlador.regras.acoes_por_estado.length; i++) { if(controlador.regras.acoes_por_estado[i].tipo == estadoSelecionado) { idEstado = i; break; } }
	interacoes.objetosAlvo = controlador.regras.objetos[idObjeto].age_sobre.slice();
	interacoes.acoesPossiveis = controlador.regras.objetos[idObjeto].acoes_de_interacao;
	// Encontra as ações disponíveis de acordo com o estado e o tipo de objeto
	for(let i = 0; i < interacoes.objetosAlvo.length; i++) {
		interacoes.acoesExecutaveis[i] = [];
		for(let j = 0; j < interacoes.acoesPossiveis[i].length; j++) {
			for(let k = 0; k < controlador.regras.acoes_por_estado[idEstado].length; k++) {
				if(controlador.regras.acoes_por_estado[idEstado][k] == interacoes.acoesPossiveis[i][j]) {
					interacoes.acoesExecutaveis[i].push(controlador.regras.acoes_por_estado[idEstado][k][k]);
					break;
				}
			}
		}
	}
	// Cria alguns objetos de teste
	let objetos = { 'tipo': ['bequer', 'pipeta_volumetrica', 'balao_volumetrico', 'bequer'], 'estado': ['Limpo', 'ComAmostra', 'Ambientado', 'EmAmbiente'], 'acoes': [], 'acoesAlvo': [] }
	// Inicia a busca dos objetos que podem interagir
	for(let i = 0; i < objetos.tipo.length; i++) {
		objetos.acoes[i] = [];
		for(let j = 0; j < interacoes.objetosAlvo.length; j++) {
			if(objetos.tipo[i] == interacoes.objetosAlvo[j]) {
				for(let k = 0; k < interacoes.acoesPossiveis[j].length; k++) {
					for(let l = 0; l < controlador.regras.objetos[idObjeto].estado_receptor[j][k].length; l++) {
						if(objetos.estado[i] == controlador.regras.objetos[idObjeto].estado_receptor[j][k][l]) {
							objetos.acoes[i].push(interacoes.acoesPossiveis[j][k]);
							break;
						}
					}
				}
			}
		}
	}

	// Inicia a triagem de objetos que podem executar ação sobre o objeto selecionado
	let lambari = { 'alvos': [], 'acoes': [] }
	for(let i = 0; i < objetos.tipo.length; i++) {
		for(let j = 0; j < controlador.regras.objetos.length; j++) {
			if(controlador.regras.objetos[j].tipo == objetos.tipo[i]) {
				// Encontrou as regras do objeto selecionado
				for(let k = 0; k < controlador.regras.objetos[j].age_sobre.length; k++) {
					// Encontra se o objeto interage com o objeto selecionado
					if(controlador.regras.objetos[j].age_sobre[k] == objetoSelecionado) {
						lambari.alvos.push(objetos.tipo[i]);
						let possibilidades = [];
						// Percorre as ações disponíveis
						for(let l = 0; l < controlador.regras.objetos[j].acoes_de_interacao[k].length; l++) {
							// Valida de o objeto selecionado possui o estado necessário para realizar a ação
							for(let m = 0; m < controlador.regras.objetos[j].estado_receptor[k][l].length; m++) {
								if(controlador.regras.objetos[j].estado_receptor[k][l][m] == estadoSelecionado) {
									// Faz a validação final, se o objeto em questão possui um estado que permita a ação a ser executada
									for(let n = 0; n < controlador.regras.acoes_por_estado.length; n++) {
										if(controlador.regras.acoes_por_estado[n].tipo == objetos.estado[i]) {
											// Verifica se a ação disponível pode ser realizada
											for(let o = 0; o < controlador.regras.acoes_por_estado[n].valores.length; o++) {
												if(controlador.regras.acoes_por_estado[n].valores[o] == controlador.regras.objetos[j].acoes_de_interacao[k][l]) {
													possibilidades.push(controlador.regras.objetos[j].acoes_de_interacao[k][l]);
													break;
												}
											}
										}
									}
									break;
								}
							}
						}
						lambari.acoes.push(possibilidades);
					}
				}
				// Sai da busca de regras
				break;
			}
		}
	}
	console.log(interacoes);
	console.log(objetos);
	console.log(lambari);
}

function teste2() {
	// Primeira parte do teste, ambientar um béquer com um frasco e medir o pH
	let bequer = controlador.filtrar('bequer', 'NoArmario', 25, 'primeiro', 'Limpo');
	let frasco = controlador.filtrar('frasco-estoque', 'NoArmario', '', 'primeiro');
	controlador.moverPara(bequer, 'NaBancadapHmetro');
	controlador.moverPara(frasco, 'NaBancadapHmetro');
	controlador.ambientar(frasco, bequer, 5);
	controlador.ambientar(frasco, bequer, 5);
	controlador.transferir(frasco, bequer, 20);
	let phmetro = controlador.instrumento('phmetro');
	phmetro.acoplarVidraria(bequer);
	console.log('Acoplado: ', bequer);
	console.log('Valor real da primeira vidraria: ', phmetro.get('medida'));
	// Pedaço de código responsável pela oscilação do valor exibido na tela
	// O método desacoplarVidraria() já encontra linkada com a oscilação, basta utilizá-la
	/*
	phmetro.oscilacao('dec_exp');
	setInterval(function() {
		console.log(phmetro.get('ruido'));
	}, 1000);
	*/
	
	// Segunda parte do teste, utilização da pipeta volumétrica
	let pipeta = controlador.filtrar('pipeta-volumetrica', 'NoArmario', '', 'primeiro', 'SemPipetador');
	let pipetador = controlador.filtrar('pipetador', 'NoArmario', '', 'primeiro', 'Livre');
	controlador.moverPara(pipeta, 'NaBancadapHmetro');
	controlador.moverPara(pipetador, 'NaBancadapHmetro');
	controlador.acoplarPipetador(pipeta, pipetador);
	controlador.ambientar(bequer, pipeta, 3);
	controlador.ambientar(bequer, pipeta, 3);
	controlador.sugar(pipeta, bequer, 5);
	console.log('Volume (mL) sugado pela pipeta volumétrica', pipeta.get('volume'));
	
	// Terceira parte do teste, interação da pipeta com outro béquer e nova medida de pH
	let bequer2 = controlador.filtrar('bequer', 'NoArmario', 25, 'primeiro', 'Limpo');
	controlador.moverPara(bequer2, 'NaBancadapHmetro');
	controlador.ambientar(frasco, bequer2, 5);
	controlador.ambientar(frasco, bequer2, 5);
	controlador.expelir(pipeta, bequer2);
	console.log('Volume (mL) despejado no béquer pela pipeta volumétrica: ', bequer2.get('volume'));
	phmetro.desacoplarVidraria();
	phmetro.acoplarVidraria(bequer2);
	console.log('Valor real de pH da nova vidraria: ', phmetro.get('medida'));
	
	// Quarta parte do teste, utilização da micropipeta e interação com o béquer
	let micropipeta = controlador.filtrar('micropipeta', 'NoArmario', '', 'primeiro', 'SemPonteira');
	let ponteira = controlador.filtrar('ponteira', 'NoArmario', '', 'primeiro', 'Limpo');
	controlador.acoplarPonteira(micropipeta, ponteira);
	controlador.ambientar(bequer, micropipeta, 0.01);
	controlador.ambientar(bequer, micropipeta, 0.01);
	controlador.sugar(micropipeta, bequer, 0.05);
	controlador.descartar(bequer2);
	console.log('Volume (mL) sugado pela micropipeta: ', micropipeta.get('ponteira').get('volume'));
	controlador.expelir(micropipeta, bequer2);
	console.log('Volume (mL) expelido pela micropipeta: ', bequer2.get('volume'));
	phmetro.desacoplarVidraria();
	phmetro.acoplarVidraria(bequer2);
	console.log('Valor real de pH da nova vidraria: ', phmetro.get('medida'));
}

//init(); teste1();

// Testes com a nova estrutura de controle
//load_pratica(dados_pratica); teste2();
load_interacoes(); teste3();
</script>
	</body>
</html>
