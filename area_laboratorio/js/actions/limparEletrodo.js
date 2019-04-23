/**
* @name	Lavar e secar eletrodo
* @description Teste
* @valid_source ["pisseta"]
* @valid_target ["eletrodo"]
*/
function limparEletrodo(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	// Inserir animação de lavagem e secagem do eletrodo
	// com botão para indicar o "play" na secagem
	$('#animacao').modal('show');

	target.data('limpo',true);

	
	// Muda o béquer de repouso de lugar
	LabHandler.procurar('bequer_repouso')[0].moveTo('bancada2')
	
	//$('#interacao .modal-title').text('Lavando...');
	//console.log('Volume Maximo', target.data('volumeMaximo'))

	//target.data('limpo',true);
	
	
}