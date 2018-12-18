LabInteraction = function (data) {

	this._source = LabUtils.getObject(data.source);
	this._target = (data.target)?LabUtils.getObject(data.target):LabUtils.getObject(data.source);
	this._action = data.action;

}

LabInteraction.prototype.errors = function () {
	var fn = this.action().data().errors;
	var error = fn(this);
	
	if (error)
		return error;
	else
		return false;
}


LabInteraction.prototype.action = function () { return this._action; }

LabInteraction.prototype.source = function () { return this._source; }

LabInteraction.prototype.target = function () { return this._target; }

LabInteraction.prototype.execute = function () {
	// TODO: Adicionar rastreio das acoes aqui

	// Executa a acao atual, passando como argumento a interacao
	// (Talvez tratar a acao pelo return aqui?)
	// return...
	this.action().data().action(this);
}

// Verifica se existe na interacao alguem que satisfaz a combinacao de conceito e estado
// recebidos como argumento.
// Por exemplo:
// A pergunta "Existe na interacao alguma pipeta no estado desacoplado?"
// É feita da seguinte maneira:
// exists('pipeta','desacoplado')
LabInteraction.prototype.exists = function (concept, state) {
	var source = this.source();
	var target = this.target();

	if (
		source.concept() == concept && source.state(state)
		||
		target.concept() == concept && target.state(state)
	) {
		return true;
	}
	return false;
}

// Retorna a lista de interacoes que podem ser realizadas envolvendo
// os dois objetos envolvidos na interacao atual
LabInteraction.prototype.menu = function () {
	//this.data().action(source, target);

	var actions = LabAction.data();
	var results = [];

	for (var i = 0 ; i < actions.length ; i++) {
		var r = actions[i].compatible(this);
		if (r) results.push(actions[i]);
	}

	return results;
}