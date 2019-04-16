/**
* @name	Liberar
* @description Acopla o pipetador na pipeta.
* @valid_source ["cheio(pipeta_pipetador)"]
* @valid_target ["vazio(bequer)&&ambientado(bequer)","vazio(balao)&&ambientado(balao)", "bequer"]
*/
function liberarPipeta(interacao) {
	var source = interacao.source();
	var target = interacao.target();

	// Realiza a transferencia para o objeto destino
	source.transferir(target, target.volumeDisponivel());

	$('#animacao').modal('show')

	target.setConcept('bequer_cheio');
}