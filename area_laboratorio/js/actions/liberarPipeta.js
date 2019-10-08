/**
* @name	Liberar
* @description Acopla o pipetador na pipeta.
* @valid_source ["cheio(pipeta_pipetador)"]
* @valid_target ["vazio(bequer)&&ambientado(bequer)","vazio(balao)&&ambientado(balao)", "bequer"]
*/
function liberarPipeta(interacao) {
	console.log('liberarPipeta');
	var source = interacao.source();
	var target = interacao.target();

	// Realiza a transferencia para o objeto destino
	source.transferir(target, target.volumeDisponivel());

	target.setConcept('bequer_cheio');

	// Inserir animação
  	$('#animacao').modal('show');

  	// Criacao do conteudo
  	$('#animacao .modal-body .conteudo').html('');
  	$('#animacao .modal-body .conteudo')
    	.append('<div class="page page-1"><img src="assets/actions/liberarpipeta.gif" /></a>');
}