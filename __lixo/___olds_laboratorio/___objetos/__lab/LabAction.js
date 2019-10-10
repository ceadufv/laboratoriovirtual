/*
LabAction
====
*/
var LabAction = function (data) {
	this._data = data;
	LabAction._data.push(this);
}

LabAction._data = [];

LabAction.get = function (id) {
	for (var i = 0 ; i < LabAction._data.length ; i++) {
		if (LabAction._data[i].data().id == id) return LabAction._data[i];
	}

	return false;
}

LabAction.data = function () {
	return this._data;
}

LabAction.prototype.interaction = function (idSource, idTarget) {
	//var action = LabUtils.getAction(idAction);
	var source = LabUtils.getObject(idSource);
	var target = LabUtils.getObject(idTarget);

	var interaction = new LabInteraction({
		source: source,
		target: target,
		action: this
	});

	return interaction;
}

/*
LabAction.prototype.action = function (source, target) {
	this.data().action(source, target);
}
*/
LabAction.prototype.compatible = function ( interaction )
{
	var source = interaction.source();
	var target = interaction.target();

	// Confornta os objetos de origem e destino com
	// as restricoes impostas pelas regras para a interacao atual
	var valid_source = this.data().source( source );
	var valid_target = this.data().target( target );

	return (valid_source && valid_target)?true:false;
}

LabAction.prototype.data = function () {
	var args = arguments;
	if (args.length == 0)
		return this._data;
	else{
		this._data = args[0];
		return this;
	}
}

LabAction.add = function () {
	var args = arguments;
	var acao = new LabAction(args[0]);
	return acao;
}