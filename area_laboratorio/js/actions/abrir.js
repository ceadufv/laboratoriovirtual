/**
* @name	Abrir tampa
* @description Essa ação abre a tampa do equipamento
* @valid_source ["tampa_espectrofotometro"]
* @valid_target ["tampa_espectrofotometro"]
*/
function abrir(interacao) {
	var target = interacao.target();
	target.data().alpha = 1;

	var esp = LabUtils.buscarPorConceito("espectrofotometro")[0];
	esp.data('aberto', true);
}
