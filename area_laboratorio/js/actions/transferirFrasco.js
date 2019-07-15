/**
* @name	Transferir solução
* @description Transfere uma solução de um frasco estoque para um béquer vazio
* @valid_source ["frasco_estoque"]
* @valid_target ["vazio(bequer)&&limpo(bequer)"]
*
* @error {"naoAmbientado(bequer)" : "É preciso ambientar antes de fazer a transferência"}
*/
function transferirFrasco(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	if (target.concept() == 'bequer') {
		$('#animacao img').attr('src','assets/actions/transferirFrasco_bequer.gif');
		$('#animacao').modal('show');
	}


//	source.acoplarAopHmetro();

	/*
	var spHmetro = LabHandler.procurar('bequer_repouso')[0];
	var lugar1 = target.place();
	var lugar2 = spHmetro.place();

	console.log( lugar2.region() )

	if (lugar2.region() == 'phmetro_bequer') {
		source.place(lugar2);
		spHmetro.place(lugar1);
	}
	*/

	// Realiza a transferencia para o objeto destino
	source.transferir(target, target.volumeDisponivel());

	// Muda a imagem do bequer, refletindo seu novo estado
	// (cheio com solucao)
	target.setConcept('bequer_cheio');


}
