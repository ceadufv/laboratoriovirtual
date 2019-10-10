/**
* @name Configurar equipamento
* @description Essa ação abre o modal para configuração do equipamento
* @valid_source ["espectrofotometro"]
* @valid_target ["espectrofotometro"]
*/
function configurarEspectrofotometro(interacao) {
	var source = interacao.source();
	var target = interacao.target();
	
	$('#teste').modal('show');

}
