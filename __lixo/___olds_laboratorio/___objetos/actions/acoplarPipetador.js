/**
* @name	Acoplar Pipetador
* @description Acopla o pipetador na pipeta.
* @valid_source ["desacoplado(pipetador)"]
* @valid_target ["vazio(pipeta)"]
*/
function acoplarPipetador(interacao) {

	var pipetador = interacao.source();
	var pipeta = interacao.target();

	// Acopla o pipetador a pipeta
	pipeta.data('acoplado', true);
	pipeta.data('pipetador', pipetador);

	// Muda a imagem da pipeta, refletindo seu novo estado
	// (com pipetador acoplado)
	pipeta.setConcept('pipeta_pipetador');

	// Esconde o pipetador na tela
	// Isso eh suficiente para que ele seja ignorado
	// por todas as acoes do laboratorio.
	// Na pratica eh como se tivesse sido excluido,
	// mas essa solucao eh mais simples do que excluir
	// e recria-lo posteriormente
	pipetador.data().visible = false;

	return true;
}