/**
* @name	Calibrar pHmetro
* @description Essa interação indica ao usuário que pHmetro foi calibrado
* @valid_source ["eletrodo"]
* @valid_target ["eletrodo"]
*/
function calibrar(interacao) {
	
	var source = interacao.source();
	var target = interacao.target();

	var utc = new Date().toJSON().slice(0,10).split('-').reverse().join('/');

	var handlerPhmetro = LabUtils.buscarPorConceito('phmetro')[0];
	handlerPhmetro.data('calibracao').text = 'CAL: '+utc;

	// Inserir animação de calibração do pHmetro
	//$('#animacao').modal('show');

	//Muda o estado o pHmetro para calibrado
	source.data('calibrado',true);
	target.data('calibrado',true);

	
	//TESTE PARA ROTINAS DE pH/E
	/*var tempo = 0;
	//var frasco = jogo.armario().pegar(1);

	var pHmetro = new LabPhmetro({ desvioPadrao:0.02 });
	pHmetro.solucao(target);

	LabPhmetro._loop = function () {
		if (tempo >= 60) return;
		handlerPhmetro.data('pHvisor').text = pHmetro.novoMedirpH( tempo ).pHDisplay.toFixed(3)+' mV'
		//handlerPhmetro.data('pHvisor').text = pHmetro.novoMedirpH( tempo ).pHDisplay.toFixed(3)+' mV'
		tempo ++;
		//console.log(tempo)
	}
	*/
}