$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

function toggle(o) {
    // 
    var tr = $(o).parents('tr');
    var itens = tr.find('*[data-name]');
    var checked = $(o).prop('checked');

    // Desabilita os objetos irmaos do atual, pertencentes a mesma tr
    for (var i = 0; i < itens.length; i++) {
        if ($(itens[i]).attr('name') == $(o).attr('name'))
            continue;

        if ($(itens[i]).prop('tagName') == 'IMG') {
            //
            //$(itens[i]).removeClass('disabled');

            //
            //if (!checked) $(itens[i]).addClass('disabled');			
        } else
            $(itens[i]).prop('disabled', !checked);
    }
}

function load_pratica() {
    //
    $.ajax({
        url: '../area_laboratorio/data.php?action=pratica',
        data: {
            id_pratica: dados_pratica.id,
            id_disciplina: dados_pratica.id_disciplina
        }
    }).done(function (data) {

        $('.dadospratica').attr('data-id', data.id);
        $('#nome_aula').val(data.nome);
        $('#resumo_aula').val(data.resumo);

        dados_pratica = data;

        $('input[name="bancada"]').each(function () {
            $(this).prop('checked', $(this).val() == dados_pratica.id_cenario);
        });

        for (var i in dados_pratica.data) {
            carregaCampo(i, dados_pratica.data[i]);
        }
    });
}

function indice_idsolucao_estoque(n) {

    for (var i = 0; i < solucoes_estoque.length; i++) {
        if (solucoes_estoque[i].id == n) return i;
    }
    return -1;

}


var solucoes_estoque = [{
    "id": 1,
    "nome": "Sol. Estoque Ácida",
    "descricao": "Solução ácida utilizada como um modelo de solução",
    "tecnico": "Técnico CEAD",
    "intervalo": "3",
    "composicao": [{
        "id": "1",
        "nome": "Ácido Forte",
        "concentracao": "1"
    }],
    "estoque": true,
    "disponiveis": 5
},
{
    "id": 2,
    "nome": "Sol. Estoque Básica",
    "descricao": "Solução básica utilizada como um modelo de solução",
    "tecnico": "Técnico CEAD",
    "intervalo": "4",
    "composicao": [{
        "id": "2",
        "nome": "Base Forte",
        "concentracao": "1"
    }],
    "estoque": true,
    "disponiveis": 5
},
{
    "id": 3,
    "nome": "Sol. Branco p/ Espectrofotômetro",
    "descricao": "Solução utilizada como branco para medição no espectrofotômetro",
    "tecnico": "Técnico CEAD",
    "intervalo": "1",
    "composicao": [{
        "id": "102",
        "nome": "Branco",
        "concentracao": "0.0005"
    }],
    "estoque": true,
    "disponiveis": 5
}

];

function carregaCampo(campo, valor) {
    var obj = $('*[name="' + campo + '"]');

    if (campo == 'solucoes') {

        valor = solucoes_estoque.concat(valor);

        for (var i = 0; i < valor.length; i++) {
            $('#select_solucoes').append(
                '<option value="' + valor[i].id + '">' +
                valor[i].nome +
                '</option>'
            );
        }
    } else if (campo == 'armario_solucoes') {
        //console.log(valor)
        var conjunto = [];
        for (var i = 0; i < valor.length; i++) {
            console.log(valor[i].id, valor[i].nome)

            var novalinha = "<tr class=" + valor[i].id;
            novalinha += "><td class='id_solucoes_pratica' data-id=" + valor[i].id;
            novalinha += ">" + valor[i].nome + "</td><td>";
            novalinha += "<button onclick='deletar_linha(this, atualizar_armario)' class='btn vermelho'>Excluir </button>";
            novalinha += "</td></tr>";

            var linha = novalinha;
            conjunto.push(linha)
        }

        //console.log(conjunto)
        $("#lista_solucoes_pratica").append(conjunto)

    } else if (campo == 'armario_vidrarias') {
        for (var i in valor) {
            campos_armario(i, valor[i]);
        }
    }
    //
    else
        campos_armario(campo, valor);

}

function campos_armario(campo, valor) {

    var obj = $('*[name="' + campo + '"]');
    if ($(obj).attr('type') == 'radio') {
        $(obj).each(function () {
            var check = ($(this).val() == valor);
            $(this).prop('checked', check);
        });
    }

    //
    else
        if ($(obj).attr('type') == 'checkbox') {

            $(obj).each(function () {
                var existe = false;
                for (var i = 0; i < valor.length; i++) {
                    if (valor[i].volume == $(this).val()) {
                        var tr = $(this).parents('tr');

                        for (var j in valor[i]) {

                            if (j == 'id') continue;
                            if (j == 'volume') continue;

                            tr.find('*[data-name="' + j + '"]').val(valor[i][j]);
                        }

                        existe = true;
                        break;
                    }
                }

                //
                $(this).click();
                //
                if ($(this).prop('checked') != existe) {
                    $(this).click();
                }
            })
        }

        // 
        else {
            obj.val(valor);
        }
}

function adicionar_solucao_armario() {
    var nome = $("#select_solucoes option:selected").text();
    console.log('nome add', nome)
    var id_solucao = $("#select_solucoes option:selected").val();
    console.log('id add', id_solucao)

    if (!id_solucao) return false;

    // Nao permite que uma mesm solucao
    // seja adicionada ao armario mais de uma vez
    if ($('.id_solucoes_pratica[data-id="' + id_solucao + '"]').length) return;

    //
    var novalinha = "<tr class=" + id_solucao;
    novalinha += "><td class='id_solucoes_pratica' data-id=" + id_solucao;
    novalinha += ">" + nome + "</td><td>";
    novalinha += "<button onclick='deletar_linha(this, atualizar_armario)' class='btn vermelho'>Excluir </button>";
    novalinha += "</td></tr>";

    $("#lista_solucoes_pratica").append(novalinha);

    atualizar_armario();
};


function atualizar_armario() {
    dados_pratica.data.armario = [];

    $('.id_solucoes_pratica').each(function () {
        var nome = $(this).text();
        var id_solucao = parseInt($(this).attr('data-id'));

        console.log('id', id_solucao)

        var dados = [];

        if (id_solucao > 100) {
            dados.push(dados_pratica.data.solucoes[indice_idsolucao(id_solucao)]);
        } else {
            dados.push(solucoes_estoque[indice_idsolucao_estoque(id_solucao)]);
        }

        console.log('dados', dados)

        var descricao_solucao = dados[0].descricao;
        var tecnico_solucao = dados[0].tecnico;
        var intervalo_solucao = dados[0].intervalo;
        var composicao_solucao = dados[0].composicao;
        var disponiveis_solucao = 5;

        dados_pratica.data.armario.push({
            id: id_solucao,
            nome: nome,
            descricao: descricao_solucao,
            tecnico: tecnico_solucao,
            intervalo: intervalo_solucao,
            disponiveis: disponiveis_solucao,
            composicao: composicao_solucao
        });
        //dados_pratica.data.armario.push({ id:id_solucao, nome:nome });
    });

}

function listar_composicao() {
    var composicao = [];
    $('.linha_composicao').each(function () {
        composicao.push({
            id: $(this).attr('data-id'),
            nome: $(this).attr('data-nome'),
            concentracao: $(this).attr('data-value')
        })
    });
    return composicao;
}

function proximo_id_solucao() {
    var result = 100;
    for (var i = 0; i < dados_pratica.data.solucoes.length; i++) {
        if (!dados_pratica.data.solucoes[i]) continue;

        console.log(i, dados_pratica.data.solucoes[i])

        if (dados_pratica.data.solucoes[i]) result = dados_pratica.data.solucoes[i].id;
    }

    return result + 1;
}

function indice_idsolucao(n) {

    for (var i = 0; i < dados_pratica.data.solucoes.length; i++) {
        if (dados_pratica.data.solucoes[i].id == n) return i;
    }
    return -1;

}


function concluir_criar_solucao() {

    var composicao = listar_composicao();

    $('#modal_solucao').modal('hide');

    var id_solucao = parseInt($('#modal_solucao').attr('data-id'));

    var form_nome_solucao = $('#nome_solucao').val();
    var form_descricao = $('#descricao_solucao').val();
    var form_tecnico = $('#nome_tecnico').val();
    var form_intervalo = $('#data_de_criacao').val();

    if (id_solucao == -1) {
        id_solucao = proximo_id_solucao();

        dados_pratica.data.solucoes.push({
            id: id_solucao,
            nome: form_nome_solucao,
            descricao: form_descricao,
            tecnico: form_tecnico,
            intervalo: form_intervalo,
            composicao: composicao
        });

        $('#select_solucoes').append('<option value="' + id_solucao + '">' + dados_pratica.data.solucoes[indice_idsolucao(id_solucao)].nome + '</option>')
    } else {
        dados_pratica.data.solucoes[indice_idsolucao(id_solucao)] = {
            id: id_solucao,
            nome: form_nome_solucao,
            descricao: form_descricao,
            tecnico: form_tecnico,
            intervalo: form_intervalo,
            composicao: composicao
        };

        $('#select_solucoes option[value="' + id_solucao + '"]').text(form_nome_solucao);

    }

}


function deletar_linha(obj) {
    var args = arguments;
    $(obj).parents('tr').remove();

    console.log(args)

    if (args.length > 1) args[1](obj);
}

function adicionar_especie() {
    var composicao = listar_composicao();

    var atual = {
        id: $('#especies_disponiveis').val(),
        nome: $('#especies_disponiveis option:selected').text(),
        concentracao: $('#especies_concentracao').val(),
    };

    for (var i = 0; i < composicao.length; i++) {
        if (composicao[i].id == atual.id) return false;
    }

    adicionar_especie_lista(atual);
};

function adicionar_especie_lista(dado) {
    var novalinha = "<tr class=\"linha_composicao\" data-id=\"" + dado.id + "\" data-nome=\"" + dado.nome + "\" data-value=\"" + dado.concentracao + "\"><td class='nomes_composicao'>" + dado.nome + "</td><td class='conc_lista_solucao'>" + dado.concentracao + "</td><td> mol/L</td><td><button class='btn vermelho' onclick='deletar_linha(this)'>Excluir </button></td></tr>";

    $("#especies_na_solucao").append(novalinha);
}

function criar_solucao() {

    // Limpar a tela
    $('#nome_solucao').val('')
    $('#descricao_solucao').val('')
    $('#nome_tecnico').val('')
    $('#data_de_criacao').val('')

    $('.linha_composicao').remove();

}

var counter = 0;

function editar_solucao(novo) {

    var id_solucao = parseInt($('#select_solucoes').val());

    if (!novo && !id_solucao) return false;

    // Criar
    if (novo) {
        //
        $('#modal_solucao').attr('data-id', -1);
        criar_solucao();
    }
    // Editar
    else {

        if (id_solucao < 100) return false

        $('#modal_solucao').attr('data-id', id_solucao);

        //var id_solucao = $('#select_solucoes').val();
        var dados = dados_pratica.data.solucoes[indice_idsolucao(id_solucao)];

        $('#nome_solucao').val(dados.nome)
        $('#descricao_solucao').val(dados.descricao)
        $('#nome_tecnico').val(dados.tecnico)
        $('#data_de_criacao').val(dados.intervalo)

        $('.linha_composicao').remove();

        for (var i = 0; i < dados.composicao.length; i++) {
            adicionar_especie_lista(dados.composicao[i]);
        }

    }

    $('#modal_solucao').modal('show');
}

function salvar_pratica() {
    var data = generateDataForm();
    var id_pratica = $('.dadospratica').attr('data-id');
    var dataForm = {
        disponivel: $('#pratica-disponivel').prop('checked') ? 1 : 0,
        id: id_pratica,
        id_cenario: $('input[name="bancada"]:checked').val(),
        id_disciplina: dados_pratica.id_disciplina,
        nome: $('#nome_aula').val(),
        resumo: $('#resumo_aula').val(),
        data: JSON.stringify(data, null, "\t")
    };

    //debugs
    console.log(data);
    console.warn(dataForm);

    $.ajax({
        url: '../area_laboratorio/data.php?action=salvar_pratica',
        method: 'post',
        dataType: 'json',
        data: dataForm
    }).done(function (data) {
        if (data.success) {
            $('#fechar').click();
        }
        alert(data.msg);
    })
}

function generateDataForm() {
    var data = {};
    var fields = $('input,select:not([data-id])');
    var id = parseInt($('.dadospratica').attr('data-id', data.id));

    if (!dados_pratica.data) dados_pratica.data = {};

    data.solucoes = dados_pratica.data.solucoes;
    data.armario_solucoes = dados_pratica.data.armario;
    data.armario_vidrarias = {};

    for (var i = 0; i < fields.length; i++) {
        //
        var type = ($(fields[i]).attr('type') || $(fields[i]).prop('tagName')).toLowerCase();
        var name = $(fields[i]).attr('name');
        var armario_vidrarias = ($(fields[i]).attr('data-armario') == 'vidrarias');

        // 
        switch (type) {
            case "select":
                if (name) {
                    if (armario_vidrarias)
                        data.armario_vidrarias[name] = $(fields[i]).val();
                    else
                        data[name] = $(fields[i]).val();
                }
                break;
            case "radio":
                if (data[name] == undefined) {
                    var value = $('input[name="' + name + '"]:checked').val();
                    data[name] = value;
                }
                break;
            case "checkbox":
                var node = fields[i];

                if (name && $(node).prop('checked')) {

                    var inicio = name.split('-')[0];

                    var parent = $(node).parents('tr');

                    var d;
                    if (!armario_vidrarias) {
                        if (!data[inicio]) data[inicio] = [];
                        d = data[inicio];
                    } else {
                        if (!data.armario_vidrarias[inicio]) data.armario_vidrarias[inicio] = [];
                        d = data.armario_vidrarias[inicio];
                    }

                    var vol = name.split('-').pop();
                    dvol = {};

                    $(parent).find('input,select').each(function () {
                        var n = $(this).attr('data-name');
                        if (n != 'disponiveis')
                            dvol[n] = $(this).val();
                        else
                            dvol[n] = parseInt($(this).val());
                    });

                    dvol['id'] = counter + 200;
                    counter++;

                    if (armario_vidrarias) {
                        if (!data.armario_vidrarias[inicio])
                            data.armario_vidrarias[inicio] = [];

                        data.armario_vidrarias[inicio].push(dvol);
                    } else
                        data[inicio].push(dvol);
                }
                break;
            default:

                break;
        }
    }
    return validarDados(data);
}

function validarDados(data) {
    if (is_empty(data.armario_solucoes))
        data.armario_solucoes = [];

    if (is_empty(data.solucoes))
        data.solucoes = [];

    if (is_empty(data.armario_vidrarias.balao))
        data.armario_vidrarias.balao = [];

    if (is_empty(data.armario_vidrarias.pipeta))
        data.armario_vidrarias.pipeta = [];


    if (is_empty(data.armario_vidrarias.balao))
        data.armario_vidrarias.balao = [];

    if (is_empty(data.armario_vidrarias.bequer))
        data.armario_vidrarias.bequer = [];
    if (is_empty(data.armario_vidrarias.pipeta))
        data.armario_vidrarias.pipeta = [];
    if (is_empty(data.armario_vidrarias.cubeta))
        data.armario_vidrarias.cubeta = [];
    if (is_empty(data.armario_vidrarias.pipetador))
        data.armario_vidrarias.pipetador = [];
    if (is_empty(data.armario_vidrarias.micropipeta))
        data.armario_vidrarias.micropipeta = [];

    return data;
}

function deletar_pratica(id_pratica) {
    console.error('Ainda não implementado!!!');
}

function is_empty(data) {
    if (data == undefined || !data || data == '')
        return true;

    return false;
}