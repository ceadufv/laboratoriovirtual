class Configurador {

    constructor() {
        this.nomeInterno = [];
        this.nomeFormatado = [];
        this.volumes = [];
        this.substancias = [];
        this.dadosTemporarios = {
            contador: 0,
            listaID: [],
            listaDados: []
        }
        this.json = {
            descricao: '',
            numeroDeAmbientes: 2,
            instrumentos: [],
            objetos: []
        }

        // Dados da interface do usuário
        this.idSelectVidrarias = '';
        this.idSelectVolumes = '';
        this.idSelectSubstancias = '';
        this.idTituloModal = '';
        this.idModal = '';
    }

    /**
     * @param {string} localData String com o caminho relativo do arquivo .php com os comandos relativos a leitura e armazenagem
     * @param {string} selectTipos String com o id do select responsável por exibir as vidrarias existentes
     * @param {string} selectSubstancias String com o id do select responsável por exibir a lista de substâncias
     * @param {number} idPratica Número com o id da prática no banco de dados que será carregada, em caso de nova prática, o valor passado será -1
     */
    inicializar(localData, selectTipos, selectSubstancias, idPratica) {
        // Carrega informações de substâncias e vidrarias cadastradas
        this.carregarInformacoes(localData);

        // Altera no html as opções absorvidas
        let vidrarias = this.get('vidrarias');
        let identificador = this.get('vidrarias_identificador');
        // Preenche a lista de vidrarias disponíveis
        this.set('id_lista_vidrarias', selectTipos);
        for(let i = 0; i < vidrarias.length; i++) {
            $('#' + selectTipos).append('<option value="'+identificador[i]+'">'+vidrarias[i]+'</option>');
        }
        // Preenche a lista com as substâncias cadastradas
        this.set('id_lista_substancias', selectSubstancias);
        let substancias = configurador.get('substancias');
        for(let i = 0; i < substancias.length; i++) {
            $('#' + selectSubstancias).append('<option value="'+substancias[i]+'">'+substancias[i]+'</option>');
        }

        // Verifica se será exibida informações já existentes em uma prática cadastrada
        if(idPratica !== -1) {
            this.carregarPratica(localData, idPratica);
        }
    }

    /**
     * @param {string} localData String que contêm o caminho para o arquivo .php que será efetuado o ajax
     * @param {number} idPratica Inteiro com o id_pratica no banco de dados
     */
    carregarPratica(localData, idPratica) {
        let ctx = this;
        $.ajax({
            url: localData,
            type: 'POST',
            async: false,
            data: { acao: 'carregar_dados_pratica', id: idPratica },
            dataType: 'json',
            success: function(res) {
                if(res.sucesso) {
                    // Armazena os dados no atributo json da classe
                } else {
                    console.log(res.log);
                }
            },
            error: function(res) { console.log(res); }
        });
    }

    /**
     * @param {string} divInformacoes É a string com o id da div onde serão adicionados os detalhes de cada vidraria cadastrada, com opção de edição e exclusão 
     * @param {string} classeDiv É a string com a classe css adicionada ao form-inline que armazena os detalhes e os botões, o padrão é ""
     * @param {string} classeBotaoEditar É a string com a classe css atribuída ao botão de edição, o padrão é btn-warning
     * @param {string} classeBotaoExcluir É a string com a classe css atribuída ao botão de exclusão, o padrão é btn-danger
     */
    atualizarInformacoesTela(divInformacoes, classeDiv = '', classeBotaoEditar = 'btn-warning', classeBotaoExcluir = 'btn-danger') {
        let dataString = this.formatarDadosDeLeitura();
        $('.detalhes-vidrarias').remove();
        for(let i = 0; i < dataString.length; i++) {
            // Utiliza a posição na lista de ojetos do configurador como id
            $('#' + divInformacoes).append('<div class="form-inline detalhes-vidrarias ' + classeDiv + '"><div class="col-8"><p>' + (i + 1) + ') ' + dataString[i] + '</p></div><div class="col-2"><button class="btn ' + classeBotaoEditar + '" onclick="editarVidraria(' + i + ')"><i class="fas fa-edit"></i> Editar</button></div><div class="col-2"><button class="btn ' + classeBotaoExcluir + '" onclick="excluirVidraria(' + i + ')"><i class="far fa-trash-alt"></i> Excluir</button></div></div>');
        }
    }

    /**
     * @param {string} atributo String com o identificador do atributo
     */
    get(atributo) {
        if(atributo === 'vidrarias') {
            return this.nomeFormatado;
        } else if(atributo === 'vidrarias_identificador') {
            return this.nomeInterno;
        } else if(atributo === 'volumes') {
            return this.volumes;
        } else if(atributo === 'substancias') {
            return this.substancias;
        } else if(atributo === 'dados_temporarios_frasco') {
            return this.dadosTemporarios;
        } else if(atributo === 'objetos_cadastrados') {
            return this.json.objetos;
        } else if(atributo === 'id_lista_vidrarias') {
            return this.idSelectVidrarias;
        } else if(atributo === 'id_lista_volumes') {
            return this.idSelectVolumes;
        } else if(atributo === 'id_lista_substancias') {
            return this.idSelectSubstancias;
        } else if(atributo === 'id_modal') {
            return this.idModal;
        } else if(atributo === 'id_modal_titulo') {
            return this.idTituloModal;
        }
    }

    /**
     * @param {string} atributo String com o nome do atributo da classe a ser alterado
     * @param {} valor Valor a ser atribuído, varia o tipo
     */
    set(atributo, valor) {
        if(atributo === 'dados_temporarios_substancias') {
            for(let i = 0; i < valor.length; i++) {
                this.addSubsFrasco(valor[i][0], valor[i][1]);
            }
        } else if(atributo === 'id_lista_vidrarias') {
            this.idSelectVidrarias = valor;
        } else if(atributo === 'id_lista_volumes') {
            this.idSelectVolumes = valor;
        } else if(atributo === 'id_lista_substancias') {
            this.idSelectSubstancias = valor;
        } else if(atributo === 'id_modal') {
            this.idModal = valor;
        } else if(atributo === 'id_modal_titulo') {
            this.idTituloModal = valor;
        }
    }

    carregarInformacoes(destino) {
        let ctx = this;
        $.ajax({
            url: destino,
            type: 'POST',
            async: false,
            data: { 'acao': "informacoes_cadastradas" },
            dataType: "json",
            success: function(res) {
                if(res.sucesso) {
                    ctx.nomeInterno = res.log.nomeInterno.slice();
                    ctx.nomeFormatado = res.log.nomeFormatado.slice();
                    ctx.volumes = res.log.volumes.slice();
                    ctx.substancias = res.log.substancias.slice();
                } else {
                    console.log(res);
                }
            },
            error: function(res) { console.log(res); }
        });
    }

    formatarDadosDeLeitura() {
        let detalhamento = [];
        for(let i = 0; i < this.json.objetos.length; i++) {
            var str = this.nomeFormatado[this.nomeInterno.indexOf(this.json.objetos[i].nome)] + ': ';
            if(this.json.objetos[i].nome === 'frasco_estoque') {
                for(let j = 0; j < this.json.objetos[i].substancias.length; j++) {
                    str += this.json.objetos[i].substancias[j] + ' (' + this.json.objetos[i].concentracoes[j].toString().replace('.', ',') + ' mol/L), ';
                }
                str += 'com volume de ' + this.json.objetos[i].volumeTotal + ' mL e rótulo "' + this.json.objetos[i].rotulo + '".';
            } else if(this.json.objetos[i].nome === 'pipetador' || this.json.objetos[i].nome === 'ponteira') {
                str += ' tamanho único com rótulo "' + this.json.objetos[i].rotulo + '".';
            } else if(this.json.objetos[i].nome === 'micropipeta') {
                str += 'capacidade de '+ (this.json.objetos[i].capacidadeMinima * 1000).toString().replace('.', ',') + '-' + (this.json.objetos[i].capacidadeMaxima * 1000).toString().replace('.', ',') + ' uL, desvio padrão de ' + this.json.objetos[i].desvioPadrao.toString().replace('.', ',') + ' e rótulo "' + this.json.objetos[i].rotulo + '".';
            } else {
                str += 'com capacidade de ' + this.json.objetos[i].capacidadeMaxima + ' mL, desvio padrão de ' + this.json.objetos[i].desvioPadrao.toString().replace('.', ',') + ', preenchimento mínimo de ' + this.json.objetos[i].preenchimentoMinimo.toString().replace('.', ',') + ' %, preenchimento máximo de ' + this.json.objetos[i].preenchimentoMaximo.toString().replace('.', ',') + ' % e rótulo "' + this.json.objetos[i].rotulo + '".';
            }
            detalhamento.push(str);
        }
        return detalhamento;
    }

    addSubsFrasco(substancia, concentracao) {
        let id = this.dadosTemporarios.contador;
        this.dadosTemporarios.listaID.push(id);
        this.dadosTemporarios.listaDados.push([substancia, parseFloat(concentracao.replace(',', '.'))]);
        this.dadosTemporarios.contador++;
        return id;
    }

    removeSubsFrasco(id) {
        let indc = this.dadosTemporarios.listaID.indexOf(id);
        this.dadosTemporarios.listaID.splice(indc, 1);
        this.dadosTemporarios.listaDados.splice(indc, 1);
    }

    resetarFrasco() {
        this.dadosTemporarios.contador = 0;
        this.dadosTemporarios.listaID = [];
        this.dadosTemporarios.listaDados = [];
    }

    addObjeto(jsonData) {
        if(jsonData.nome === 'frasco_estoque') {
            let subs = [], conc = [];
            for(let i = 0; i < this.dadosTemporarios.listaDados.length; i++) {
                subs.push(this.dadosTemporarios.listaDados[i][0]);
                conc.push(this.dadosTemporarios.listaDados[i][1]);
            }
            this.json.objetos.push({
                nome: jsonData.nome,
                substancias: subs,
                concentracoes: conc,
                volumeTotal: parseFloat(jsonData.tamanho.replace(' mL', '').replace(',', '.')),
                rotulo: jsonData.rotulo
            });
            this.resetarFrasco();
        } else if(jsonData.nome === 'pipetador' || jsonData.nome == 'Ponteira') {
            this.json.objetos.push({
                nome: jsonData.nome,
                capacidadeMinima: 0,
                capacidadeMaxima: 0,
                preenchimentoMinimo: 0,
                preenchimentoMaximo: 0,
                desvioPadrao: 0,
                rotulo: jsonData.rotulo
            });
        } else if(jsonData.nome === 'micropipeta') {
            let tamanho = jsonData.tamanho.replace(' uL', '').split('-');
            this.json.objetos.push({
                nome: jsonData.nome,
                capacidadeMinima: parseFloat(tamanho[0].replace(',', '.')) / 1000,
                capacidadeMaxima: parseFloat(tamanho[1].replace(',', '.')) / 1000,
                preenchimentoMinimo: 0,
                preenchimentoMaximo: 100,
                desvioPadrao: parseFloat(jsonData.dp.replace(',', '.')),
                rotulo: jsonData.rotulo
            });
        } else {
            this.json.objetos.push({
                nome: jsonData.nome,
                capacidadeMinima: 0,
                capacidadeMaxima: parseFloat(jsonData.tamanho.replace(' mL', '').replace(',', '.')),
                preenchimentoMinimo: parseFloat(jsonData.minimo.replace(',', '.')),
                preenchimentoMaximo: parseFloat(jsonData.maximo.replace(',', '.')),
                desvioPadrao: parseFloat(jsonData.dp.replace(',', '.')),
                rotulo: jsonData.rotulo
            });
        }
    }

    atualizarObjeto(jsonData) {
        if(jsonData.nome === 'frasco_estoque') {
            let subs = [], conc = [];
            for(let i = 0; i < this.dadosTemporarios.listaDados.length; i++) {
                subs.push(this.dadosTemporarios.listaDados[i][0]);
                conc.push(this.dadosTemporarios.listaDados[i][1]);
            }
            this.json.objetos[jsonData.indice] = {
                nome: jsonData.nome,
                substancias: subs,
                concentracoes: conc,
                volumeTotal: parseFloat(jsonData.tamanho.replace(' mL', '').replace(',', '.')),
                rotulo: jsonData.rotulo
            }
            this.resetarFrasco();
        } else if(jsonData.nome === 'pipetador' || jsonData.nome == 'Ponteira') {
            this.json.objetos[jsonData.indice] = {
                nome: jsonData.nome,
                capacidadeMinima: 0,
                capacidadeMaxima: 0,
                preenchimentoMinimo: 0,
                preenchimentoMaximo: 0,
                desvioPadrao: 0,
                rotulo: jsonData.rotulo
            }
        } else if(jsonData.nome === 'micropipeta') {
            let tamanho = jsonData.tamanho.replace(' uL', '').split('-');
            this.json.objetos[jsonData.indice] = {
                nome: jsonData.nome,
                capacidadeMinima: parseFloat(tamanho[0].replace(',', '.')) / 1000,
                capacidadeMaxima: parseFloat(tamanho[1].replace(',', '.')) / 1000,
                preenchimentoMinimo: 0,
                preenchimentoMaximo: 100,
                desvioPadrao: parseFloat(jsonData.dp.replace(',', '.')),
                rotulo: jsonData.rotulo
            }
        } else {
            this.json.objetos[jsonData.indice] = {
                nome: jsonData.nome,
                capacidadeMinima: 0,
                capacidadeMaxima: parseFloat(jsonData.tamanho.replace(' mL', '').replace(',', '.')),
                preenchimentoMinimo: parseFloat(jsonData.minimo.replace(',', '.')),
                preenchimentoMaximo: parseFloat(jsonData.maximo.replace(',', '.')),
                desvioPadrao: parseFloat(jsonData.dp.replace(',', '.')),
                rotulo: jsonData.rotulo
            }
        }
    }

    excluirObjeto(indc) {
        this.json.objetos.splice(indc, 1);
    }

}

/* ****************************************************** */
/* Funções gerais utilizadas para alterações na instância */
/* ****************************************************** */

function configurarModal(idModal, idTituloModal, idSelectVolumes, objetoConfigurador) {
    // Salva id's do modal, titulo e lista de volumes para futuras utilizações
    objetoConfigurador.set('id_modal', idModal);
    objetoConfigurador.set('id_modal_titulo', idTituloModal);
    objetoConfigurador.set('id_lista_volumes', idSelectVolumes)

    // Adiciona um atributo para identificar se está em uma atualização ou adição
    $('#' + idModal).attr('vidrariaID', '-1');

    // Recupera o tipo de vidraria selecionada
    let idVidraria = $('#' + idSelectVidrarias).val();

    // Atualiza as informações existentes no modal
    popularLista(idVidraria);
    exibirCampos(idVidraria);
    objetoConfigurador.resetarFrasco();
    atualizarDadosFrasco();
    $('#' + idModal).modal('show');
}

function editarVidraria() {}

function excluirVidraria() {}

function popularLista(idVidraria) {
    $('.opcoes-vidraria').remove();
    // Preenche a lista de tamanhos dipsoníveis para cada vidraria
    let indc = configurador.get('vidrarias_identificador').indexOf(idVidraria);
    let volumes = configurador.get('volumes')[indc];
    for(let i = 0; i < volumes.length; i++) {
        $('#' + this.idSelectVolumes).append('<option value="' + volumes[i] + '" class="opcoes-vidraria">' + volumes[i] + '</option>');
    }
    // Altera o texto exibido no modal
    $('#tituloModalConf').text('Configurar ' + configurador.get('vidrarias')[indc]);
}

/* ****************************************************** */
/* Funções gerais utilizadas para alterações na instância */
/* ****************************************************** */