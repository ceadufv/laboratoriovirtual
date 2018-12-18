/**
* @name	Ligar
* @description Essa ação liga o espectrofotômetro
* @valid_source ["espectrofotometro"]
* @valid_target ["espectrofotometro"]
*/
function ligar(interacao) {
	var target = interacao.target();

	target.data('ligado', true);
	console.log('Ligou')
	
}
