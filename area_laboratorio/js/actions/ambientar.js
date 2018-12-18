/**
* @name	Ambientar
* @description Faz a ambientação do béquer, pipeta e balão utlizando solução de um frasco estoque.
* @valid_source ["frasco_estoque"]
* @valid_target ["vazio(bequer)&&limpo(bequer)","vazio(pipeta)&&limpo(pipeta)", "vazio(balao)&&limpo(balao)", "pipeta", "pipeta_pipetador"]
*
* @error {"sujo(bequer)" : "O béquer está sujo, lave-o primeiro"}
* @error {"sujo(pipeta)" : "A pipeta está suja, lave-a primeiro"}
* @error {"sujo(balao)" : "O balão está sujo, lave-o primeiro"}
* @error {"target(pipeta_pipetador)": "Antes de ambientar, desacople o pipetador"}
*/

function ambientar(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	if (target.concept() == 'bequer') {
		$('#animacao img').attr('src','assets/actions/ambientar_bequer.gif');
		$('#animacao').modal('show');
	}

	target.data('ambientado',true);

}
