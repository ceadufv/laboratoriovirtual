/**
* @name	Lavar
* @description Lava o béquer, pipeta e balão vazios utilizando água da pisseta.
* @valid_source ["pisseta"]
* @valid_target ["vazio(bequer)", "vazio(pipeta)", "vazio(balao)", "sujo(eletrodo)", "cubeta"]
*
* @error {"cheio(bequer)" : "O béquer está cheio, faça o descarte primeiro"}
* @error {"cheio(pipeta)" : "A pipeta está cheia, faça o descarte primeiro"}
* @error {"cheio(balao)" : "O balão está cheio, faça o descarte primeiro"}
*/
function lavar(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	//$('#animacao').modal('show');

	//$('#interacao .modal-title').text('Lavando...');
	console.log('Volume Maximo', target.data('volumeMaximo'))

	target.data('limpo',true);
}
