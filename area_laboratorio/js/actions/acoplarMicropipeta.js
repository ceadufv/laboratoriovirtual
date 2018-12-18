/**
* @name	Acoplar Micropipeta
* @description Acopla a micropipeta à ponteira.
* @valid_source ["desacoplado(micropipeta)"]
* @valid_target ["ponteira"]
*/
function acoplarMicropipeta(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	source.data('acoplado',true);
	source.data('acoplado');

}
