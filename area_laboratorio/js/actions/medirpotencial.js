/**
* @name	Medir potencial
* @description Apenas uma função de teste
* @valid_source ["cheio(bequer)"]
* @valid_target ["eletrodo"]
*
* @error {"sujo(eletrodo)" : "É preciso lavar o eletrodo antes de realizar a medição"}
*/
function medirpotencial(interacao) {

	var source = interacao.source();
	var phmetro = interacao.target();

	var pHmetro = new LabPhmetro({ desvioPadrao:0.02 });
	pHmetro.solucao(source);


	var handlerPhmetro = LabUtils.buscarPorConceito('phmetro')[0];
	handlerPhmetro.data('pHmodo').text = 'E/mV';

	// Acopla ao pHmetro
	phmetro.acoplarAopHmetro(source);

	var tempo = 0;
	LabPhmetro._loop = function () {
		if (tempo >= 20) return;
		handlerPhmetro.data('pHvisor').text = pHmetro.medirpH( tempo ).potencialDisplay.toFixed(2)+' mV'
		tempo ++;
	}
}