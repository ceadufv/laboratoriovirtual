/**
* @name	Liberar 
* @description Libera o volume de solução contido na pipeta ou na micropipeta.
* @valid_source ["completado(pipeta)", "cheio(micropipeta)"]
* @valid_target ["vazio(bequer)&&ambientado(bequer)", "vazio(balao)&&ambientado(balao)"]
*/
function liberar(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	source.data('vazio',true);
	source.data('vazio');

	target.data('cheio',true);
	target.data('cheio');

}