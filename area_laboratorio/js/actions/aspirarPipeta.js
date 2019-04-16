/**
* @name	Aspirar Pipeta
* @description Aspira um volume de solução utilizando a pipeta.
* @valid_source ["pipeta_pipetador"]
* @valid_target ["cheio(bequer_cheio)","cheio(balao)"]
*
* @error {"naoAmbientado(pipeta_pipetador)" : "Primeiro, faça o ambiente da pipeta"}
*/
function aspirarPipeta(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	// Realiza a transferencia para o objeto destino
	target.transferir(source, source.volumeDisponivel());

	$('#animacao').modal('show')
}