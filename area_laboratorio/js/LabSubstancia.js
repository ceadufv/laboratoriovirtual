LabSubstancia = function () {
	if (arguments.length) {
		this.data(arguments[0]);
	}
}

LabSubstancia.prototype.concentracao = function () {
	return this._concentracao;
}

LabSubstancia.prototype.data = function () {
	var data = arguments[0];
	this._reagente = LabElemento.get(arguments[0].id);
	this._concentracao = data.concentracao;
	this._volume = data.volume;		
	return this;
}

LabSubstancia.prototype.volume = function () {
	switch (arguments.length) {
		case 1:
			return this._volume = arguments[0];
		break;
		default:
			return this._volume;
		break;
	}
}

LabSubstancia.get = function (data) {
	return new LabSubstancia(data);
}

LabSubstancia.prototype.id = function () {
	return this._reagente.id();
}

LabSubstancia.prototype.reagente = function () {
	return this._reagente;
}
/*
LabSubstancia.prototype.volume = function () {
	switch (arguments.length) {
		case 0:
			return this._volume; 
		break;	
		case 1:
			this._volume = arguments[0];
		break;			
		default:
			return false;
		break;
	}
}
*/