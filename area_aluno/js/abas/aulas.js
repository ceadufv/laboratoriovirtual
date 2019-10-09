$(document).ready(function () {
    var url_site = URL_SITE;

    $(".salvar").click(function(dados) {
        acessar_laboratorio('salvar');
    });

    $(".treino").click(function(dados) {
        acessar_laboratorio('treino');

    });

    function acessar_laboratorio(tipo_acesso){
        //var id = $('#select_acessar_laboratorio option:selected').val();
        //var id = $('#id_pratica').attr('value');
        var id = $('#id_pratica').val();
        location.href="../area_laboratorio/lab.php?id_pratica="+id+'&tipo_acesso='+tipo_acesso;
    }


	//data table
	$.extend( true, $.fn.dataTable.defaults, {
		"searching": true,
		"ordering": true,
		"paging": true,
		"colReorder": true
		//"iDisplayLength": 50
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
});