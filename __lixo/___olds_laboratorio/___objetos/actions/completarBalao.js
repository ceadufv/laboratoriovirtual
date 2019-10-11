/**
* @name	Completar Balão
* @description Completa o volume de um balão volumétrico com solução utlizando água da pisseta.
* @valid_source ["pisseta"]
* @valid_target ["cheio(balao)"]
*/
function completarBalao(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	target.data('completado',true);
	target.data('completado');

}