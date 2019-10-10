$('[data-toggle=confirmation]').click(function(){
    {
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
                alert('Ainda tem que implementar!!!');
            }
        });
    }
});