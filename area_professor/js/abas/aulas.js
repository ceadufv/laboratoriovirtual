$('.deletar-pratica').click(function () {
    var id_modelo_pratica = $(this).attr('id_modelo_pratica');
    bootbox.confirm({
        message: "Tem certeza que deseja deletar está prática?",
        buttons: {
            confirm: {
                label: 'Sim',
                className: 'btn-success'
            },
            cancel: {
                label: 'Não',
                className: 'btn-danger'
            }
        },
        callback: function (result) {

            if (!result)
                return;
            $.ajax({
                type: "POST",
                url: URL_SITE + 'area_professor/index-app.php?app=pratica&file=delete-pratica',
                data: { 'id_modelo_pratica': id_modelo_pratica},
                success: function (data) {
                    var data = JSON.parse(data);
                    bootbox.alert(data.msg, function(){
                        window.location.reload();
                    });
                }
            });

        }
    });
});