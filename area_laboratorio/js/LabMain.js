var jogo;

function exibirMenu(interacao) {
    var menu = interacao.menu();

    var source = interacao.source().data('uid');
    var target = interacao.target().data('uid');

    $('#interacao').modal();

    $('#interacao .modal-body *').remove();

    if (menu.length)
        for (var i = 0 ; i < menu.length ; i++) {
            $('#interacao .modal-body').append(
                '<button type="button" class="btn btn-primary btn-lg btn-block btn-action" '+
                'data-action-id="'+menu[i].data().id+'" '+
                'data-source-id="'+source+'" '+
                'data-target-id="'+target+'" '+
                '>'+menu[i].data().text+'</button>'
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
        console.log($(this).attr('name'));

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
            $('#interacao .modal-body').append('<div class="alert alert-danger" role="danger">'+error+'</div>');
        }
    });

$.ajax({url:'data.php?action=pratica&id_pratica='+id_pratica}).done(function (data) {

    var titulo = data.nome;

    if (tipo_acesso == 'treino') titulo += ' (treinamento)';

    $('#tituloPratica').text(titulo);

    // 
    jogo = new LabJogo( data );

    //
    jogo.init(function (o) {

        var armario = o.armario();

        //
        armario.data(data.armario);
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

function abrirArmario(a){
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
    var disponiveis = ((livres)?livres.length:0) - counter;
    $('.armario-disponiveis').text(
        '('+
            disponiveis+' lugar'+
            ((disponiveis == 1)?'':'es')+
            ' restante'+
            ((disponiveis == 1)?'':'s')+
        ')'
    );

    // Atualiza a indicacao de objetos selecionados
    var txt = counter+' ';
    if (counter == 1)
        txt += 'selecionado';
    else
        txt += 'selecionados';

    $('.armario-contador').text(txt);
}

$('#armario').on('click', '.btn-armario-pegar', function () {
    var livres = LabUtils.lugaresLivres('bancada');
    var disponiveis = (livres)?livres.length:0;

    var id = parseInt($(this).attr('data-id'));

    // Muda o estado da marcacao do item atual
    var acao = ($(this).attr('data-marcado') == 'true')?'remocao':'adicao';
    var adicionando = (acao == 'adicao')?true:false;    

    // Se esta tentando acrescentar algo novo,
    // verifica se havera espaco para isso na bancada
    if (acao == 'adicao') {
        if (armarioContarSelecionados()+1 > disponiveis) {
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
        $('button[data-id="'+id+'"]').parent().addClass('objetoselecionado');
        $(this).removeClass('btn').addClass('btn verde');
    } else {
        $('button[data-id="'+id+'"]').parent().removeClass('objetoselecionado');
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

    console.log(selecionados)

    for (var i = 0 ; i < selecionados.length ; i++) {
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
