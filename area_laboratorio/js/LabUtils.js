LabUtils = function () { }

LabUtils.sanitize = function (s) { return s.toLowerCase().replace(/[^a-zA-Z ]/g, ""); }

LabUtils.getObject = function (data) {

    if (data.constructor.name == 'LabHandler')
        return data;
    else
    if (data.constructor.name == 'Number')
        return LabHandler.get(data);
    else
    if (data.constructor.name == 'initialize')
        return data.data.get('handler');
    else {
        console.log(data.constructor.name, data)
        return data;
    }
}

LabUtils.getAction = function (data) {
    if (data.constructor.name == 'LabHandler')
        return data;
    else
        return LabAction.get(data);
}

LabUtils.objetoCriar = function (sprite, origem) {
    // Eh importante que o uid seja identico ao indice do objeto no array de sprites,
    // pois esse pressuposto sera considerado em outras funcoes como 'LabUtils.objetoSpriteById'
    sprite.setData('uid',uid);
    sprite.setData('place', origem);
    sprite.setData('_place', origem);

    // LabHandler eh uma classe com recursos para aprimorar
    // os recursos de manipulacao de sprites ja disponiveis no phaserjs
    var handler = new LabHandler(sprite);
    sprite.setData('handler', handler);

    switch (handler.concept()) {
        case "espectrofotometro":
            //var s = handler.lab().scene();
            //console.log(scene.add.text)
            //handler.lab().scene()//.scene().add.sprite(0, 0, 'background')
            //s.add.sprite(0,0,'tampa_aberta_espectrofotometro');
        break;

        case "phmetro":
            var fonte = 'Open Sans Condensed';
            var pH = 0;
            var pHcorreto = pH.toString().replace(".",",") // Alterar ponto por vírgula
            var modo = "pH";
            var temperatura = 25;
            var scene = sprite.scene;
            
            var TextopH = scene.add.text(0, 0, pHcorreto , { fontFamily: fonte, fontSize: 32, color: '#ffffff' });
            var TextoModo = scene.add.text(0, 0, 'pH', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });
            
            var TextoModo1 = scene.add.text(0, 0, 'Modo:', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });            

            var utc = new Date().toJSON().slice(0,10).split('-').reverse().join('/');

            var TextoTemperatura = scene.add.text(0, 0, temperatura + '°C', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });
            var TextoDataAtual = scene.add.text(0, 0, utc, { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });
            
            var TextoDataCalibracao = scene.add.text(0, 0, 'CAL: ', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });
            


            // TODO:
            handler.data('pHvisor', TextopH);
            handler.data('pHmodo', TextoModo);
            handler.data('calibracao', TextoDataCalibracao);

            TextopH.x = -50; TextopH.y = -75 - 150;
            TextoModo.x = -75; TextoModo.y = -88 - 150;
            TextoModo1.x = -125; TextoModo1.y = -88 - 150;
            TextoTemperatura.x = 80; TextoTemperatura.y = -88 - 150;
            TextoDataAtual.x = -125; TextoDataAtual.y = -32 - 150;
            TextoDataCalibracao.x = 0; TextoDataCalibracao.y = -32 - 150;

            var group = scene.add.group();
            group.add(TextopH);
            group.add(TextoModo);
            group.add(TextoModo1);
            group.add(TextoTemperatura);
            group.add(TextoDataAtual);
            group.add(TextoDataCalibracao);                                                

            Phaser.Actions.Call(group.getChildren(), function(child) {
                child.x += sprite.x;
                child.y += sprite.y;
            });


//            sprite.add(TextopH)

        break;
    }

    //var handler = sprite.data.get('handler');
    // A principio a profundidade do objeto coincide com o UID
    //sprite.setData('index', uid);

    sprites[uid] = sprite;

    uid++;

    return sprite;
}

LabUtils.lugaresCriar = function (s, j) {

    var json = j.placeholder;

    // TODO: Ler a partir de um JSON
    var posicao = [];
    var i;

    for (i = 0 ; i < json.length ; i++)
        posicao[i] = json[i];

    for (var j = 0 ; j < json.length ; j++) {
        var sprite = LabUtils.objetoCriar(
            s.add.sprite(posicao[j].x, posicao[j].y, 'hover')
            .setInteractive({
                pixelPerfect: true,
                draggable:false
            }),
            bg
        );

        // Cria lugares sem interacao
        if (json[j].noInteraction) {
            sprite.data.get('handler').noInteraction(true);
        }        

        sprite.setData('region',posicao[j].region);

        if (json[j].hidden) sprite.alpha = 0;

        buraco.push(sprite);
    }

    return buraco;
}

LabUtils.objetoIdBySprite = function (lista) {
    var result = [];

    for (var i = 0 ; i < lista.length ; i++) {
        result.push(lista[i].data.get('uid'));
    }

    return result;
}

LabUtils.objetoSpriteById = function (ids) {
    var result;

    if (typeof(ids) == 'object') {
        result = [];
        for (var i = 0 ; i < sprites.length ; i++) {
            if (ids.indexOf(i) != -1)
                result.push(sprites[i]);
        }
    }

    if (typeof(ids) == 'number') {
        return sprites[ids];
    }

    return result;
}

LabUtils.objetoUidPai = function (sprite) {
    var result = sprite.data.get('place').data.get('uid');
    if (typeof(result) == 'number')
        return result;
    else
        return -1;
}

// A tela pode ser dividida em regioes que recebem uma string
// para identifica-las. Essa funcao analisa a regiao passada como argumento
// e retorna um lugar vago, caso exista
LabUtils.lugaresLivres =function (regiao) {
    var s = [];
    var ocupacao = [];

    var s = LabHandler.data();

    // Cria uma lista de lugares LabUtils.ocupados assumindo, a principio,
    // que todos os lugares estao desocupados
    for (i = 0 ; i < s.length ; i++) {
        if (s[i].region() == regiao) {
            ocupacao.push({ uid:s[i].data().data.get('uid'), ocupado: false });
        }
    }

    // Verifica os lugares LabUtils.ocupados, inferindo essa informacao
    // a partir do estado atual dos sprites
    var ocupar = function (uid) {
        for (var i = 0 ; i < ocupacao.length ; i++) {
            if (ocupacao[i].uid == uid) {
                ocupacao[i].ocupado = true;
                break;
            }
        }
    }

    //
    for (i = 0 ; i < sprites.length ; i++) {
        // Os sprites invisiveis sao ignorados
        if (!sprites[i].visible) continue;

        var o = sprites[i].data.get('place');
        var uid = LabUtils.objetoUidPai(sprites[i]);
        if (uid >= 0) {
            ocupar(uid, true);
        }
    }

    var results = [];

    // Gera uma lista com os lugares desocupados
    for (i = 0 ; i < ocupacao.length ; i++) {
        var h = LabUtils.objetoSpriteById(ocupacao[i].uid);

        if (!ocupacao[i].ocupado) {
            results.push(h.data.get('handler'));
        }
    }

    if (results.length) return results;

    return false;
}

LabUtils.lugarLivre = function (regiao) {
    var l = LabUtils.lugaresLivres(regiao);
    if (l.length)
        return l[0];
    else
        return false;
}

// Recebe uma lista de sprites
LabUtils.naoOcupados = function (s) {
    var result = [];
    var ocupacao = [];
    var i;

    // 
    var excecao = (arguments.length > 1)?arguments[1]:-1;

    // Cria uma lista de lugares LabUtils.ocupados assumindo, a principio,
    // que todos os lugares estao desocupados
    for (i = 0 ; i < s.length ; i++) {
        ocupacao[i] = { uid:s[i].data.get('uid'), ocupado: false };
    }

    // Verifica os lugares LabUtils.ocupados, inferindo essa informacao
    // a partir do estado atual dos sprites
    var ocupar = function (uid) {
        for (var i = 0 ; i < ocupacao.length ; i++) {
            if (ocupacao[i].uid == uid) {
                ocupacao[i].ocupado = true;
                break;
            }
        }
    }

    for (i = 0 ; i < sprites.length ; i++) {
        var o = sprites[i].data.get('place');
        var uid = LabUtils.objetoUidPai(sprites[i]);
        if (uid >= 0) {
            ocupar(uid, true);
        }
    }

    // Gera uma lista com os lugares desocupados
    for (i = 0 ; i < ocupacao.length ; i++) {
        if (!ocupacao[i].ocupado || ocupacao[i].uid == excecao) {
            result.push( LabUtils.objetoSpriteById(ocupacao[i].uid) );
        }
    }

    return result;
}

LabUtils.filhos = function (a) {
	var results = [];
	var myUid = a.data.get('uid');

	for (i = 0 ; i < sprites.length ; i++) {
	    var o = sprites[i].data.get('place');
	    var uid = LabUtils.objetoUidPai(sprites[i]);
	    if (uid == myUid) {
	        results.push(sprites[i]);
	    }
	}

	return results;
}

LabUtils.filho = function (a) {
	for (i = 0 ; i < sprites.length ; i++) {
	    var o = sprites[i].data.get('place');
	    var uid = LabUtils.objetoUidPai(sprites[i]);
	    if (uid == a.data.get('uid')) {
	        return sprites[i];
	    }
    }	
    return false;
}

LabUtils.ocupado = function (a) {
	return (LabUtils.filho(a))?true:false;
}

// Retorna os itens que nao estao nos 2 arrays
LabUtils.NAND = function (a,b) {
	var _a = [];
	var _b = [];
	var results = [];
	var uid, i;

	for (i = 0; i < a.length ; i++) {
		uid = a[i].id();
		_a.push( uid );
	}

	for (i = 0; i < b.length ; i++) {
		uid = b[i].id();
		_b.push( uid );
	}	

	for (i = 0; i < a.length ; i++) {
		uid = a[i].id();
		if (_b.indexOf(uid) == -1) results.push(a[i]);
	}

	for (i = 0; i < b.length ; i++) {
		uid = b[i].id();
		if (_a.indexOf(uid) == -1) results.push(b[i]);
	}

	return results;
}

LabUtils.um = function (o) {
	if (o.constructor.name == 'Array')
		return o[0];
	else
		return o;
}

LabUtils.conceito = function (o) {
	var a = LabUtils.um(o);

	if (a)
		return a.texture.key;
	else
		return false;
}

LabUtils.diferente = function (a,b) {
    return
        (
            a.data.get('uid')
            != 
            b.data.get('uid')
        );

}

LabUtils.bringToFront = function (o) {
    o.scene.children.bringToTop(o);
}

// Recebe um objeto e retorna
// uma LabUtils.interaction na qual ele esta envolvido.
// Quando um objeto esta sendo movido na tela
// ele armazena informacoes suficientes para o
// programa saber que LabUtils.interaction devera ocorrer.
// Basicamente para saber a LabUtils.interaction que ocorrera
// eh preciso saber o objeto que originou a acao
// e o que recebe acao. O objeto que origina a acao
// eh o proprio objeto passado para a funcao.
// E o de destino eh aquele que esta no
// mesmo lugar que o objeto de origem (data.get('place')).
LabUtils.interaction = function (o) {
	// O objeto destino eh o objeto que 
	// ocupa o mesmo espaco que o objeto atual
	// porem eh um objeto LabUtils.diferente do atual
	var source = o;
    var target = LabUtils.alvoInteracao(o);

    if (!source || !target) return false;

    if (!source.equals(target)) {
        return new LabInteraction({
            source: source,
            target: target
        });
    }
    else
        return false;
}

LabUtils.buscarPorConceito = function (concept) {
    var data = LabHandler._data;
    var results = [];

    for (var i = 0 ; i < data.length ; i++) {
        if (data[i].concept() == concept)
            results.push( data[i] );
    }

    return results;
}

LabUtils.buscarPorRegiao = function (region) {
    var data = LabHandler._data;
    var results = [];

    for (var i = 0 ; i < data.length ; i++) {
        if (!data[i].place()) continue;

        if (data[i].place().region() == region)
            results.push( data[i] );
    }

    return results;
}

LabUtils.children = function (o) {
    var ocupantes = o.place().children();
    var results = [];
    for (var i = 0 ; i < ocupantes.length ; i++) {
        // Ignora os objetos invisiveis
        // que nao sao considerados para efeito de interacao
        // Esses objetos surgem em situacoes como:
        // acoplar pipetador a pipeta.
        // O sprite do pipetador continua
        // na tela, mas fica invisivel.
        // Ele ficara visivel novemente apenas
        // se a acao "desacoplar" for chamada,
        // tornando-se interativo novamente
        if (!ocupantes[i].data().visible) continue;
        results.push(ocupantes[i]);
    }
    return results;
}

LabUtils.alvoInteracao = function (o) {
    var ocupantes = LabUtils.children(o);
    var outros = LabUtils.NAND([o], ocupantes);
    var result = outros.length?outros[0]:false;
    return result;
}

/*
    Cria um objeto a partir do JSON tipicamente
    utilizado quando algo eh retirado do armario
*/
LabUtils.objetoFromArmario = function (json, s) {

    var alvo = null;
    var x = null;
    var y = null;

    var alvo = LabUtils.lugarLivre(json.region);

    if (!alvo) return;

    x = alvo.data().x;
    y = alvo.data().y;
    sss = alvo.data();

    var obj = LabUtils.objetoCriar(
        s.add
            .sprite(x, y, json.concept)
            .setInteractive({ pixelPerfect: true, draggable:true, cursor: 'pointer' }),
        sss
    );

    obj.on('pointerdown', LabHandler.onPointerDown);
    obj.on('pointerover', LabHandler.onPointerOver)
    obj.on('pointerout', LabHandler.onPointerOut)

    //obj.on('pointerup', LabHandler.onPointerUp);
    obj.on('drag', LabHandler.onDrag);
    obj.on('dragstart', LabHandler.onDragStart);
    obj.on('dragend', LabHandler.onDragEnd);
    obj.setOrigin(0.5,0.9);

    // Muda o alpha do objeto para 0.001
    // Ele fica oculto porem pode ser interativo
    if (json.alpha) {
        obj.alpha = json.alpha;
    } else {
        obj.alpha = 1;
    }

    // Define se o objeto se move ou nao (ex: a pia nao se move, nao pode ser arrastada)
    var handler = obj.data.get('handler');
    //
    handler.static(
        (json.static)
        ?
        json.static
        :
        false
    );

    return handler;
}

LabUtils.objetosCriar = function (s, json) {

    //
    var objetos = json.objetos;

    for (var i = 0 ; i < objetos.length ; i++) {

        LabUtils.objetoFromArmario(objetos[i], s);
  
    }

}

LabUtils.destaqueOn = function (objeto) {
    objeto.setTint(0xFFFF00);
}

LabUtils.destaqueOff = function (objeto) {
    objeto.setTint(0xFFFFFF);
}

LabUtils.destaqueLugar = function (objeto) {
    var args = arguments;
    var excecao = (args.length > 1)?args[1]:false;

    var oc = LabUtils.filho(objeto);

    // remove o destaque de um objeto
    if (args.length > 1) {
        if (!args[1]) {
            LabUtils.destaqueOff(objeto);

            if (oc)
                LabUtils.destaqueOff(oc);

            return;
        }
    }

    // Aplica destaque ao objeto
    //if (oc.data.get('uid'))
    if (oc)
        LabUtils.destaqueOn(oc);

    LabUtils.destaqueOn(objeto);
}

LabUtils.destaquePontoMaisProximo = function (p1, candidatos) {
    var distanciaMinima = Infinity;
    var resultado = new Phaser.Math.Vector2(0,0);
    var dx;
    var dy;
    var atual, distanciaAtual;
    var maisProximo;

    //var ocupacao = verificaOcupacao(candidatos);
    var i;

    for (i = 0 ; i < candidatos.length ; i++) {
        atual = candidatos[i];
        dx = p1.x - atual.x;
        dy = p1.y - atual.y;

        // Ignora os objetos que nao sao interativos
        //console.log( 'Handler', atual.data.get('handler').noInteraction() );
        if (atual.data.get('handler').noInteraction()) {
            continue;
        }

        distanciaAtual = Math.sqrt( dx*dx + dy*dy );

        if (distanciaAtual < distanciaMinima) {
            maisProximo = atual;
            distanciaMinima = distanciaAtual;
        }
        LabUtils.destaqueLugar(atual, false);
    }

    if (distanciaMinima < 128) {
        return maisProximo;
    } else {
        return false;
    }
}