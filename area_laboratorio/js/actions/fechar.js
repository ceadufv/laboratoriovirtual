/**
* @name	Fechar tampa
* @description Essa ação fecha a tampa do equipamento
* @valid_source ["tampa_espectrofotometro"]
* @valid_target ["tampa_espectrofotometro"]
*/
function fechar(interacao) {
	var target = interacao.target();
	target.data().alpha = 0.001;

	config.status = 0;
	console.log(config.status)
	//var esp = LabUtils.buscarPorConceito("espectrofotometro")[0];
	//esp.data('fechado', true);
}
