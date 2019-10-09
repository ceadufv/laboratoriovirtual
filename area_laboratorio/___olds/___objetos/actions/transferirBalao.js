/**
* @name	Transferir Balão
* @description Transfere uma solução de um balão com volume completado
* @valid_source ["completado(balao)"]
* @valid_target ["ambientado(frasco)&&vazio(frasco)"]
*
* @error {"cheio(frasco)" : "Esse frasco está cheio. Escolha um frasco vazio"}
* @error {"naoAmbientado(frasco)" : "É preciso ambientar antes de fazer a transferência"}
* @error {"naoCompletado(balao)" : "Complete o volume da solução primeiro"}
*/
function transferirBalao(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	source.data('sujo',true);
	source.data('sujo');
	
	target.data('cheio',true);
	target.data('cheio');

}