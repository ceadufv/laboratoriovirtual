/**
* @name	Completar Pipeta
* @description Completa o volume da pipeta utilizando a solução.
* @valid_source ["cheio(pipeta)"]
* @valid_target ["cheio(bequer)", "completado(balao)"]
*/
function completarPipeta(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	source.data('completado',true);
	source.data('completado');

}