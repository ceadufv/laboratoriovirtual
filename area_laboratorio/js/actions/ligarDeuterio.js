/**
* @name	Ligar Lâmpada Deutério (UV)
* @description Essa ação liga a lampada de deutério para leitura no espectro UV
* @valid_source ["espectrofotometro"]
* @valid_target ["espectrofotometro"]
*/
function ligarDeuterio(interacao) {
	var target = interacao.target();

	target.data('ligadoDeuterio', true);
	
}
