/**
* @name	Descartar
* @description Descarta em um béquer de descarte o volume de uma solução contida em um béquer, pipeta, balão e micropipeta.
* @valid_source ["bequer", ambientado(bequer)", "ambientado(pipeta)", "ambientado(balao)", "cheio(bequer)", "cheio(pipeta)", "cheio(balao)", "cheio(micropipeta)", "cheio(bequer_descarte)"]
* @valid_target ["bequer_vazio", "pisseta", "vazio(bequer)"]
*
* @error {"vazio(bequer)" : "O béquer está vazio"}
* @error {"vazio(pipeta)" : "A pipeta está vazia"}
* @error {"vazio(balao)" : "O balão está vazio"}
* @error {"vazio(micropipeta)" : "A micropipeta está vazia"}
*/
function descartar(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	source.data('vazio',true);
	//source.data('vazio');

}
