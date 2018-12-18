/**
* @name	Medir absorbância e transmitância
* @description Apenas uma função de teste
* @valid_source ["limpo(cubeta)"]
* @valid_target ["espectrofotometro"]
*
* @error {"sujo(cubeta)" : "Lave e seque a cubeta primeiro"}
*/
function medirAbsorbancia(interacao) {

	var source = interacao.source();
	var target = interacao.target();

	if (target.data('ligado') !== true){
		console.log('Ligue o Espectrofotometro primeiro')
	}
	else 
		


	if (target.data('aberto') == true){

		console.log('Abriu')

		LabEspectrofotometro.medirabs({
			status:1,
			funcao: function (data) {
				console.log('Tampa aberta')
				console.log(data)
			}
		})
	}
	else {
		LabEspectrofotometro.medirabs({
			status:0,
			funcao: function (data) {
				console.log('Tampa fechada')
				console.log(data)
			}
		})
	}

	if (target.data('zerado') == true){
		LabEspectrofotometro.medirabs({
			status:0,
			funcao: function (data) {
				console.log('Zerado')
				console.log(data)
				// Quando zerado retorna na tela o valor de Amed0 e Tmed0
			}
		})

	}



	// if (target.data('ligadoDeuterio') == true){

	// 	LabEspectrofotometro.medirabs({
	// 		status:0,
	// 		intensidadedefonte: lerArquivo(arquivos.intensidadefonteUV),
	// 		funcao: function (data) {
	// 			console.log(data)
	// 		}
	// 	})
	// }
	

	


	
	
}

