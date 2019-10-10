$(document).ready(function() {
    var url_site = URL_SITE;

    $(".reset_senha").click(function(dados) {
          var dados = new Array();
          dados.push({'value': $('#reset').attr('cod-usuario'), 'name': 'cod_usuario'});
          dados.push({'value': $('#reset').attr('nome-usuario'), 'name': 'nome_usuario'});
          confirmarResetSenhaAluno(dados);
    });


    function confirmarResetSenhaAluno(dados) {

        $.ajax({
            type: "POST",
            url: url_site+'area_professor/index.php?aba=alunos',
            data: dados,
            
            success: function(data) {
                var msg = 'Tem certeza que deseja resetar a senha desse aluno?';

                bootbox.confirm({
                    message: msg,
                    callback: function (result) {
                        if(dados){
                            if(result){
                                resetarSenhaAluno(dados);
                            } 
                        }
                    },
                    error: function(erro) {
                        alert('erro');
                    },
                });
            }
        });
    }

    function resetarSenhaAluno(dados) {
        dados.push({'value': 'S', 'name': 'confirmado'});

        $.ajax({
			method: "POST",
			url: url_site + 'area_professor/index.php?aba=alunos',
			data: dados
		})
		.done(function (dados) {
            alert('Senha alterada com sucesso para 123456');
			//$('.modal-content').html(dados);
		});
    }

/*
  //data table
  $.extend( true, $.fn.dataTable.defaults, {
    "searching": true,
    "ordering": true,
    "paging": true,
    "colReorder": true,
    "iDisplayLength": 25
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
            "url": url_site+"plugins/vendor/datatables/Portuguese-Brasil.json"
        },

        extend: 'colvis',
        postfixButtons: [ 'colvisRestore' ]
    });

    $('.table-data')
    .removeClass( 'display' )
    .addClass('table table-striped table-bordered');    
*/
});