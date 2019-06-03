/**
* @name	Modal 2 - Branco
* @description Essa ação abre a tampa do equipamento
* @valid_source ["espectrofotometro"]
* @valid_target ["espectrofotometro"]
*/
function modal2(interacao) {
	var source = interacao.source();
	var target = interacao.target();
	
	$('#teste2').modal('show');

}
