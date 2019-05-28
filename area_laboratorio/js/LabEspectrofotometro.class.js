// TODO: Importar de um JSON os dados que aparecem aqui (util para testes e para funcionamento da aplicacao em si)
Solucao = function () { 
    this._data = {
        substanciaNaSolucao: []
    }; // Substancia
}

Solucao.prototype.substancia = function () {
    if (arguments.length) {
        return this._data.substanciaNaSolucao[arguments[0]];
    } else
        return this._data.substanciaNaSolucao;
}

Solucao.prototype.epslon = function () {
    var result = [];

    var substancias = this.substancia();

    for (var i = 0 ; i < substancias.length ; i++) {
        result.push(substancias[i].epslon());
    }

    return result;      
}

// Retorna um array contendo as concentracoes estoque das substancias preentes na solucao
Solucao.prototype.concentracaoEstoque = function () {
    var result = [];

    var substancias = this.substancia();

    for (var i = 0 ; i < substancias.length ; i++) {
        result.push(substancias[i].concentracaoEstoque());
    }

    return result;
}

Solucao.prototype.absortividade = function () {
    var result = [];

    var substancias = this.substancia();

    for (var i = 0 ; i < substancias.length ; i++) {
        result.push(substancias[i].absortividade());
    }

    return result;
}

Solucao.prototype.adicionarSubstancia = function (data, volume) {
    //
    data.solucao = this;

    //
    var sns = new SubstanciaNaSolucao({substancia: data, volume: volume });
    this._data.substanciaNaSolucao.push(sns);
}

Solucao.prototype.getSubstancia = function (i) {
    //return this._data[]
}

SubstanciaNaSolucao = function (data) {
    this._data = {
        solucao: data.solucao,
        substancia: data.substancia,
        volume: data.volume
    } 
}

SubstanciaNaSolucao.prototype.concentracaoEstoque = function () {
    return this._data.substancia._data.concentracaoEstoque;
}

SubstanciaNaSolucao.prototype.epslon = function () {
    return this._data.substancia._data.epslon;    
}

SubstanciaNaSolucao.prototype.absortividade = function () {
    var dados = this.epslon();
    var vetor = [];

    for (var i = 0; i< dados.length; i++){ 
            vetor.push(dados[i].I)
    }
    return vetor;
}

Substancia = function (data) {
    this._data = {
        nome: data.nome,
        cargaMax: data.cargaMax,
        npK: data.npK,
        carga: data.carga,
        vetorpKa: data.vetorpKa,
        concentracaoEstoque: data.concentracaoEstoque,
        epslon: data.epslon
    };
}

QuerySolucao = function (data) {
    this._data;
    this._callback = function () { };
}

QuerySolucao.prototype.data = function (data) { this._data = data; }

QuerySolucao.prototype.done = function (f) {
    if (arguments.length > 0) {
        this._callback = arguments[0];
    } else {
        this._callback(this._data);
    }
}

function solucao(sol) {
    var query = new QuerySolucao();

    $.ajax({
        url:'data.php',
        method: 'post',
        data: {
            action: 'solucao',
            data: JSON.stringify(sol)
        }
    }).done(function (data) {
        var s = new Solucao();
        var substancia;

        for (var i = 0 ; i < data.length ; i++) {
            substancia = new Substancia(data[i]);
            s.adicionarSubstancia(substancia, data[i].volume);
        }

        //solucao._server = data;
        query.data(s);

        // Executa o callback passando "this._data" como argumento
        query.done();
    })

    return query;
}
