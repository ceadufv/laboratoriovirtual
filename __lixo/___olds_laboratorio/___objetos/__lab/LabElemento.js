LabElemento = function (data) {
	this._data = data;
	LabElemento._data.push(this);
}

LabElemento._data = [];

LabElemento.prototype.id = function () { return this._data.id; }

LabElemento.prototype.nome = function(){
	return this._data.nome;
}

LabElemento.prototype.cargaMax = function(){
	return this._data.dados[0];
}

LabElemento.prototype.npK = function(){
	return this._data.dados[1];
}

LabElemento.prototype.carga = function(){
	return this._data.dados[2];
}


LabElemento.prototype.vetorpKa = function(){
	return this._data.dados[3];
}

LabElemento.get = function (id) {
	if (id.constructor.name == 'LabElemento')
		return id;

	// TODO:
	// Puxar esses dados do BD
	// Para nao tornar essa rotina assincrona,
	// eh importante que esses dados tenham sido
	// pre-carregados ja no inicio do carregamento do laboratorio
	var result = false;
	for (var i = 0 ; i < LabElemento._data.length ; i++) {
		if (LabElemento._data[i]._data.id == id) {
			result = LabElemento._data[i];
			break;
		}
	}

	// Importante: os dados de reagentes devem ser imutaveis
	if (!result) {
		result = new LabElemento({ id:id, nome:'Reagente '+id });
	}

	return result;
}

LabElemento.prototype.data = function () {
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