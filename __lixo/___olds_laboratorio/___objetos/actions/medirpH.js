/**
* @name	Medir pH
* @description Apenas uma função de teste
* @valid_source ["eletrodo"]
* @valid_target ["cheio(bequer_cheio)"]
* 
* @error {"sujo(eletrodo)" : "É preciso lavar e secar o eletrodo antes de realizar a medição"}
* @error {"naoCalibrado(eletrodo)" : "É preciso calibrar o pHmetro antes de realizar a medição"}
*/

function medirpH(interacao) {

	var target = interacao.target();
	var phmetro = interacao.source();

	console.log(target.data('json').conceito)

	var pHmetro = new LabPhmetro({ desvioPadrao:0.02 });
	pHmetro.solucao(target);

	var handlerPhmetro = LabUtils.buscarPorConceito('phmetro')[0];
	handlerPhmetro.data('pHmodo').text = 'pH';

	// Acopla ao pHmetro
	//phmetro.acoplarAopHmetro(target);

	// Muda o béquer de lugar
	LabHandler.procurar('bequer_cheio')[0].moveTo('phmetro_bequer')
	

	// Realiza rotiza de medidcao de pH
	var tempo = 0;
	LabPhmetro._loop = function () {
		if (tempo >= 60) return;
		handlerPhmetro.data('pHvisor').text = pHmetro.novoMedirpH( tempo ).pHDisplay.toFixed(3)
		tempo ++;
	}

	//Muda o estado do eletrodo para sujo
	phmetro.data('limpo',false);

	//Muda o estado do béquer para indicar que ele foi medido (muda o conceito, mas permanece a mesma imagem)
	// Isso evita que ao medir um segundo bequer, ele leia informações do primeiro
	target.setConcept('bequer_cheio2')

}