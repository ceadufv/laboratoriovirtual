class PracticeRegistration{
    static register(data){
        /*
        var data = [{
            'desc': 'Lavou a ...',
            'data': [{}]
        }];
        */
        console.log(data);
        if(!data){
            console.log('PracticeRegistration');
            return;
        }


        for (let i = 0; i < data.length; i++) {
            const element = data[i];

            var dados = [
                {'name': 'desc', 'value': element.desc},
                {'name': 'id_aluno', 'value': 1},
                {'name': 'id_pratica', 'value': 1},
                {'name': 'data', 'value': JSON.stringify(data)}
            ];

            $.ajax({
                type: "post",
                url: URL_SITE + 'area_laboratorio/index-app.php?app=jogo&file=save-acao-aluno-pratica-jogo&id_pratica=' + ID_PRATICA,
                data: dados,
                success: function (response) {}
            });
        }
    }
}