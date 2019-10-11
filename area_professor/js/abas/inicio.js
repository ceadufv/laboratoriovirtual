$(document).ready(function () {
    $(".removerDisciplina").click(function() {
        var id_disciplina = $(this).attr('id_disciplina');
        var msg = 'Tem certeza que deseja remover essa disciplina?';
        bootbox.confirm({
            message: msg,
            callback: function (result) {
                if(!result)
                    return;
                $.ajax({
                    type: "POST",
                    url: URL_SITE+'area_professor/index-app.php?app=disciplina&file=delete-disciplina',
                    data: {"id_disciplina": id_disciplina},
                    success: function(data) {
                        bootbox.alert('Removido com sucesso', function(){
                            window.location.href = URL_SITE+'area_professor/index.php?aba=inicio';
                        });
                    }
                });
            },
            error: function(erro) {},
        });
    });
    
    //data table
    $.extend( true, $.fn.dataTable.defaults, {
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
        //dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
                
        "language": {
            "url": URL_SITE+"plugins/vendor/datatables/Portuguese-Brasil.json"
        },

        extend: 'colvis',
        postfixButtons: [ 'colvisRestore' ]
    });

    $('.table-data')
    .removeClass( 'display' )
    .addClass('table table-striped table-bordered');        
});