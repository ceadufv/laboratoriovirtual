/**
* @name	Desacoplar Pipetador
* @description Acopla o pipetador na pipeta.
* @valid_source ["pipeta_pipetador"]
* @valid_target ["pipeta_pipetador"]
*/
function desacoplarPipetador(interacao) {
	var pipeta = interacao.source();
	var pipetador = pipeta.data('pipetador');

	// TODO:
	// Talvez seja o caso de tentar assegurar que o 
	// pipetador desacoplado ficara em lugar proximo da
	// pipeta, para deixar mais claro para o usuario o que
	// acabou de acontecer
	// Procura um lugar livre na bancada, onde o pipetador possa ser colocado
	var lugarLivre = pipeta.lab().lugarLivre('bancada');

	// Se nao houver lugar para onde possa ir o pipetador,
	// agora desacoplado, a funcao eh interrompida
	if (!lugarLivre) return false;

	// Efetua a remocao do pipetador da pipeta
	pipeta.setConcept('pipeta');
	pipeta.data('pipetador', false);
	
	// Coloca o pipetador sobre a bancada
	pipetador.place(lugarLivre);
}