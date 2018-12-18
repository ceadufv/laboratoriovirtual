/*
LabHandler eh uma classe que tem por objetivo dar maior comodidade
ao programador que interage com sprites gerados usando PhaserJS. 
Ao inves de estender classes do PhaserJS optamos por criar uma classe
separada. Essa classe eh instanciada sempre que um novo sprite eh
inserido na tela. Apos ter sido criada, a instancia de LabHandler vira
um atributo do sprite. Sendo assim, via de regra, a interacao com
qualquer sprite na tela se da usando essa classe. Por exemplo: ao
buscarmos um sprite pelo seu ID usando LabUtils.get(ID_DO_OBJETO)
o retorno nao sera o sprite em si, mas a instancia de LabHandler que
o controla
*/
LabHandler = function (data) {
	this._data = data;
	LabHandler._data.push(this);
}

LabHandler._data = [];

// *** Eventos de mouse
LabHandler.onPointerOver = function () {
	var handler = this.data.get('handler');
	var lab = handler.lab();
	lab.popupShow(handler);
}

LabHandler.onPointerOut = function () {
	var handler = this.data.get('handler');
	var lab = handler.lab();
	lab.popupHide(handler);
}

LabHandler.onPointerDown = function () {
	// Descreve o objeto no log
	// console.log(this.getData('handler').description())

	this.getData('handler').lab().popupHide();

	// Guarda o lugar onde o objeto estava quando o mouse clicou
	this.setData('pointerStart', this.getData('place').getData('handler') );
}

LabHandler.onPointerUp = function (o) {
	// 
	var pointerStart = o.getData('pointerStart');
	var pointerEnd = o.getData('place').getData('handler');

	// Se o mouse subiu, porem de alguma forma
	// o computador nao tem a informacao de quando desceu,
	// candela a acao (ex.: a pessoa veio com o mouse clicado de fora da janela)
	if (!pointerStart) return;

	// Se o objeto foi arrastado na tela, nao exibe o menu.
	// Esse menu so deve aparecer quando a pessoa clicar no objeto sem arrastar,
	// indicando que pretende extrair alguma informacao do objeto
	var myMenu = pointerStart.equals(pointerEnd);

	if (!myMenu) return;

	// Cria uma interacao entre o objeto e ele mesmo
	var interacts = new LabInteraction({
		source:o.getData('handler'),
	});

	// Verifica os itens do menu de acoes
	// do objeto clicado
	var menu = interacts.menu();

	console.log(interacts)


	// Para evitar excesso de dialogos na tela,
	// o menu com interacoes entre o objeto e ele mesmo
	// so aparece quando houver interacoes validas
	// como candidatas para aparecer no menu
	if ( menu.length ) {
		exibirMenu( interacts );
	}
}

LabHandler.onDrag = function (pointer, dragX, dragY){
    // Evita o drag de objetos estaticos
    var h = this.data.get('handler'); if (h.static()) return false;

    this.x = dragX;
    this.y = dragY;

    var livres = this.data.get('destinos');

    var pontoDestino = LabUtils.destaquePontoMaisProximo(this, livres);

    if (pontoDestino) {
        LabUtils.destaqueLugar(pontoDestino);
        LabUtils.destaqueLugar(this);
    } else {
        //LabUtils.destaqueLugar(pontoDestino, false);
        LabUtils.destaqueLugar(this, false);
    }

    // Ponto de destino (centro do buraco mais proximo)
    if (pontoDestino) {
        this.setData('place', pontoDestino);
    } else {
        this.setData('place', this.data.get('_place') );
    }

    LabUtils.destaqueOff(this);
};

LabHandler.onDragStart = function () {
    // Evita o drag de objetos estaticos
    var h = this.data.get('handler'); if (h.static()) return false;

    LabUtils.bringToFront(this);
    //this.setData('destinos', LabUtils.naoOcupados( buraco, this.data.get('place').data.get('uid') ) );
    this.setData('destinos', buraco );
    this.data.get('_place', this.data.get('place'));
}

LabHandler.onDragEnd = function (pointer) {
    // Evita o drag de objetos estaticos
    // var h = this.data.get('handler'); if (h.static()) return false;

    // Remove o destaque da origem e do alvo
    LabUtils.destaqueLugar(this, false);
    var o = this.data.get('place');
    LabUtils.destaqueLugar(o, false);
    var f = LabUtils.filhos(o);
    f.forEach(function (a) { LabUtils.destaqueLugar(a, false); });

    var interacts = LabUtils.interaction(this.data.get('handler'));

    // 
    if (interacts) {
        exibirMenu( interacts );
        //listarInteracoes(this, this.data.get('place'));           
        this.setData('place', this.data.get('_place'));
    } else {
        this.setData('_place', this.data.get('place'));


        // Tenta o menu individual caso o menu de interacao falhe
        LabHandler.onPointerUp( this );

    }

    this.x = this.data.get('place').x;
    this.y = this.data.get('place').y;
};

// 

LabHandler.prototype.lab = function () { return this.data().scene.data.get('lab'); }

LabHandler.prototype.volume = function () {
	var volume = 0;

	if (this.data('content')) {
		for (var i = 0 ; i < this.data('content').length ; i++) {
			volume += this.data('content')[i].volume();
		}
	}

	return volume;
}

LabHandler.procurar = function (concept) {
	var data = LabHandler.data();
	var results = [];

	for (var i = 0 ; i < data.length ; i++) {
		if (data[i].concept() == concept) results.push(data[i]);
	}

	return results;
}

// 
LabHandler.prototype.volumeDisponivel = function () {
		return this.data('volumeMaximo') - this.volume();
}

LabHandler.prototype.transferir = function (target, totalTarget) {
	var source = this;

	if (!source.content())
		source.data('content',[]);

	var content = [];

	var i;
	//source.transferTo(target, target.data('volumeMaximo'));

	var totalSource = source.volume();

	// Impede que a acao tente transferir um volume superior a
	// tudo que esta disponivel no objeto de origem
	if (totalTarget > totalSource) totalTarget = totalSource;

	//if (totalTarget+ > )
	
	for (i = 0 ; i < source.content().length ; i++) {
		var sourceSolution = source.content()[i];
		var volume = (sourceSolution.volume()/totalSource) * totalTarget;
		var targetSolution = new LabSolution();
		sourceSolution.transferTo(targetSolution, volume);
		content.push(targetSolution);
	}

	target.data('content', content);	
}

LabHandler.prototype.description = function () {
	var json = this.data('json');

	var result = '';

	if (json) {
		result += "'"+json.nome+"' ("+this.concept()+") ";
		var volMax = this.data('volumeMaximo');
		if (this.data('volumeMaximo')) result += '; Volume: '+this.volume();

		if (this.concept() != 'frasco_estoque') result += '/'+volMax+' ml';
	} else {
		result += this.concept();
	}

	console.log(this.content())

	var estados = [];
	for (var i in LabState) {
		if (LabState[i](this)) estados.push(i);
	}

	result += '; Estados: '+estados.join(', ');

	return result;
}

LabHandler.prototype.content = function (v) {
	switch (arguments.length) {
		case 0:
			return this.data('content');
		break;
		case 1:
			this.data('content')[arguments[0]];
		break;
	}
	return this;	
}

LabHandler.prototype.addContent = function (v) {

	if (!this.data('content')) this.data('content', []);

	this.data('content').push(v);

	return this;
}

LabHandler.prototype.noInteraction = function () {
	switch (arguments.length) {
		case 0:
			return this.data('noInteraction');
		break;
		case 1:
			this.data('noInteraction', arguments[0]);
		break;
	}
	return this;	
}

LabHandler.data = function () { return LabHandler._data; }

LabHandler.get = function (id) {
	for (var i = 0 ; i < LabHandler._data.length ; i++) {
		if (LabHandler._data[i].id() == id)
			return LabHandler._data[i];
	}

	return false;
}

LabHandler.prototype.equals = function (other) { return (this.id() == other.id()); }

LabHandler.prototype.id = function () { return this.data().data.get('uid'); }

LabHandler.prototype.spriteData = function (field) { return this.data().data.get( field ); }

LabHandler.prototype.data = function () { 

	switch (arguments.length) {
		case 1:
			return this.data().getData(arguments[0]);
		break;
		case 2:
			return this.data().setData(arguments[0], arguments[1]);
		break;
		default:
			return this._data;
		break;
	}
}

LabHandler.prototype.children = function () {
	var results = [];
	var list = LabHandler._data;
	for (var i = 0 ; i < list.length ; i++) {
		var place = list[i].place();
		if (place) {
			if (place.equals(this)) results.push(list[i]);
		}
	}
	return results
}

// TODO:
// Implementar esse setter dentro de concept.
// Ele teve de ser criado por fora porque concept
// ja possuia uma funcao com a assinatura a ser usada pelo setter
LabHandler.prototype.setConcept = function (concept) {
	this.data().setTexture(concept);
}

LabHandler.prototype.concept = function () {
	if (arguments.length == 0)
		return this.data().texture.key;
	else
		return this.data().texture.key == arguments[0];
}

LabHandler.prototype.static = function () {
	if (arguments.length)
		this.data().setData('static', arguments[0]);
	else {
		return this.data().data.get('static');
	}
}

LabHandler.prototype.place = function () {
	switch (arguments.length) {
		case 0:
			return this.data().data.get('place').data.get('handler');		
		break;
		case 1:
			// Place eh um Sprite, e nao um LabHandler
			this.data().data.set('place', arguments[0].data());
			this.data().x = arguments[0].data().x;
			this.data().y = arguments[0].data().y;			
			this.data().visible = true;		
		break;
	}
}

LabHandler.prototype.objetoAcoplado = function () {
	// Infere o objeto que ocupa o pHmetro
	var spHmetro = LabUtils.buscarPorRegiao('phmetro_bequer');
	//
	return spHmetro[0];
}

LabHandler.prototype.acoplarAopHmetro = function (source) {
	// 
	var acoplado = this.objetoAcoplado();
	acoplado.moveTo('bancada_repouso');
	source.moveTo('phmetro_bequer');
}

LabHandler.prototype.moveTo = function (region) {
	var livres = LabUtils.lugaresLivres(region);
	console.log('Livre', region, livres[0])

	if (!livres.length) return false;
	this.place(livres[0]);
}

LabHandler.prototype.region = function () {
	return this.data().data.get('region');
}

// Informa se o estado eh valido
LabHandler.prototype.state = function (state) {
	var result = LabState[state](this);
	return result;
}