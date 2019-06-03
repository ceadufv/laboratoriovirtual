/**
* @name	Modal 1 - Configuração
* @description Essa ação abre a tampa do equipamento
* @valid_source ["espectrofotometro"]
* @valid_target ["espectrofotometro"]
*/
function modal(interacao) {
	var source = interacao.source();
	var target = interacao.target();
	
	$('#teste').modal('show');

}
