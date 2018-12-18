/**
* @name	Medir pH
* @description Apenas uma função de teste
* @valid_source ["cheio(bequer)"]
* @valid_target ["eletrodo"]
* 
* @error {"sujo(eletrodo)" : "É preciso lavar o eletrodo antes de realizar a medição"}
*/
function medirpH(interacao) {

	var source = interacao.source();
	var phmetro = interacao.target();

	var pHmetro = new LabPhmetro({ desvioPadrao:0.02 });
	pHmetro.solucao(source);

	var handlerPhmetro = LabUtils.buscarPorConceito('phmetro')[0];
	handlerPhmetro.data('pHmodo').text = 'pH';

	// Acopla ao pHmetro
	phmetro.acoplarAopHmetro(source);

	// Realiza rotiza de medidcao de pH
	var tempo = 0;
	LabPhmetro._loop = function () {
		if (tempo >= 20) return;
		handlerPhmetro.data('pHvisor').text = pHmetro.medirpH( tempo ).pHDisplay.toFixed(2)
		tempo ++;
	}
}