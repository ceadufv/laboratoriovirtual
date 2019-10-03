/**
* @name	Lavar e secar eletrodo
* @description Teste
* @valid_source ["pisseta"]
* @valid_target ["eletrodo"]
*/
function limparEletrodo(interacao) {
	var source = interacao.source();
	var target = interacao.target();

	// Inserir animação de trasnferência do líquido para cubeta e secagem com papel (semelhante à lavagem do eletrodo)
	$('#animacao').modal('show');

	limparTela();
	$('#animacao .modal-body .conteudo')
		.append('<div class="page page-1"><img src="assets/actions/lavareletrodo.gif" /></a>')
		.append('<div class="page page-2"><img src="assets/actions/secareletrodo.gif" /></a>');
		
	exibirPagina(1);
	target.data('limpo', true);

	// Muda o béquer de repouso de lugar
	LabHandler.procurar('bequer_repouso')[0].moveTo('bancada2')
	
	//$('#interacao .modal-title').text('Lavando...');
	//console.log('Volume Maximo', target.data('volumeMaximo'))
	//target.data('limpo',true);
}