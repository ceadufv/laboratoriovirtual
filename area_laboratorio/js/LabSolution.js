// TODO:
// A solucao nao possuira volume proprio. Esse volume sera calculado
// sempre a partir do somatorio dos volumes dos reagentes que ela contem.
//
// Descricao:
// A solucao eh um objeto que consiste em um conjunto de instancias de
// ReagenteVolume
// O construtor pode receber:
// - Um ReagenteVolume
// A funcao "add" permite que novas solucoes sejam misturadas a solucao atual
// e precisa ser chamada toda vez que algo foi inserido na solucao.
// Essa funcao ira garantir que o qualquer solucao seja sempre composta por
// um conjunto de solucoes onde cada uma delas possui apenas um unico reagente.
// Esse pressuposto facilita a realizacao de analises nas solucoes envolvidas
LabSolution = function () {
	// _data eh uma lista de
	// reagentes e/ou solucoes
	this._data = [];
	//this._pH = NaN;

	if (arguments.length > 0) {
		var data = arguments[0];
		switch (data.constructor.name) {
			case 'Object':
				this._data.push(
					LabSubstancia.get(data)
				);
			break;
			// Array de LabSubstancia
			case 'Array':
				//console.log(data)
				this._data = data;
			break;
		}
	}
}

// Referencia que indica a data de preparo da solucao
/*
- Dia da aula
- Dia anterior à aula
- Cerca de uma semana atrás
- Cerca de um mês atrás
- Cerca de dois meses atrás
*/
LabSolution.prototype.tempo = function () {
	return this._data['tempo'];
}

LabSolution.prototype.tecnico = function () {
	return this._data['tecnico'];
}

LabSolution.prototype.descricao = function () {
	return this._data['descricao'];
}

LabSolution.prototype.nomesComposicao = function () {
	var list = [];

	for (var i = 0 ; i < this._data.length ; i++) {
		list.push( this._data[i].reagente().nome() );
	}

	return list.join(', ');
}

LabSolution.prototype.data = function () {
	switch (arguments.length) {
		case 1:
			return this._data[arguments[0]];
		break;
		case 2:
			this._data[arguments[0]] = arguments[1];
			return this;
		break;
		default:
			return this._data;
		break;
	}
}

LabSolution.prototype.volume = function () {
	var volume = 0;

	for (var i = 0 ; i < this._data.length ; i++) {
		volume += this._data[i].volume();
	}

	return volume;
}

LabSolution.prototype.getReagenteIndex = function (data) {
	for (var i = 0 ; i < this._data.length ; i++) {
		if (this._data[i].id() == data.id()) {
			return i;
		}
	}
	
	return -1;
}

// Recebe uma solucao LabSolution
LabSolution.prototype.add = function (data) {
	switch (data.constructor.name) {
		case "LabSolution":
			for (var i = 0 ; i < data._data.length ; i++) {
				var reagente = this.getReagenteIndex( data._data[i].reagente() );

				if (reagente == -1) {
					this.add(new LabSubstancia({
						id:data._data[i].id(),
						concentracao: data._data[i].concentracao(),
						volume: data._data[i].volume()
					}));
				} else {
					this._data[reagente]._volume += data.volume;
				}
			}
		break;
		case "LabSubstancia":
			this._data.push( arguments[0] );
		break;
	}

	return this;
}

LabSolution.prototype.extract = function ( volume ) {
	var list = [];
	var volumeTotal = this.volume();

	if (volume > volumeTotal) return false;

	var percent = volume/volumeTotal;
	// Cria uma lista de novos 
	for (var i = 0 ; i < this._data.length ; i++) {
		var removed = percent * this._data[i]._volume;
		// Subtrai o volume da solucao atual
		this._data[i]._volume -= removed;

		// Cria um novo volume de reagente
		list.push(new LabSubstancia({
			id: this._data[i].id(),
			concentracao: this._data[i]._concentracao,
			volume: removed
		}));
	}

	// Cria uma nova solucao
	var result = new LabSolution( list );

	return result;
}

LabSolution.prototype.transferTo = function ( target , volume )
{
	// Extrai uma quantidade da solucao atual
	var newSolution = this.extract( volume );

	target.add( newSolution );
	//
	return this;
}