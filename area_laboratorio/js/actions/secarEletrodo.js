/**
* @name	Secar Eletrodo com papel
* @description Essa ação seca
* @valid_source ["papel"]
* @valid_target ["eletrodo"]
*/
function secarEletrodo(interacao) {
	var target = interacao.target();

	target.data('seco', true);
	
}
