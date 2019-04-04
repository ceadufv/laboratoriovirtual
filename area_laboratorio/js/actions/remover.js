/**
* @name	Remover da tela
* @description Remove a vidraria da tela após o clique
* @valid_source ["eletrodo", "bequer", "pipeta", "pipetador"]
* @valid_target ["eletrodo", "bequer", "pipeta", "pipetador"]
*
*/
function remover(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	var inviseivel = source.data.visible(false);

}
