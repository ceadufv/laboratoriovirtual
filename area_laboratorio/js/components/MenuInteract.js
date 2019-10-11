/**
 * menu de iterração
 */
class MenuInteract {
    static clickInteracMenu(element) {
        console.log('MenuInteract.clickInteracMenu');
        MenuInteract.closeInteracMenu();
        var func = $(element).attr('data_funcion');
        try {
            eval('CLASS_INTERRACT_NOW.' + func + '();'); 
        } catch (e) {
            alert(func+' | Função não existe na class | ocorreu um erro na função!!!');
            console.warn(func+' - função não existe na class!!!');
            console.error('MenuInteract.clickInteracMenu',e);
        }
    }

    //retira todos modais da tela
    static hideAllModal() {
        console.log('MenuInteract.hideAllModal');
        $('#interacao-1').modal('hide');
        $('#interacao-2').modal('hide');
    }

    //retira modal 1
    static closeInteracMenu() {
        console.log('MenuInteract.closeInteracMenu');
        $('#interacao-1').modal('hide');
    }

    static montModalInteracMenu(menu) {
        console.warn(menu, 'MenuInteract.montModalInteracMenu');
        $('#interacao-1 .modal-body').html('');
        if (menu.length)
            for (var i = 0; i < menu.length; i++) {
                $('#interacao-1 .modal-body').append(
                    '<button type="button" class="btn btn-primary btn-lg btn-block" ' +
                    'onClick="MenuInteract.clickInteracMenu(this);"' +
                    'data_funcion="' + menu[i].func + '" ' +
                    '>' + menu[i].text + '</button>'
                );
            }
        else {
            $('#interacao-1 .modal-body').append('<p>Nenhuma ação disponível no momento</p>');
        }
        $('#interacao-1').modal();
    }

    static montModalInteracHTML(html) {
        console.log('MenuInteract.montModalInteracHTML', html);
        $('#interacao-2').modal('show');
        $('#interacao-2 .modal-body').html('');
        $('#interacao-2 .modal-body').append(html);
    }
}