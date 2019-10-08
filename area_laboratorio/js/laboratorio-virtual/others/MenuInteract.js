/**
 * menu de iterração
 */
class MenuInteract {
    static clickInteracMenu(element) {
        var func = $(element).attr('data_funcion');
        try {
            eval('CLASS_INTERRACT_NOW.' + func + '();');
        } catch (e) {
            alert('função não existe na class!!!');
        }
    }

    static montModalInteracMenu(menu) {
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