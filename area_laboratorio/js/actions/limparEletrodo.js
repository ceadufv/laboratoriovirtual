/**
* @name	Lavar e secar eletrodo
* @description Teste
* @valid_source ["pisseta"]
* @valid_target ["eletrodo", "cubeta"]
*/
function limparEletrodo(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	//$('#animacao').modal('show');

	//$('#interacao .modal-title').text('Lavando...');
	console.log('Volume Maximo', target.data('volumeMaximo'))

	target.data('limpo',true);
	
	// Inserir animação de lavagem e secagem do eletrodo
	
}