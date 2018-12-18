var LabState = function () { }

LabState.cheio = function (o) { return (o.volume() > 0); }

LabState.vazio = function (o) { return (o.volume() == 0)?true:false; }

LabState.limpo = function (o) { return o.data('limpo')?true:false; }

LabState.sujo = function (o) { return !LabState.limpo(o); }

LabState.ambientado = function (o) { return (o.data('ambientado'))?true:false; }

LabState.naoAmbientado = function (o) { return !LabState.ambientado(o); }

LabState.acoplado = function (o) {
	return o.data('acoplado')?true:false;;
}

LabState.comPipetador = function (o) { var result = (o.data('pipetador'))?true:false; return result; }

LabState.semPipetador = function (o) { return !LabState.comPipetador(o); }

LabState.desacoplado = function (o) { return !LabState.acoplado(o); }

LabState.completado = function (o) {
	// Para evitar problemas de arredondamento, o conceito de cheio
	// nao eh exatamente possuir o volume maximo exato do recipiente
	var delta = Math.abs(o.volume() - o.data('volumeMaximo'));
	return (delta < 0.001)?true:false;
}

LabState.seco = function (o) { return o.data('seco'); }
