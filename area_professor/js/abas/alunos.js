$(document).ready(function () {
    $('.valida_login').on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $(".reset_senha").click(function (dados) {
        var dados = new Array();
        dados.push({ 'value': $(this).attr('cod-usuario'), 'name': 'cod_usuario' });
        dados.push({ 'value': 'S', 'name': 'resetar' });
        bootbox.confirm({
            message: 'Tem certeza que deseja resetar a senha desse aluno?',
            callback: function (result) {
                if (!result)
                    return;

                $.ajax({
                    type: "POST",
                    url: URL_SITE + 'area_professor/index-app.php?app=usuario&file=reset-senha-aluno',
                    data: dados,
                    success: function (data) {
                        bootbox.alert('Senha alterada com sucesso para 123456');
                    }
                });
            },
            error: function (erro) {},
        });
    });

    $(".delete_user").click(function (dados) {
        var dados = new Array();
        dados.push({ 'value': $(this).attr('cod-usuario'), 'name': 'cod_usuario' });
        bootbox.confirm({
            message: 'Tem certeza que deseja deletar esse aluno?',
            callback: function (result) {
                if (!result)
                    return;
                $.ajax({
                    type: "POST",
                    url: URL_SITE + 'area_professor/index-app.php?app=usuario&file=delete-aluno',
                    data: dados,
                    success: function (data) {
                        bootbox.alert('Aluno deletado com sucesso!!', function(){
                            window.location.href = URL_SITE+'area_professor/index.php?aba=alunos';
                        });
                    }
                });
            },
            error: function (erro) {},
        });
    });

    //data table
    $.extend(true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": true,
        "paging": true,
        "colReorder": true,
        "iDisplayLength": 10
    });

    var exportOptions = {
        columns: [':visible'],
        format: { //para retirar spações e tahs htmls
            body: function (data, row, column, node) {
                // Strip $ from salary column to make it numeric
                var html = $.parseHTML(data);
                html = $(html).text();//stripHtmlTags(data);
                html = html.replace(/\s+/g, " ");
                return html.replace(/(\r\n|\n|\r)/gm, "");
            }
        }
    };

    var oTable = $('.table-data').dataTable({
        // dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",

        "language": {
            "url": URL_SITE + "plugins/vendor/datatables/Portuguese-Brasil.json"
        },

        extend: 'colvis',
        postfixButtons: ['colvisRestore']
    });

    $('.table-data').removeClass('display').addClass('table table-striped table-bordered');

    // fim data table
    function validaLogin(login) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;$
        return re.test(String(login).toLowerCase());
    }
});