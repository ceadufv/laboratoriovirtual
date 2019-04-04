/**
* @name	Medir potencial
* @description Apenas uma função de teste
* @valid_source ["eletrodo"]
* @valid_target ["cheio(bequer)"]
*
* @error {"sujo(eletrodo)" : "É preciso lavar e secar o eletrodo antes de realizar a medição"}
*/
function medirpotencial(interacao) {

	var target = interacao.target();
	var phmetro = interacao.source();

	var pHmetro = new LabPhmetro({ desvioPadrao:0.02 });
	pHmetro.solucao(target);


	var handlerPhmetro = LabUtils.buscarPorConceito('phmetro')[0];
	handlerPhmetro.data('pHmodo').text = 'E/mV';

	// Acopla ao pHmetro
	phmetro.acoplarAopHmetro(target);

	var tempo = 0;
	LabPhmetro._loop = function () {
		if (tempo >= 20) return;
		handlerPhmetro.data('pHvisor').text = pHmetro.medirpH( tempo ).potencialDisplay.toFixed(2)+' mV'
		tempo ++;
	}
}