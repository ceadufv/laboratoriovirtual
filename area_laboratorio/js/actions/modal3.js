/**
* @name	Modal 3 - Solução
* @description Essa ação abre a tampa do equipamento
* @valid_source ["espectrofotometro"]
* @valid_target ["espectrofotometro"]
*/
function modal3(interacao) {
	var source = interacao.source();
	var target = interacao.target();
	
	$('#teste3').modal('show');

}