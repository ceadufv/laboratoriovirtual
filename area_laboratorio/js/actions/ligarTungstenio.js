/**
* @name	Ligar Lâmpada Tungstênio (Visível)
* @description Essa ação liga a lampada de deutério para leitura no espectro visível
* @valid_source ["espectrofotometro"]
* @valid_target ["espectrofotometro"]
*/
function ligarTungstenio(interacao) {
	var target = interacao.target();

	target.data('ligadoTungstenio', true);
	
}
