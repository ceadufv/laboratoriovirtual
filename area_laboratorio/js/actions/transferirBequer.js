/**
* @name	Transferir do béquer 
* @description Transfere o conteúdo do béquer com solução para a cubeta
* @valid_source ["cheio(bequer_cheio)"]
* @valid_target ["vazio(cubeta)","bequer", "vazio(bequer)&&limpo(bequer)"]
*/
function transferirBequer(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	var volume = source.transferir(target, target.volumeDisponivel());

	// Muda a imagem da pipeta, refletindo seu novo estado
	// (com pipetador acoplado)
	target.setConcept('bequer_cheio');

	// Esconde o pipetador na tela
	// Isso eh suficiente para que ele seja ignorado
	// por todas as acoes do laboratorio.
	// Na pratica eh como se tivesse sido excluido,
	// mas essa solucao eh mais simples do que excluir
	// e recria-lo posteriormente
	//target.data().visible = false;

}