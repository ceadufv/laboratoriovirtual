/**
* @name	Encher e secar cubeta
* @description Transfere o conteúdo do béquer/frasco para a cubeta
* @valid_source ["cheio(bequer_cheio)", "frasco_estoque"]
* @valid_target ["vazio(cubeta)"]
*/
function encherCubeta(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	var volume = source.transferir(target, target.volumeDisponivel());


	// Animação de trasnferência do líquido para cubeta e secagem com papel (semelhante à lavagem do eletrodo)
	$('#animacao').modal('show');


	// Muda a imagem da pipeta, refletindo seu novo estado
	// (com pipetador acoplado)
	//target.setConcept('bequer_cheio');

	
}