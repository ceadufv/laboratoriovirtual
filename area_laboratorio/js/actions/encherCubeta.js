/**
* @name	Encher e secar cubeta
* @description Transfere o conteúdo do béquer/frasco para a cubeta
* @valid_source ["cheio(bequer_cheio)", "frasco_estoque"]
* @valid_target ["vazio(cubeta)"]
*/
function encherCubeta(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	var volume = source.transferir(target, target.volumeDisponivel());


	// Inserir animação de trasnferência do líquido para cubeta e secagem com papel (semelhante à lavagem do eletrodo)
	$('#animacao').modal('show');

	limparTela();
	$('#animacao .modal-body .conteudo')
		.append('<div class="page page-1"><img src="assets/actions/enchercubeta.gif" /></a>');

    exibirPagina(1);

	var vidraria = 'cubeta';
	// Muda o nome da vidraria para identificar qual a solução presente
	var solucao = source.data('json').nome.toLowerCase();
	target.data('json').nome = vidraria+solucao

	
}