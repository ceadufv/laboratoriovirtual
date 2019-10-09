/**
* @name	Ambientar
* @description Faz a ambientação do béquer, pipeta e balão utlizando solução de um frasco estoque.
* @valid_source ["frasco_estoque", "pipeta_pipetador"]
* @valid_target ["vazio(bequer)&&limpo(bequer)","vazio(pipeta)&&limpo(pipeta)", "vazio(balao)&&limpo(balao)", "cheio(bequer_cheio)"]
*
* @error {"sujo(bequer)" : "O béquer está sujo, lave-o primeiro"}
* @error {"sujo(pipeta)" : "A pipeta está suja, lave-a primeiro"}
* @error {"sujo(balao)" : "O balão está sujo, lave-o primeiro"}
*/

function ambientar(interacao) {

	var source = interacao.source();
	var target = interacao.target();


	// Mostra o modal da animação
	$('#animacao').modal('show');

	limparTela();
	$('#animacao .modal-body .conteudo')
		.append('<div class="page page-1"><img src="assets/actions/ambientar_bequer.gif" /></a>');

    exibirPagina(1);

    // Muda o estado das vidrarias
	target.data('ambientado',true);
	source.data('ambientado', true);

}
