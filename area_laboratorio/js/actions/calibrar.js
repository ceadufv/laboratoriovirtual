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

	//Mostra no equipamento a a confirmação da calibração
	var handlerPhmetro = LabUtils.buscarPorConceito('phmetro')[0];
	handlerPhmetro.data('calibracao').text = 'CAL: '+utc;

	// Inserir animação de calibração do pHmetro
	$('#animacao').modal('show');
	limparTela();

	// Criacao do conteudo
	$('#animacao .modal-body .conteudo').html('');
	$('#animacao .modal-body .conteudo')
		.append('<div class="page page-1"><h1>Lendo primeiro padrão</h1><img src="assets/actions/lerpadrao4.gif" /></a>')
		.append('<div class="page page-2"><h1>Lavando</h1><img src="assets/actions/lavareletrodo.gif" /></a>')
		.append('<div class="page page-3"><h1>Secando</h1><img src="assets/actions/secareletrodo.gif" /></a>')
		.append('<div class="page page-4"><h1>Lendo segundo padrão</h1><img src="assets/actions/lerpadrao7.gif" /></a>')
		.append('<div class="page page-5"><h1>Lavando</h1><img src="assets/actions/lavareletrodo.gif" /></a>')
		.append('<div class="page page-6"><h1>Secando</h1><img src="assets/actions/secareletrodo.gif" /></a>');

	exibirPagina(1);

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