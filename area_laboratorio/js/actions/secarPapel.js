/**
* @name	Secar com papel
* @description Essa ação seca
* @valid_source ["papel", "cubeta"]
* @valid_target ["cubeta"]
*/
function secarPapel(interacao) {
	var target = interacao.target();

	target.data('seco', true);
	
}
