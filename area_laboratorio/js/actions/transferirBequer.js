/**
* @name	Transferir do béquer 
* @description Transfere o conteúdo do béquer com solução para a cubeta
* @valid_source ["cheio(bequer)"]
* @valid_target ["vazio(cubeta)","bequer"]
*/
function transferirBequer(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	var volume = source.transferir(target, target.volumeDisponivel());
}