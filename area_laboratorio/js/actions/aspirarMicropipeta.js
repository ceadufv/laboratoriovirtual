/**
* @name	Aspirar Micropipeta
* @description Aspira um volume de solução utilizando a micropipeta.
* @valid_source ["acoplado(micropipeta)"]
* @valid_target ["cheio(bequer)", "cheio(balao)"]
*
* @error {"desacoplado(micropipeta)" : "Primeiro acople a ponteira"}
* @error {"target(frasco_estoque)" : "Nao é possível aspirar direto do frasco estoque"}
*/
function aspirarMicropipeta(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	source.data('cheio',true);
	source.data('cheio');

}