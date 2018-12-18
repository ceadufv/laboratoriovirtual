/**
* @name	Zerar
* @description Essa ação faz a leitura do espectro do branco
* @valid_source ["espectrofotometro"]
* @valid_target ["espectrofotometro"]
*/
function zerar(interacao) {
	var target = interacao.target();

	target.data('zerado', true);
	
}
