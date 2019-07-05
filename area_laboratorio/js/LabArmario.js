LabArmario = function (data) {

	this._data = data;
	this._scene;
}

LabArmario.prototype.data = function () {
	switch (arguments.length) {
		case 0:
			return this._data;
		break;
		case 1:
			this._data = arguments[0];
		break;
	}
	return this;		
}

LabArmario.prototype.scene = function () {
	switch (arguments.length) {
		case 0:
			return this._scene;
		break;
		case 1:
			this._scene = arguments[0];
		break;
	}
	return this;	
}


LabArmario.prototype.buscar = function (s) {

	for (var i = 0 ; i < this._data.length ; i++) {
		if (this._data[i].id == s) {
			return this._data[i];
		}
	}

	return false;
}


LabArmario.prototype.pegar = function (s) {

	//var o_novo = this.buscar_novo(s);
	//console.log(o_novo)

	var o = this.buscar(s);

	console.log('>>>', this);

	// Item nao encontrado
	if (!o) return false;

	// Item existe, mas acabou
	if (o.disponiveis >= 1) {
		o.disponiveis--;
	} else {
		return false;
	}

	var sol = [];
	for (var i = 0 ; i < o.data.length ; i++) {
		sol[i] = new LabSolution();
		for (var j = 0 ; j < o.data[i].data.length ; j++) {
			for (var k = 0 ; k < o.data[i].data[j].substancias.length ; k++) {
				var sub = new LabSubstancia( o.data[i].data[j].substancias[k] );
				sol[i].add( sub );
			}
		}
	}

	var sObjeto = LabUtils.objetoFromArmario({
		concept: o.conceito,
		region: 'bancada',
	}, this.scene());



	if (sObjeto) {

		// Adiciona os dados JSON no objeto,
		// para o caso de serem necessarios em operacoes futuras
		sObjeto.data('json', o);

		if (o._data) {
			// Insere os atributos pre-definidos do objeto
			for (var i in o._data) {
				sObjeto.data(i, o._data[i]);
			}
		}

	    for (var i = 0 ; i < sol.length ; i++) {
	    	sObjeto
	        	.addContent(sol[i])	
	    }

		return sObjeto;	    
	} else {
		return false;
	}
}