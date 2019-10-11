/**
* @name	Secar
* @description Seca o eletrodo e cubeta utilizando o lenço de papel
* @valid_source ["lenco"]
* @valid_target ["pisseta", "limpo(eletrodo)", "cheio(cubeta)"]
*
* @error {"sujo(eletrodo)" : "Lave o eletrodo antes de secá-lo"}
*/
function secar(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	target.data('seco',true);


}
