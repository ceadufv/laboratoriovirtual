// utils
// https://stackoverflow.com/questions/1026069/how-do-i-make-the-first-letter-of-a-string-uppercase-in-javascript
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
//
class Objeto3D {
	constructor(id) {
		this._laboratorio;
		this._data; // = load(id);
		this._location;
	}

	// Acho que nao eh boa ideia mudar isso em tempo de execucao, entao aqui ha apenas um getter
	concept() {
		return this._data.userData.concept;
	}

	position(obj) {
		this.data().position.x = obj.position.x;
		this.data().position.y = obj.position.y;
		this.data().position.z = obj.position.z;
	}

	loaded() {
		return (this._data.children.length)?true:false;
	}

	init() {
	}

	data() {
		if (arguments.length) {
			this._data = arguments[0];
			return this;
		}
		else {
			return this._data;
		}
	}
	
	origin() {
	}

	location() {
		if (arguments.length) {
			this._location = arguments[0];
			return this;
		} else {
			return this._location;
		}
	}

	moveTo(target) {
		target.bringToMe(this);
	}

	bringToMe(object) {
		object.data().position.x = this.data().position.x;
		object.data().position.y = this.data().position.y;
		object.data().position.z = this.data().position.z;
	}

	userData() {
		return this._data.userData;
	}

	relationships() {
		var args = arguments;
		var result = [];
		var rel = this.userData().relationships;

		if (args.length) {
			for (var i = 0 ; i < rel.length ; i++) {
				if (rel[i].concept == args[0]) {
					// relationship + data
					if (args.length > 1) {
						if (rel[i].data == args[1])
							result.push(rel[i]);
					}
					// relationship
					else
						result.push(rel[i]);
				}
			}
		} else
			result = rel;

		return result;
	}

	partOf(val) {
		var result = false;
		var rel = this.relationships('partOf',val);
		return rel.length;
	}

	laboratorio() {
		if (arguments.length) {
			this._laboratorio = arguments[0];
			return this;
		} else {
			return this._laboratorio;
		}
	}
}

// Lugares possem um conjunto de vazios
class Lugar3D extends Objeto3D {
	constructor() {
		super();

		this._region = [];
	}

	init() {}

	bringToMe(object) {
		var lab = this.laboratorio();

		// Lista os vazios que estao relacionados ao objeto atual
		// Isso significa que quando um objeto for movido para esse objeto, serao direcionados para esses vazios
		if (!this._region.length) {
			this._region = lab.query('vazio').filter('partOf',this.concept()).data();
		}

		for (var i = 0 ; i < this._region.length ; i++) {
			if (this._region[i].isFree()) {
				this._region[i].bringToMe(object);
				break;
			}
		}
	}
}

class Armario3D extends Objeto3D { constructor() { super(); } init() {} }
class Chao3D extends Objeto3D { constructor() { super(); } init() {} }
class Capela3D extends Objeto3D { constructor() { super(); } init() {} }
class Capela_parede3D extends Objeto3D { constructor() { super(); } init() {} }
class Lixo3D extends Objeto3D { constructor() { super(); } init() {} }
class Cadeira3D extends Objeto3D { constructor() { super(); } init() {} }

// Lugar
class Prateleira3D extends Lugar3D {
	constructor() {
		super();
	}
}

class Phmetro3D extends Lugar3D { constructor() { super(); } }

class Vazio3D extends Objeto3D {
	constructor() {
		super();
		this._isFree = true;
	}

	isFree() { return this._isFree; }

	free() {
		this._isFree = true;	
		return this;
	}

	init() {
		if (this.laboratorio().debug()) {
			var geometry = new THREE.BoxGeometry( 1, 1, 1 );
			var material = new THREE.MeshBasicMaterial( {color: 0x00ff00} );
			var cube = new THREE.Mesh( geometry, material );
			cube.position.y = 0.5;
			var obj = this.data();
			obj.add(cube);
		}
	}

	bringToMe(target) {
		if (target.location()) target.location().free();
		target.location(this);
		this._isFree = false;
		target.data().position.x = this.data().position.x;
		target.data().position.y = this.data().position.y;
		target.data().position.z = this.data().position.z;
	}
}


class Query {
	constructor() {
		this._data = [];
		this._laboratorio;
	}

	data(d) {
		var args = arguments;
		if (args.length) {
			this._data = args[0];
			return this;
		} else {
			return this._data;
		}
	}

	filter(key,value) {
		var result = [];

		for (var i = 0 ; i < this._data.length ; i++) {
			if (this._data[i][key](value)) result.push(this._data[i]);
		}

		this._data = result;
		
		return this;
	}

	query(str) {
		var q = this;
		this.laboratorio().get(str, function (data) {
			q._data = data;
		});

		return this;
	}

	laboratorio() {
		var args = arguments;
		if (args.length) {
			this._laboratorio = args[0];
			return this;
		} else {
			return this._laboratorio;
		}
	}

	partOf() {

	}
}


class Bancada3D extends Lugar3D {
	constructor() {
		super();
	}

	init(o) {
		var objs = o.data.gavetas;
		var bancada = this.data();
		var object;
		var geometry = new THREE.BoxBufferGeometry( 1, 1, 1 );
		var material, texture;

		for (var i = 0 ; i < objs.length ; i++)
		{
			material = new THREE.MeshPhongMaterial( {
				color: 0xffffff,
				map: new THREE.TextureLoader().load( "models/asset/gavetas/"+objs[i]+".png" )
			} );

			//material = new THREE.MeshLambertMaterial( { color: Math.random() * 0xffffff } );
			object = new THREE.Mesh( geometry, material);

			object.position.x = 15.75 - Math.floor(i/2) * 3.48;
			object.position.y = 2.6 - (i%2) * 1.25;
			object.position.z = -3.5;

			object.scale.x = 3.1;
			object.scale.y = 0.5;

			bancada.add( object );
		}
	}
}

class Laboratorio3D {

	get(concept, f) {
		var result = [];
		for (var i = 0 ; i < this._data.length ; i++) {
			if (this._data[i].data().userData.concept == concept)
				result.push(this._data[i]);
		}

		f(result);

		return this;
	}

	query(str) {
		var result = new Query();
		result.laboratorio(this);
		result.query(str);
		return result;
	}

	// Move um objeto para o mesmo lugar que esta outro objeto
	moveObject(src, tar) {
		var lab = this;
		lab.get(src, function (source) {
			lab.get(tar, function (target) {
				source[0].moveTo(target[0]);
			})
		});
	}

	debug() {
		return this._debug;
	}

  click(f) {
    this._click = f;
  }

	constructor(data) {
    this._click = function () {};
		this._debug = (data.debug)?true:false;

		var container, stats;
		var camera, scene, raycaster, renderer, render;
		var mouse = new THREE.Vector2(), INTERSECTED;
		var mouseTarget;
		var radius = 500, theta = 0;
		var group = new THREE.Group();

		var aspect = window.innerWidth / window.innerHeight;
		var frustumSize = 150;
		var fullWidth = frustumSize * aspect / - 2;
		var fullHeight = frustumSize * aspect / 2;
		var x = frustumSize / 2;
		var y = frustumSize / - 2;
		var near = 1;
		var far = 1000;

		camera = new THREE.OrthographicCamera(fullWidth , fullHeight, x, y, near, far);
		var lab = this;

		render = function() {

			camera.lookAt( scene.position );
			camera.updateMatrixWorld();
			
			lab.get('bancada', function (data) {

				// find intersections
				raycaster.setFromCamera( mouse, camera );

				var intersects = raycaster.intersectObjects( data[0].data().children );

				if ( intersects.length > 0 ) {				
					if ( INTERSECTED != intersects[ 0 ].object ) {
						mouseTarget = intersects[ 0 ].object;
  				}
					
				} else {
					if ( INTERSECTED ) INTERSECTED.material.emissive.setHex( INTERSECTED.currentHex );
					INTERSECTED = null;
				}
				renderer.render( scene, camera );
			})
		}	

		this._data = [];
		this._group = new THREE.Group();
		this._camera;
		this._cameraDist = 50;

		this._group.scale.set(10,10,10);

		var angle = -90;
		var lab = this;
		var group = this._group;
		
// *** lab
		var container, stats;

		var frustumSize = 10;
		var aspect = window.innerWidth / window.innerHeight;
		lab._camera = camera;

		//
		camera = lab._camera;

		//
		init();
		animate();

		function load(obj)
		{
			var origin = (arguments.length > 1)?arguments[1]:0;
			var result = new THREE.Group();
			var onProgress = function () {};
			var onError = function () {}

			// Se for so um placeholder, nao importa o objeto
			if (obj == 'vazio' || obj == 'instrumento') return result;

			THREE.Loader.Handlers.add( /\.dds$/i, new THREE.DDSLoader() );

			/*new THREE.MTLLoader()
			.setPath( 'models/asset/' )
			.load( obj+'.mtl', function ( materials ) {

				materials.preload();

				new THREE.OBJLoader()
					.setMaterials( materials )
					.setPath( 'models/asset/' )
					.load( obj+'.obj', function ( object ) {

						// Centraliza
						var bounds = new THREE.Box3().setFromObject( object );
						var c = bounds.getCenter( object.position );
						var s = new THREE.Vector3();
						var size = bounds.getSize( s );

						//console.log(size)
						(c.multiplyScalar( - 1 ));

						// Desloca o centro, se necessario
						switch (origin) {
							case Laboratorio3D.ORIGIN_BOTTOM:
								object.position.set(object.position.x,object.position.y + size.y/2,object.position.z);
							break;
						}

						result.add( object );

					}, onProgress, onError );

			} );*/
			var material = new THREE.MeshStandardMaterial();
				new THREE.OBJLoader()
					.setPath( 'models/asset/')
					.load( obj+'.obj', function ( object ) {
						var loader = new THREE.TextureLoader()
							.setPath( 'models/asset/' );
				
						scene.add( object );
					} );

			return result;
		}


		function objetos(obj, f) {

			var result = new THREE.Group();
			var object = [];

			for (var i = 0 ; i < obj.length ; i++) {
				var clss;

				try {
					clss = eval(capitalizeFirstLetter(obj[i].concept)+'3D');
				}	catch(e) {

				}

				if (!clss) clss = Objeto3D;

				object[i] = new clss();

				object[i].laboratorio(lab);

				var orig = (!obj[i].origin)?0:obj[i].origin;

				var a = load(obj[i].concept, orig);

				// Userdata
				a.userData = {};
				if (obj[i].data)
					a.userData = obj[i].data;		
				a.userData.concept = obj[i].concept;

				// /Userdata
				object[i].data( a );
				object[i].init(obj[i]);
				object[i].position(obj[i]);

				// TODO: lab.add(object[i]);
				lab.add( object[i] );

				result.add(object[i].data());
			}

			var loaded = [];

			var getSum = function getSum(total, num) {
			  return total + num;
			}

			// Timer
			var timer = setInterval(function ( ){
				//
				for (var i = 0 ; i < obj.length ; i++) {
					if (object[i].loaded()) {
						loaded[i] = 1;
					}
				}

				if (loaded.length) if (loaded.reduce(getSum) == loaded.length) {
					clearInterval(timer);
				}

			}, 1000/30);

			return result;
		}

		function init() {
			container = document.createElement( 'div' );
			document.body.appendChild( container );

			//camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );
			// scene

			raycaster = new THREE.Raycaster();

			scene = new THREE.Scene();

			scene.background = new THREE.Color( 0xffffff );

			var ambientLight = new THREE.AmbientLight( 0xffffff, 1.0 );
			scene.add( ambientLight );
			scene.add( camera );

			//this.gavetasBancada();
			// model

			var onProgress = function ( xhr ) {

				if ( xhr.lengthComputable ) {

					var percentComplete = xhr.loaded / xhr.total * 100;
//					console.log( Math.round( percentComplete, 2 ) + '% downloaded' );
				}

			};

			var onError = function ( xhr ) { };

			// 
			group.add( objetos(data.objetos) );

			//var b = botoes();
			//group.add( b );

			scene.add( group );

			renderer = new THREE.WebGLRenderer();
			renderer.setPixelRatio( window.devicePixelRatio );
			renderer.setSize( window.innerWidth, window.innerHeight );
			container.appendChild( renderer.domElement );

      var onDocumentMouseDown = function () {
        lab._click( mouseTarget );
      };

			document.addEventListener( 'mousemove', onDocumentMouseMove, false );
			document.addEventListener( 'mousedown', onDocumentMouseDown, false );

			//

			window.addEventListener( 'resize', onWindowResize, false );

		}

		function onWindowResize() {

			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;

			camera.aspect = window.innerWidth / window.innerHeight;
			camera.updateProjectionMatrix();

			renderer.setSize( window.innerWidth, window.innerHeight );

		}

		function onDocumentMouseMove( event ) {
			event.preventDefault();
			mouse.x = ( event.clientX / window.innerWidth ) * 2 - 1;
			mouse.y = - ( event.clientY / window.innerHeight ) * 2 + 1;
		}

		//

		function animate() {

			requestAnimationFrame( animate );
			render();

		}

		// Vai para a cena chamada "inicio", descrita no json
		for (var i = 0 ; i < data.cena.length ; i++) {
			if (data.cena[i].current) {
				this.cena( data.cena[i].id );
				break;
			}
		}
	}

	updateCamera(x, y, z, angle, zoom) {
			var rad = (angle/360) * (2*Math.PI);

			this.zoom(zoom);

			this._group.position.x = x;
			this._group.position.y = y;
			this._group.position.z = z;
			
			if (this.debug()) this._group.rotation.x = -Math.PI/8;

			this._camera.position.z = this._cameraDist;

			// Faz a camera olhar para o centro da cena, onde esta o objeto
			this._camera.position.x = Math.cos(rad) * this._cameraDist;
			this._camera.position.y = 0;
			this._camera.position.z = Math.sin(rad) * this._cameraDist;

			this._camera.rotation.x = 0;
			this._camera.rotation.y = Math.PI/2 - rad;
			this._camera.rotation.z = 0;
	}
	
	cena() {
			var args = arguments;

			if (args.length) {
				var cena = data.cena.filter(function (o) { return (o.id == args[0]); });
				
				if (cena.length)
				{
					this.updateCamera(
						cena[0].position.x,
						cena[0].position.y,
						cena[0].position.z,
						cena[0].angle,
						cena[0].zoom
					);
				}
			}
	}

	zoom(z) {
		this._zoom = z;
		this._camera.zoom = z;
		this._camera.updateProjectionMatrix();
	}

	add(objeto) {
		this._data.push(objeto);
	}

	scene(s) {
		this._scene = s;
	}
}

Laboratorio3D.ORIGIN_BOTTOM = 0;
Laboratorio3D.ORIGIN_CENTER = 1;
