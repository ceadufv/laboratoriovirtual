var jogo;

function exibirMenu(interacao) {
    var menu = interacao.menu();

    var source = interacao.source().data('uid');
    var target = interacao.target().data('uid');

    $('#interacao').modal();

    $('#interacao .modal-body *').remove();

    if (menu.length)
        for (var i = 0; i < menu.length; i++) {
            $('#interacao .modal-body').append(
                '<button type="button" class="btn btn-primary btn-lg btn-block btn-action" ' +
                'data-action-id="' + menu[i].data().id + '" ' +
                'data-source-id="' + source + '" ' +
                'data-target-id="' + target + '" ' +
                '>' + menu[i].data().text + '</button>'
            );
        }
    else {
        $('#interacao .modal-body').append('<p>Nenhuma ação disponível no momento</p>');
    }
}

// Executa a acao de um botao clicado dentro do modal que
// lista as interacoes possiveis
$('.modal-body')
    ///.not('modal-espectrofotometro')
    .on('click', '.btn-action', function () {
        //console.log($(this).attr('name'));

        // Executa uma acao envolvendo dois objetos

        var idAction = $(this).attr('data-action-id');

        var idSource = parseInt($(this).attr('data-source-id'));
        var idTarget = parseInt($(this).attr('data-target-id'));

        var action = LabAction.get(idAction);

        var interaction = action.interaction(idSource, idTarget);

        var error = interaction.errors();

        // Se nao ocorreu nenhum erro, executa a acao
        if (!error) {
            interaction.execute();
            $('#interacao').modal('hide');
        }
        // Se houver erro, nao executa a acao e exibe o erro para o usuario
        else {
            $('#interacao .modal-body .alert-danger').remove();
            $('#interacao .modal-body').append('<div class="alert alert-danger" role="danger">' + error + '</div>');
        }
    });

function construir_data(composicao) {
    var data = [];

    for (var i = 0; i < composicao.length; i++) {
        data.push({
            "data": [
                {
                    "substancias": [
                        {
                            "id": parseInt(composicao[i].id),
                            "concentracao": parseInt(composicao[i].concentracao),
                            "volume": 1000
                        }
                    ]
                }
            ]
        });
    }

    return data;
}

function construir_tab(tab, s) {

    //console.warn(s);

    // Se alguma vidraria não estiver disponível, nao aparece na tela
    if (s.disponiveis == 0) return;

    // Se for cubeta, no armário ela aparece maior (exceção)
    if (s.conceito == 'cubeta') {
        $('#tab_' + tab + ' .caixas')
            .append(
                '<label class="opcao" data-id="' + s.id + '">' +
                '<input type="checkbox" style="display:none" value="' + s.id + '" />' +
                '<p>' + s.nome + '</p>' +
                '<img src="assets/cubeta-armario.png" height="120px">' +
                '<button data-id="' + s.id + '" type="button" class="btn btn-dark m-3 botao btn-armario-pegar" >' +
                'Selecionar</button>' +
                '</label>'
            );
    } else {
        $('#tab_' + tab + ' .caixas')
            .append(
                '<label class="opcao" data-id="' + s.id + '">' +
                '<input type="checkbox" style="display:none" value="' + s.id + '" />' +
                '<p>' + s.nome + '</p>' +
                '<img src="assets/' + s.conceito + '.png" height="120px">' +
                '<button data-id="' + s.id + '" type="button" class="btn btn-dark m-3 botao btn-armario-pegar" >' +
                'Selecionar</button>' +
                '</label>'
            );
    }
}

function construir_vidraria(conceito, nome, s) {

    //console.log(']]]', conceito, nome, s)

    if (!s.id) s.id = 0;
    if (!s.conceito) s.conceito = conceito

    // Ajusta o nome que aparece no armario
    if (s.conceito == 'cubeta') {
        //s.nome = s.volume;
        s.nome = s.nome;
        s._data = { limpo: true, volumeMaximo: 3 };
    }
    else if (s.conceito == 'pipetador') {
        s.nome = nome;
    }
    else if (s.conceito == 'micropipeta') {
        s.nome = nome + ' ' + s.nome;
        //Diz se a vidraria nasce limpa ou suja
        s._data = { limpo: true, volumeMaximo: parseInt(s.volume) };
    }
    else {
        s.nome = nome + ' ' + s.volume + ' ' + 'mL';
        //Diz se a vidraria nasce limpa ou suja
        s._data = { limpo: true, volumeMaximo: parseInt(s.volume) };
    }

    //Adicionar sprite na tela
    construir_tab('vidrarias', s)

    return s;
}

function construir_solucao(conceito, s) {


    if (!s.id) s.id = 0;
    if (!s.nome) s.nome = '';
    if (!s.conceito) s.conceito = conceito;

    //Adicionar sprite na tela
    construir_tab('solucoes', s);

    // Ajusta a composicao de acordo leitura do laboratorio
    s.data = construir_data(s.composicao)

    //Adiciona volume máximo
    s._data = { volumeMaximo: 1000 };

    return s;
}


$.ajax({ url: URL_SITE + 'area_laboratorio/data.php?action=pratica_jogo&id_pratica=' + id_pratica }).done(function (data) {

    var titulo = data.nome;
    if (tipo_acesso == 'treino')
        titulo += ' (treinamento)';

    $('#tituloPratica').text(titulo);

    //console.error('Data Init',data.id_disciplina);

    jogo = new LabJogo(data);
    jogo.init(function (o) {

        var armario = o.armario();
        console.error(data.data);
        console.log('data', data.data)

        var dataArmario = [];

        var dados_armario_solucoes = data.data.armario_solucoes;
        var dados_armario_vidrarias = data.data.armario_vidrarias;

        var dados_balao = data.data.armario_vidrarias.balao;
        var dados_bequer = data.data.armario_vidrarias.bequer;
        var dados_pipeta = data.data.armario_vidrarias.pipeta;
        var dados_cubeta = data.data.armario_vidrarias.cubeta;
        var dados_pipetador = data.data.armario_vidrarias.pipetador;
        var dados_micropipeta = data.data.armario_vidrarias.micropipeta;

        for (var i = 0; i < dados_balao.length; i++)
            dataArmario.push(construir_vidraria('balao', 'Balão', dados_balao[i]));

        for (var i = 0; i < dados_bequer.length; i++)
            dataArmario.push(construir_vidraria('bequer', 'Béquer', dados_bequer[i]));

        for (var i = 0; i < dados_pipeta.length; i++)
            dataArmario.push(construir_vidraria('pipeta', 'Pipeta', dados_pipeta[i]));

        for (var i = 0; i < dados_cubeta.length; i++)
            dataArmario.push(construir_vidraria('cubeta', 'Cubeta', dados_cubeta[i]));

        for (var i = 0; i < dados_micropipeta.length; i++)
            dataArmario.push(construir_vidraria('micropipeta', 'Micropipeta', dados_micropipeta[i]));

        for (var i = 0; i < dados_pipetador.length; i++)
            dataArmario.push(construir_vidraria('pipetador', 'Pipetador', dados_pipetador[i]));

        for (var i = 0; i < dados_armario_solucoes.length; i++)
            dataArmario.push(construir_solucao('frasco_estoque', dados_armario_solucoes[i]));

        for (var i = 0; i < dataArmario.length; i++) {
            //dataArmario[i].disponiveis = 5;
            if (!dataArmario[i].data) dataArmario[i].data = {};
        }

        //
        armario.data(dataArmario);
    });
});



// // Cria a acao do botao do armario
// $('#armario').on('click', '.btn-armario-pegar', function () {
//     var id = parseInt( $(this).attr('data-id') );
//     jogo.armario().pegar(id);
//     $('#armario').modal('hide');
// });

function limparSelecaoArmario() {
    $('button[data-id]').each(function () {
        if ($(this).attr('data-marcado') == 'true') {
            $(this).click();
        }
    });

    $('.armario-lotado').hide();
    $('.armario-contador').text('0 selecionados');
}

function abrirArmario(a) {
    // Limpa a selecao atual nos armarios, para comodidade do usuario
    limparSelecaoArmario();

    switch (a) {
        case "armario_solucoes":
            $('#solucoes-tab').tab('show');
            break;
        case "armario_vidrarias":
            $('#vidrarias-tab').tab('show');
            break;
    }

    // Atualiza a indicacao na GUI de que nao ha nada selecionado no momento
    armarioAtualizarSelecionados(0);

    $('#armario').modal('show');
}

function armarioContarSelecionados() {
    return $('#armario button[data-marcado="true"]').length;
}

function armarioSelecionados() {
    var result = [];

    $('#armario button[data-marcado="true"]').each(function () {
        result.push($(this).attr('data-id'));
    });

    return result;
}

function armarioAtualizarSelecionados(counter) {
    var livres = LabUtils.lugaresLivres('bancada');

    // Atualiza a indicacao de espacos disponiveis
    var disponiveis = ((livres) ? livres.length : 0) - counter;
    $('.armario-disponiveis').text(
        '(' +
        disponiveis + ' lugar' +
        ((disponiveis == 1) ? '' : 'es') +
        ' restante' +
        ((disponiveis == 1) ? '' : 's') +
        ')'
    );

    // Atualiza a indicacao de objetos selecionados
    var txt = counter + ' ';
    if (counter == 1)
        txt += 'selecionado';
    else
        txt += 'selecionados';

    $('.armario-contador').text(txt);
}

$('#armario').on('click', '.btn-armario-pegar', function () {
    var livres = LabUtils.lugaresLivres('bancada');
    var disponiveis = (livres) ? livres.length : 0;

    var id = parseInt($(this).attr('data-id'));

    // Muda o estado da marcacao do item atual
    var acao = ($(this).attr('data-marcado') == 'true') ? 'remocao' : 'adicao';
    var adicionando = (acao == 'adicao') ? true : false;

    // Se esta tentando acrescentar algo novo,
    // verifica se havera espaco para isso na bancada
    if (acao == 'adicao') {
        if (armarioContarSelecionados() + 1 > disponiveis) {
            $('.armario-lotado').show();
            return;
        }
    } else {
        $('.armario-lotado').hide();
    }

    //
    $(this).attr('data-marcado', adicionando);

    //
    if (adicionando) {
        $('button[data-id="' + id + '"]').parent().addClass('objetoselecionado');
        $(this).removeClass('btn').addClass('btn verde');
    } else {
        $('button[data-id="' + id + '"]').parent().removeClass('objetoselecionado');
        $(this).removeClass('btn verde').addClass('btn');
    }

    var selecionados = armarioSelecionados();

    // Atualiza na tela o numero de objetos selecionados
    armarioAtualizarSelecionados(selecionados.length);
    //console.log(id)
    //$(this).parent();
    /*
        var selecionados = $('.opcao > :checkbox:checked').parent();
        var checkbox = $('.opcao > :checkbox:checked');
        for (i=0; i<selecionados.length; i++){
            var id = parseInt( $(selecionados[i]).attr('data-id') );
            jogo.armario().pegar(id);
        $(checkbox[i]).trigger('click');
        }
        $('#armario').modal('hide');
    */
});

// Adiciona a bancada os objetos selecionados
$('.btn-armario-adicionar').click(function () {

    var selecionados = armarioSelecionados();

    for (var i = 0; i < selecionados.length; i++) {
        jogo.armario().pegar(selecionados[i]);
    }

    $('#armario').modal('hide');
});

/*
if(this.checked){
  $(this).parent().css('border',' 2px solid #000');
  this.checked=true;
} else {
  $(this).parent().css('border',' 0px solid #000');
  this.checked=false;
};

var descricao = $(this).parent().attr('data-descricao');
$('.rotulo p').text(descricao);
*/


/*
var dados_armario_old = {
    "armario": [
        {
            "id": 38,
            "nome": "Solu\u00e7\u00e3o de \u00e1cido clor\u00eddrico 0,1 mol\/L",
            "conceito": "frasco_estoque",
            "descricao": "Solu\u00e7\u00e3o de \u00e1cido clor\u00eddrico 0,1 mol\/L",
            "tecnico": "T\u00e9cnico CEAD",
            "intervalo": 4,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 1,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 3,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 2,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 4,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 6,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 5,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 7,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 39,
            "nome": "Solu\u00e7\u00e3o de cloreto de am\u00f4nio 0,1 mol\/L",
            "conceito": "frasco_estoque",
            "descricao": "Solu\u00e7\u00e3o de cloreto de am\u00f4nio 0,1 mol\/L",
            "tecnico": "T\u00e9cnico CEAD",
            "intervalo": 5,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 3,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 1,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 3,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 2,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 4,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 46,
            "nome": "Solu\u00e7\u00e3o teste de pH 12.96",
            "conceito": "frasco_estoque",
            "descricao": "Solu\u00e7\u00e3o pH 12.96",
            "tecnico": "Pedro Sacramento",
            "intervalo": 1,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 10,
                                    "concentracao": 0.01,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 1,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 3,
                                    "concentracao": 0.01,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 2,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 47,
            "nome": "Teste",
            "conceito": "frasco_estoque",
            "descricao": "Solu\u00e7\u00e3o Teste",
            "tecnico": "T\u00e9cnico da CEAD + Freire",
            "intervalo": 5,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 77,
                                    "concentracao": 2,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 91,
                                    "concentracao": 2,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 48,
            "nome": "Tampao acido ac\u00e9tico ",
            "conceito": "frasco_estoque",
            "descricao": "",
            "tecnico": "T\u00e9cnico da CEAD",
            "intervalo": 1,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 1,
                                    "concentracao": 0.02,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 3,
                                    "concentracao": 0.04,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 49,
            "nome": "Tampao acido ac\u00e9tico ",
            "conceito": "frasco_estoque",
            "descricao": "",
            "tecnico": "T\u00e9cnico da CEAD",
            "intervalo": 1,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 1,
                                    "concentracao": 0.02,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 3,
                                    "concentracao": 0.04,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 50,
            "nome": "ABc",
            "conceito": "frasco_estoque",
            "descricao": "Def",
            "tecnico": "T\u00e9cnico da CEAD",
            "intervalo": 2,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 1,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 3,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 51,
            "nome": "",
            "conceito": "frasco_estoque",
            "descricao": "",
            "tecnico": "T\u00e9cnico da CEAD",
            "intervalo": 2,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 1,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 8,
                                    "concentracao": 0.12,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 52,
            "nome": "Solu\u00e7\u00e3o pH 12.96",
            "conceito": "frasco_estoque",
            "descricao": "Solu\u00e7\u00e3o pH 12.96",
            "tecnico": "admin",
            "intervalo": 0,
            "disponiveis": 5,
            "data": [
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 10,
                                    "concentracao": 0.01,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 1,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 3,
                                    "concentracao": 0.01,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                },
                {
                    "data": [
                        {
                            "substancias": [
                                {
                                    "id": 2,
                                    "concentracao": 0.1,
                                    "volume": 1000
                                }
                            ]
                        }
                    ]
                }
            ],
            "_data": {
                "volumeMaximo": 1000
            }
        },
        {
            "id": 53,
            "nome": "Cubeta",
            "conceito": "cubeta",
            "descricao": "Cubeta",
            "disponiveis": 5,
            "data": [],
            "_data": {
                "sujo": true,
                "volumeMaximo": 3.5
            }
        },
        {
            "id": 54,
            "nome": "B\u00e9quer 5ml",
            "conceito": "bequer",
            "descricao": "B\u00e9quer",
            "disponiveis": 5,
            "data": [],
            "_data": {
                "limpo": true,
                "volumeMaximo": 5
            }
        },
        {
            "id": 55,
            "nome": "B\u00e9quer 10ml",
            "conceito": "bequer",
            "descricao": "B\u00e9quer",
            "disponiveis": 5,
            "data": [],
            "_data": {
                "limpo": true,
                "volumeMaximo": 10
            }
        },
        {
            "id": 56,
            "nome": "B\u00e9quer 50ml",
            "conceito": "bequer",
            "descricao": "B\u00e9quer",
            "disponiveis": 5,
            "data": [],
            "_data": {
                "limpo": true,
                "volumeMaximo": 50
            }
        },
        {
            "id": 57,
            "nome": "B\u00e9quer 100ml",
            "conceito": "bequer",
            "descricao": "B\u00e9quer",
            "disponiveis": 5,
            "data": [],
            "_data": {
                "limpo": true,
                "volumeMaximo": 100
            }
        },
        {
            "id": 58,
            "nome": "B\u00e9quer 250ml",
            "conceito": "bequer",
            "descricao": "B\u00e9quer",
            "disponiveis": 5,
            "data": [],
            "_data": {
                "limpo": true,
                "volumeMaximo": 250
            }
        },
        {
            "id": 59,
            "nome": "Pipeta Volum\u00e9trica",
            "conceito": "pipeta",
            "descricao": "Pipeta volum\u00e9trica",
            "disponiveis": 5,
            "data": [],
            "_data": {
                "limpo": true,
                "volumeMaximo": 50
            }
        },
        {
            "id": 60,
            "nome": "Pipetador",
            "conceito": "pipetador",
            "descricao": "P\u00eara",
            "disponiveis": 5,
            "data": []
        }
    ]
};
*/