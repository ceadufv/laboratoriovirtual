/**
 * menu de iterração
 */
class MenuInteract {
    static clickInteracMenu(element) {
        console.warn('MenuInteract.clickInteracMenu', 'MenuInteract');

        var func = $(element).attr('data_funcion');
        try {
            eval('CLASS_INTERRACT_NOW.' + func + '();');
            MenuInteract.closeInteracMenu();
        } catch (e) {
            alert(func+' | Função não existe na class | ocorreu um erro na função!!!');
            console.warn(func+' - função não existe na class!!!', 'MenuInteract');
        }
    }

    static closeInteracMenu() {
        console.warn('MenuInteract.closeInteracMenu', 'MenuInteract');
        $('#interacao').modal('hide');
    }

    static montModalInteracMenu(menu) {
        console.warn('MenuInteract.montModalInteracMenu', 'MenuInteract');
        console.warn(menu, 'MenuInteract');

        $('#interacao').modal();
        $('#interacao .modal-body *').remove();
        if (menu.length)
            for (var i = 0; i < menu.length; i++) {
                $('#interacao .modal-body').append(
                    '<button type="button" class="btn btn-primary btn-lg btn-block" ' +
                    'onClick="MenuInteract.clickInteracMenu(this);"' +
                    'data_funcion="' + menu[i].func + '" ' +
                    '>' + menu[i].text + '</button>'
                );
            }
        else {
            $('#interacao .modal-body').append('<p>Nenhuma ação disponível no momento</p>');
        }
    }
}