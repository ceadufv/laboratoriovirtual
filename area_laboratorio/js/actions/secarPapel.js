/**
* @name	Secar com papel
* @description Essa ação seca
* @valid_source ["eletrodo", "cubeta"]
* @valid_target ["eletrodo", "cubeta"]
*/
function secarPapel(interacao) {
	var target = interacao.target();

	target.data('seco', true);
	
}
