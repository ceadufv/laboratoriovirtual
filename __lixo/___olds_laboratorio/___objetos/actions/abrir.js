/**
* @name	Abrir tampa
* @description Essa ação abre a tampa do equipamento
* @valid_source ["tampa_espectrofotometro"]
* @valid_target ["tampa_espectrofotometro"]
*/
function abrir(interacao) {
	var target = interacao.target();
	target.data().alpha = 1;

	//Muda o status do equipamento para aberto na função e no LabState
	config.status = 1;
	console.log(config.status)

	LabUtils.buscarPorConceito("espectrofotometro")[0].data('aberto', true)
	target.data('aberto',true);

	//var esp = LabUtils.buscarPorConceito("espectrofotometro")[0];
	//esp.data('aberto', true);
}
