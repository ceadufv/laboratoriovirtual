// Função de inicialização
function init() {
    // Carrega dados do banco sobre substancias e vidrarias disponíveis
    configurador.carregarInformacoes('../banco/data.php');

    // Carrega a lista de práticas existentes
    atualizarListaPraticas();

    // Exibe as opções na tela
    let vidrarias = configurador.get('vidrarias');
    let identificador = configurador.get('vidrarias_identificador');
    // Preenche a lista de vidrarias disponíveis
    for (let i = 0; i < vidrarias.length; i++) {
        $('#listaNomes').append('<option value="' + identificador[i] + '">' + vidrarias[i] + '</option>');
    }
    // Preenche a lista com as substâncias cadastradas
    let substancias = configurador.get('substancias');
    for (let i = 0; i < substancias.length; i++) {
        $('#opcoesSubstancia').append('<option value="' + substancias[i] + '">' + substancias[i] + '</option>');
    }
}

// Função de Atualização de práticas
function atualizarListaPraticas() {

    // Preenche a lista de práticas modelo
    $.ajax({
        url: '../banco/data.php',
        type: 'POST',
        data: { acao: 'carregar_id_pratica' },
        dataType: 'json',
        success: function (res) {
            console.log(res)
            if (res.sucesso) {

                // Adiciona opcao de modelo vazio
                res.data.unshift({
                    id: 0,
                    nome: 'Modelo vazio'
                });
                $('.opcoes-praticas-modelo').remove();
                for (let i = 0; i < res.data.length; i++) {
                    $('.listaPraticasModelo').append('<option class="opcoes-praticas-modelo" value="' + res.data[i].id + '">' + res.data[i].nome + '</option>');
                }

                /*
                
                                $('.opcoes-praticas-modelo').remove();
                                for(let i = 0; i < res.data.length; i++) {
                                    $('.listaPraticasModelo').append('<option class="opcoes-praticas-modelo" value="' + res.data[i].id + '">' + res.data[i].nome + '</option>');
                                }
                */
            } else {
                alert('Ocorreu um problema de conexão com o banco de dados ao tentar atualizar as informações da página. Por favor, atualize a página e se o problema continuar, entre em contato para informar.');
            }
        },
        error: function (res) {
            console.log(res);
        }
    });
}

// Função de troca de telas
function aba(tela) {
    $('.opcoes').removeClass('ativo');
    $('.tab-' + tela).addClass('ativo');
    $('.div-secoes').hide();
    $('.div-secoes.div-' + tela).show();

    // Exibe modal, se houver
    if ($('.modal.div-' + tela).length) {
        $('.modal.div-' + tela).modal('show');
        $('.div-secoes').hide();
    }
}
/*
function exibir(tela) {
    if(tela === 'contato' || tela === 'conta' || tela === 'pratica-modelo') {
        $('.div-' + tela).modal('show');
    } else {
        $('.div-secoes').addClass('oculta');
        $('.div-' + tela).removeClass('oculta');
    }
}
*/

// Exibição de formulário para criação de prática
function formularioCriacao(modelo) {
    modelo = parseFloat(modelo);
    if (modelo === -1) {
        // Não carrega prática modelo, formulário vazios
    } else {
        // Carrega práticas modelo
        modelo = parseFloat($('.listaPraticasModelo').val());
    }

    $('.div-pratica-modelo').modal('hide');
    $('#div-formulario').removeClass('oculta'); // ????
    $('#div-formulario').addClass('visivel');
}

function formularioCriacaoUsuario() {
    $('.div-cadastrar-usuario').modal('show');
}


function formularioAcessarLaboratorio() {
    $('.div-pratica').modal('show');
}

function formularioCriacaoPratica() {
    consulta('carregar_id_pratica', function (res) {
        $('.div-pratica-modelo').modal('show');
    });
}

// Função de Atualização de práticas
function consulta(acao, f) {
    // Preenche a lista de práticas modelo
    $.ajax({
        url: '../banco/data.php',
        type: 'POST',
        data: { acao: acao },
        dataType: 'json',
        success: function (res) {
            if (res.sucesso) {
                f(res);
            } else {
                alert('Ocorreu um problema de conexão com o banco de dados ao tentar atualizar as informações da página. Por favor, atualize a página e se o problema continuar, entre em contato para informar.');
            }
        },
        error: function (res) {
            console.log(res);
        }
    });
}

// Abertura do modal de criação e edição de vidrarias
function criar() {
    $('#modalCriacao').attr('vidrariaID', '-1');
    // Recupera o tipo de vidraria selecionada
    let idVidraria = $('#listaNomes').val();
    popularLista(idVidraria);
    exibirCampos(idVidraria);
    configurador.resetarFrasco();
    atualizarDadosFrasco();
    $('#modalCriacao').modal('show');
}

// Preenchimento da lista com tamanhos de vidrarias e personalização do modal
function popularLista(idVidraria) {
    $('.opcoes-vidraria').remove();
    // Preenche a lista de tamanhos dipsoníveis para cada vidraria
    let indc = configurador.get('vidrarias_identificador').indexOf(idVidraria);
    let volumes = configurador.get('volumes')[indc];
    for (let i = 0; i < volumes.length; i++) {
        $('#opcoesTamanho').append('<option value="' + volumes[i] + '" class="opcoes-vidraria">' + volumes[i] + '</option>');
    }
    // Altera o texto exibido no modal
    $('#tituloModalConf').text('Configurar ' + configurador.get('vidrarias')[indc]);
}

// Mostra apenas os inputs necessários para a configuração do modal
function exibirCampos(tipo) {
    $('.formularioadd').removeClass('visivel');
    if (tipo === 'pipetador' || tipo === 'ponteira') {
        $('.vol').addClass('visivel');
    } else if (tipo === 'frasco_estoque') {
        $('.vol').addClass('visivel');
        $('.listainfo').addClass('visivel');
    } else if (tipo === 'micropipeta') {
        $('.vol').addClass('visivel');
        $('.dp').addClass('visivel');
    } else {
        $('.vol').addClass('visivel');
        $('.dp').addClass('visivel');
        $('.premax').addClass('visivel');
        $('.premin').addClass('visivel')
    }
}

// Atualiza a seção de informações do frasco, limpando a div para novas configurações de vidraria
function atualizarDadosFrasco() {
    $('.detalhes-substancias').remove();
    let dados = configurador.get('dados_temporarios_frasco');
    for (let i = 0; i < dados.listaDados.length; i++) {
        $('.opcoesadd').append('<div class="form-inline detalhes-substancias margem-sup"><div class="col-10">' + dados.listaDados[i][0] + ' (' + dados.listaDados[i][1].toString().replace('.', ',') + ' mol/L)</div><div class="col-2"><button class="btn btn-danger" onclick="removerDadosFrasco(' + i + ')"><i class="far fa-trash-alt"></i></button></div></div>');
    }
}

// Ação de confirmação do modal de criação/alteração de vidrarias e frascos
function confirmar() {
    let indcVidraria = parseFloat($('#modalCriacao').attr('vidrariaID'));
    // Recupera os dados
    let idVidraria = $('#listaNomes').val();
    let tamanho = $('#opcoesTamanho').val();
    let maximo = $('#maximo').val();
    let minimo = $('#minimo').val();
    let dp = $('#desvio').val();
    let rotulo = $('#rotulo').val();
    if (rotulo === '') rotulo = rotularGenerico(idVidraria);
    if (!prosseguirAdicao(idVidraria, maximo, minimo, dp)) {
        return;
    }

    if (indcVidraria === -1) {
        // Adiciona um novo objeto
        configurador.addObjeto({
            nome: idVidraria,
            tamanho: tamanho,
            rotulo: rotulo,
            minimo: minimo,
            maximo: maximo,
            dp: dp
        });
    } else {
        // Altera a configuração de um objeto
        configurador.atualizarObjeto({
            indice: indcVidraria,
            nome: idVidraria,
            tamanho: tamanho,
            rotulo: rotulo,
            minimo: minimo,
            maximo: maximo,
            dp: dp
        });
        $('#modalCriacao').attr('vidrariaID', '-1');
    }
    // Apaga os valores inseridos pelo usuário
    $('#maximo').val('');
    $('#minimo').val('');
    $('#desvio').val('');
    $('#rotulo').val('');
    // Fecha o modal e atualiza a lista de dados exibida ao usuário
    $('#modalCriacao').modal('hide');
    atualizarRegistros();
}

// Ação de cancelar do botão do modal de criação/edição de vidrarias
function cancelar() {
    $('#modalCriacao').attr('vidrariaID', '-1');
    configurador.resetarFrasco();
    // TODO: atualizar lista de existentes
    $('#modalCriacao').modal('hide');
}

// Função para adicionar dados em um frasco
function addDadosFrasco() {
    // Recupera valores da lista e input
    var subs = $('#opcoesSubstancia').val(), conc = $('.conc').val();
    if (conc === '') { alert('Informe um valor para concentração.'); return; }
    let indc = configurador.addSubsFrasco(subs, conc);
    atualizarDadosFrasco(indc);
    // Apaga o valor informado no input para nova informação
    $('.conc').val('');
}

// Função para remover uma substância durante a configuração de um frasco
function removerDadosFrasco(id) {
    configurador.removeSubsFrasco(id);
    atualizarDadosFrasco();
}

// Atualiza a lista com as substâncias presentes na configuração do frasco
function atualizarDadosFrasco() {
    $('.detalhes-substancias').remove();
    let dados = configurador.get('dados_temporarios_frasco');
    for (let i = 0; i < dados.listaDados.length; i++) {
        $('.opcoesadd').append('<div class="form-inline detalhes-substancias margem-sup"><div class="col-10">' + dados.listaDados[i][0] + ' (' + dados.listaDados[i][1].toString().replace('.', ',') + ' mol/L)</div><div class="col-2 text-right"><button class="btn btn-outline-danger btn-sm" onclick="removerDadosFrasco(' + i + ')"><i class="far fa-trash-alt"></i></button></div></div>');
    }
}

// Atualiza na tela a lista com os dados de vidrarias/frasco cadastrados
function atualizarRegistros() {
    let dataString = configurador.formatarDadosDeLeitura();
    $('.detalhes-vidrarias').remove();
    for (let i = 0; i < dataString.length; i++) {
        // Utiliza a posição na lista de ojetos do configurador como id
        $('#listaDados').append('<div class="form-inline detalhes-vidrarias margem-sup"><div class="col"><p>' + (i + 1) + ') ' + dataString[i] + '</p></div><div class="col-3 botoes"><button class="btn caixa-total" onclick="editarVidraria(' + i + ')"><i class="fas fa-edit"></i> Editar</button><button class="btn caixa-total" onclick="excluirVidraria(' + i + ')"><i class="far fa-trash-alt"></i> Excluir</button></div>');
    }
}

// Função para criar um rótulo genérico, caso o usuário não tenha rotulado a vidraria
function rotularGenerico(idVidraria) {
    let indc = configurador.get('vidrarias_identificador').indexOf(idVidraria);
    let tamanho = $('#opcoesTamanho').val()
    let rotulo = '';
    // Configura o rótulo genérico de um frasco estoque
    if (idVidraria === 'frasco_estoque') {
        rotulo = 'Frasco Estoque: ';
        let dados = configurador.get('dados_temporarios_frasco');
        for (let i = 0; i < dados.listaDados.length; i++) {
            rotulo += dados.listaDados[i][0] + '(' + dados.listaDados[i][1].toString().replace('.', ',') + ' mol/L), ';
        }
        rotulo += ' com ' + tamanho;
    } else {
        // Configura o rótulo genérico de uma vidraria geral
        rotulo = configurador.get('vidrarias')[indc] + ' de ' + tamanho;
    }
    return rotulo;
}

// Função para avaliar se todas as informações foram adicionadas pelo usuário
function prosseguirAdicao(idVidraria, maximo, minimo, dp) {
    if (idVidraria === 'pipetador' || idVidraria === 'ponteira') {
        // Controle de inserção de dados e trigem de erros para pipetador e ponteira
        return true;
    } else if (idVidraria === 'frasco_estoque') {
        // Controle de inserção de dados e trigem de erros para frasco estoque
        if (configurador.get('dados_temporarios_frasco').listaDados.length === 0) {
            return false;
        } else {
            return true;
        }
    } else if (idVidraria === 'micropipeta') {
        // Controle de inserção de dados e triagem de erros para micropipeta
        if (dp === '' || parseFloat(dp.replace(',', '.')) < 0) {
            alert('O Desvio padrão nao pode ser nulo ou negativo');
            return false;
        } else {
            return true;
        }
    } else {
        // Controle de inserção de dados para o caso de vidrarias em geral
        if (maximo === '' || minimo === '' || dp === '') {
            alert('Preencha todos os campos antes de salvar.');
            return false;
        } else {
            let pmax = parseFloat(maximo.replace(',', '.')), pmin = parseFloat(minimo.replace(',', '.')), desvio = parseFloat(dp.replace(',', '.'));

            if (pmax < pmin) {
                alert('O Preenchimento máximo não pode ser menor que o Preenchimento mínimo .');
                return false;
            } else {
                if (pmin < 0 || pmax <= 0 || dp < 0) {
                    alert('Os valores dos campos não podem ser nulos ou negativos.');
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
}

// Ação de edição de vidraria, existente na lista de objetos configurados
function editarVidraria(indc) {
    // Adiciona uma variável que faz a identificação de modal para atualização
    $('#modalCriacao').attr('vidrariaID', indc.toString());
    // Recupera valores
    let objetos = configurador.get('objetos_cadastrados');
    let idVidraria = objetos[indc].nome;
    popularLista(idVidraria);
    exibirCampos(idVidraria);
    $('#modalCriacao').modal('show');
    // Preenche os dados com as informações do objeto
    if (idVidraria !== 'pipetador' && idVidraria !== 'ponteira') {
        // Altera o volume da lista para micropipeta
        if (idVidraria === 'micropipeta') {
            $('#opcoesTamanho').val(objetos[indc].capacidadeMinima * 1000 + '-' + objetos[indc].capacidadeMaxima * 1000 + ' uL');
            $('#desvio').val(objetos[indc].desvioPadrao);
        } else if (idVidraria === 'frasco_estoque') {
            let dados = [];
            for (let i = 0; i < objetos[indc].substancias.length; i++) {
                dados.push([objetos[indc].substancias[i], objetos[indc].concentracoes[i].toString()]);
            }
            configurador.set('dados_temporarios_substancias', dados);
            atualizarDadosFrasco();
        } else {
            $('#opcoesTamanho').val(objetos[indc].capacidadeMaxima + ' mL');
            $('#maximo').val(objetos[indc].preenchimentoMaximo);
            $('#minimo').val(objetos[indc].preenchimentoMinimo);
            $('#desvio').val(objetos[indc].desvioPadrao);
        }
    }
    $('#rotulo').val(objetos[indc].rotulo);
}

// Ação do botão de exclusão de vidraria, presente na lista
function excluirVidraria(indcLista) {
    configurador.excluirObjeto(indcLista);
    atualizarRegistros();
}

$(".btn-acessar-pratica").on("click", function () {
    var id = parseInt($('.div-pratica .custom-select').val());
    if (id) {
        window.open('../area_laboratorio/index.php?id_pratica=' + id, '_blank');
        $('.div-pratica').modal('hide');
    } else {

    }
});

function logoff() {
    window.location.href = URL_SITE + 'logout.php';
};