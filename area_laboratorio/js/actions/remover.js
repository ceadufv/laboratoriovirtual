/**
* @name	Remover da tela
* @description Remove a vidraria da tela após o clique
* @valid_source ["bequer","bequer_cheio", "pipeta", "pipetador", "frasco_estoque", "cubeta"]
* @valid_target ["bequer","bequer_cheio", "pipeta", "pipetador", "frasco_estoque", "cubeta"]
*
*/
function remover(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	
	// Move o objeto para um "lixo" que é um lugar fora da tela
	source.moveTo('lixo');

}
