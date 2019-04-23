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
		if (tempo >= 20) return;
		handlerPhmetro.data('pHvisor').text = pHmetro.medirpH( tempo ).pHDisplay.toFixed(2)
		tempo ++;
	}

	//Muda o estado do eletrodo para sujo
	phmetro.data('limpo',false);

}