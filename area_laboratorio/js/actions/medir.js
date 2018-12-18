/**
* @name	Medir
* @description Mede o pH/E de uma solução contida em um béquer
* @valid_source ["seco(eletrodo)"]
* @valid_target ["cheio(bequer)"]
*
* @error {"vazio(bequer)" : "Não há solução suficiente para cobrir o eletrodo"}
*/
function medir(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	// Nesse caso não há mudança de estado. O que acontece aqui, após o clique, é a rotina de medição.

	// target.data('seco',true);
	// target.data('seco');

}