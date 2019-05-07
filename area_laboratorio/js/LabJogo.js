// TODO: Eliminar a necessidade dessas globais
var uid = 0;    
var sprites = [];
var bg;
var buraco = [];
var scene;

LabJogo = function (data) {
    this._data = data;
    this._phaser;
    this._showPopup = false;
    this._popupAlpha = 0;
    this._armario = new LabArmario();
}

LabJogo.prototype.scene = function () {
	return this._phaser.scene;
}

LabJogo.prototype.lugarLivre = function (regiao) {
	// TODO:
	// Substituir essa chamada por um metodo estatico
	// por uma chamada a um metodo da instancia atual do laboratorio
	return LabUtils.lugarLivre( regiao );
}

LabJogo.prototype.armario = function () { return this._armario; }

LabJogo.prototype.popup = function () { return this._popup; }

LabJogo.prototype.movePopup = function (x,y) {

	var lab = this;

	var x0 = lab.popup().x;
	var y0 = lab.popup().y;

	var deltaX = x - x0;	
	var deltaY = y - y0;

    Phaser.Actions.Call(lab._popupGroup.getChildren(), function(child) {
        child.x += deltaX;
        child.y += deltaY + 100;
    });

	return this._popup;
}

LabJogo._validPopup = [
	'frasco_estoque',
	'bequer',
	'pipeta_pipetador'
];

LabJogo.prototype.popupShow = function (handler) {
	var concept = handler.concept();

	// So exibe popup para objetos predeterminados
	if (LabJogo._validPopup.indexOf(concept) == -1) return;

	this._showPopup = true;

	var texto = this.popup().getData('textos');	
	var x0 = this.popup().x;
	var y0 = this.popup().y;

	//this.popup().visible = true;
	//texto.visible = true;
	var margem = 30;
	var largura = 200;
	var o = -30;

	var graphics = this._popup.getData('graphics');
	graphics.visible = false;

	switch (handler.concept()) {
		case "frasco_estoque":
			// Conteudo
			texto[0].text = handler.data('json').nome;			
			texto[0].setFontSize(30);
			texto[1].text = 'Técnico CEAD';
			texto[2].text = 'dd/mm/YYYY';
			texto[3].text = '';

			// Alinhamentos
			texto[1].x = x0 - texto[1].width - (largura-texto[1].width) + margem;
			texto[1].y = y0 - o + texto[1].height/2;
			texto[2].setAlign('right');
			texto[2].x = x0 + (largura - texto[2].width) - margem;
			texto[2].y = y0 - o + texto[2].height/2;
		break;
		case "pipeta_pipetador":
			texto[0].text = handler.data('json').nome;	
			texto[0].setFontSize(40);
			texto[1].text = '';
			texto[2].text = '';

			// Alinhamentos
			texto[3].text = Math.round(handler.volume())+'/'+Math.round(handler.data('volumeMaximo'))+' ml'
			texto[3].x = x0 - texto[3].width/2;
			texto[3].y = y0 + 30;
		break;
		case "bequer":
			texto[0].text = handler.data('json').nome;	
			texto[0].setFontSize(40);
			texto[1].text = '';
			texto[2].text = '';

			// Alinhamentos
			texto[3].text = '';
			/*
			texto[3].text = Math.round(handler.volume())+'/'+Math.round(handler.data('volumeMaximo'))+' ml'
			texto[3].x = x0 - texto[3].width/2;
			texto[3].y = y0 + 30;
			*/

			// 
			var v = handler.volume()/handler.data('volumeMaximo');
			this.popupPorcentagem(v * 100);
		break;
		}

	// Centraliza o titulo
	texto[0].x = x0 - texto[0].width/2;
	texto[0].y = y0 - texto[0].height/2 - 60;	
    // Ajusta a posicao dos textos para ficarem alinhados
	//texto[0].x = x0-texto[0].width/2;
	//texto[1].x = x0+texto[1].width;

	LabUtils.bringToFront(this.popup());

	for (var i = 0 ; i < texto.length ; i++) {
		LabUtils.bringToFront(texto[i]);
	}

	LabUtils.bringToFront( this.popup().getData('graphics')	);
}

LabJogo.prototype.popupHide = function () {
	this._showPopup = false;

	var lab = this;
	var texto = lab.popup().getData('texto');
}

LabJogo.prototype.popupPorcentagem = function ( porcentagem ) {
	var w = 320;
	var ws = (porcentagem/100) * w;

	var graphics = this._popup.getData('graphics');

	graphics.visible = true;

	graphics.fillStyle(0xc0c0c0, 1);
	graphics.fillRect(-w/2, 48, w, 24);

	graphics.fillStyle(0xbe4447, 1);
	graphics.fillRect(-w/2, 48, ws, 24);
}

LabJogo.prototype.init = function (f) {
	var o = this;
	var game;
	var earth, logo;

	var width = 2520;
	var height = 1080;

	var config = {
	    type: Phaser.AUTO,
	    width: width,
	    height: height,
	    parent: 'AreaJogo',
	    plugins: {
	        global: [{
	        key: 'GameScalePlugin',
	        plugin: Phaser.Plugins.GameScalePlugin,
	        mapping: 'gameScale',
	        data: {
	            debounce: false,
	            debounceDelay: 50,
	            maxHeight: Infinity,
	            maxWidth: Infinity,
	            minHeight: 0,
	            minWidth: 0,
	            mode: 'fit',
	            resizeCameras: true,
	            snap: null
	        }
	        }]
	    },    
	    physics: {
	        default: 'arcade',
	        arcade: {
	            gravity: { y: 200 }
	        }
	    },
	    scene: {
	        preload: preload,
	        create: create,
	        update: update
	    }
	};


	function update() {
		o.movePopup(
			this.input.activePointer.position.x,
			this.input.activePointer.position.y + 128
		);

		var newAlpha = (o._showPopup)?1:0;
		o._popupAlpha += (newAlpha - o._popupAlpha) * 0.3;

	    Phaser.Actions.Call(o._popupGroup.getChildren(), function(child) {
	        child.alpha = o._popupAlpha;
	        child.alpha = o._popupAlpha;
	    });

	    // Braco do pHmetro
	    var elet = LabUtils.buscarPorConceito('eletrodo');
	    var eletrodo = elet[0];
	    var phm = LabUtils.buscarPorConceito('phmetro')[0];
	    var braco = LabUtils.buscarPorConceito('phmetro_braco')[0];
	    if (elet.length) {
	    	var fio_eletrodo = eletrodo.data('fio');

	    	var dx = eletrodo.data().x - phm.data().x;
	    	var dy = eletrodo.data().y - phm.data().y;

	    	fio_eletrodo.clear();
	    	fio_eletrodo.lineStyle(10, 0xc0c0c0, 1.0);
	    	fio_eletrodo.beginPath();
            fio_eletrodo.moveTo(40, -130);
            fio_eletrodo.lineTo(dx - 260, -90 + dy);
            fio_eletrodo.closePath();
            fio_eletrodo.strokePath();
            // TODO: Verificar se isso nao deixa pesado o processo
			LabUtils.bringToFront(fio_eletrodo);
	    }
	}

	function preload ()
	{
	    this.load.image('background', 'assets/background.png');
	    this.load.image('popup', 'assets/popup.png');
	    this.load.image('bequer', 'assets/bequer-vazio.png');
	    this.load.image('bequer_frente', 'assets/bequer-frente.png');
	    this.load.image('bequer_repouso', 'assets/bequer-repouso.png');
	    this.load.image('bequer_vazio', 'assets/bequer-descarte.png');
	    this.load.image('bequer_cheio', 'assets/bequer.png');
	    this.load.image('cubeta', 'assets/cubeta.png');	    
	    this.load.image('eletrodo', 'assets/eletrodo.png');    
	    this.load.image('frasco', 'assets/frasco.png');
	    this.load.image('frasco_estoque', 'assets/frasco_estoque.png');
	    this.load.image('armario_solucoes', 'assets/gaveta-solucoes.png');
	    this.load.image('armario_vidrarias', 'assets/gaveta-vidrarias.png');	    
	    this.load.image('hover', 'assets/movel-hover1.png');
	    this.load.image('lenco', 'assets/lenco.png');
	    this.load.image('objeto', 'assets/frasco.png');
	    this.load.image('pipeta', 'assets/pipeta.png');
	    this.load.image('pipeta_pipetador', 'assets/pipeta-pipetador.png');
	    this.load.image('pipetador', 'assets/pipetador.png');    	    
	    this.load.image('phmetro', 'assets/phmetro.png');
	    this.load.image('phmetro_braco', 'assets/phmetro-braco.png');
	    this.load.image('phmetro_frente', 'assets/phmetro-frente.png');
	    this.load.image('pisseta', 'assets/pisseta.png');
	    this.load.image('pia', 'assets/pia.png');
	    this.load.image('espectrofotometro', 'assets/espectrofotometro2.png');	    
	    this.load.image('tampa_espectrofotometro', 'assets/tampa_espectrofotometro.png');	 
	}

	function bgCriar(s) {
	    bg = s.add.sprite(0, 0, 'background').setOrigin(0);
	    LabUtils.objetoCriar(bg, s);
	}

	function create (){
	    scene = this;

	    // Cria na cena um ponteiro para o objeto que
	    // controla o laboratorio. Desse modo
	    // qualquer objeto na tela pode ter acesso a instancia
	    // de LabJogo, uma vez que todos estao relacionados
	    // a scene
	    this.data.set('lab', o);

	    var armarios = this.add.group();

	    bgCriar(this);

	    var armario_solucoes = this.add.sprite(485,988,'armario_solucoes').setInteractive({
	        pixelPerfect: true,
	        alphaTolerance: 120,
	        draggable: false,
	        cursor: 'pointer',
        });

	    var armario_vidrarias = this.add.sprite(1653,988,'armario_vidrarias').setInteractive({
	        pixelPerfect: true,
	        alphaTolerance: 120,
	        draggable: false,
	        cursor: 'pointer',
        });

	    //
        armario_solucoes.on('pointerdown', function () { abrirArmario(this.texture.key); });
        armario_vidrarias.on('pointerdown', function () { abrirArmario(this.texture.key); });

        //
	    var json = o._data.cenario;

	    // Cria os buracos na tela (lugares onde podem ser posicionados objetos)
	    LabUtils.lugaresCriar(this, json);

	    // Cria e distribui os objetos na tela
	    LabUtils.objetosCriar(this, json);

	    // Popula o armario com objetos, de acordo com o que esta no banco de dados
	    o.armario().scene( this );

	    // Cria o grupo de objetos do popup
	    // TODO: Criar um registro da posicao inicial dos objetos
	    // porque o metodo atual de deslocamento de objetos pode acumular erros
	    var group = this.add.group();
	    o._popupGroup = group;
		o._popup = this.add.sprite(0,0,'popup');
		
		var texto = [];

		texto.push(this.add.text(
			0,
			-90,
			'Solução Exemplo\n(padronizada)\n0.0124 mol/l',
			{
				fontFamily: 'Open Sans Condensed',
				fontSize: 30,
				color: '#ffffff',
				fontStyle: 'bold',
				align: 'center'
			}
		));

		texto.push(this.add.text(
			-175,
			-30,
			'Técnico CEAD',
			{
				fontFamily: 'Open Sans Condensed',
				fontSize: 30,
				color: '#000000',
				fontStyle: 'normal'
			}
		));

		texto.push(this.add.text(
			-20,
			-30,
			'Data: dd/mm/aaaa',
			{
				fontFamily: 'Open Sans Condensed',
				fontSize: 30,
				color: '#000000'
			}
		));

		texto.push(this.add.text(
			0,
			0,
			'Volume: 1',
			{
				fontFamily: 'Open Sans Condensed',
				fontSize: 60,
				color: '#000000'
			}
		));

		o._popup.setData('textos',texto);
		//o._popup.visible = false;
	    //texto.visible = false;

	    for (var i = 0 ; i < texto.length ; i++)
	    	group.add(texto[i]);

		group.add(o._popup);

		var graphics = this.add.graphics();
		o._popup.setData('graphics',graphics);
		group.add(graphics);


		// Linha que conecta o pHmetro ao eletrodo

		//o.popupPorcentagem(50);

	    // Executa o callback
	    f( o );

	    if (true) return;
	}

	var aspectRatio = width/height;

    // Cria uma lista de elementos basicos que podem
    // compor as solucoes
    for (var i = 0 ; i < this._data.elementos.length ; i++) {
        // Ao instanciar a classe LabSubstancia, a propria classe
        // cria uma lista estatica onde esses objetos serao
        // acessados posteriormente
        ( new LabElemento(this._data.elementos[i]) );
    }

    //
    this._phaser = new Phaser.Game(config);
    game = this._phaser;
}