class PracticeRegistration {

    //PracticeRegistration.saveWorld('teste', 'SAVE');
    static saveWorld(msg, type = "REGISTRO", elemt_resp=".resp-save-id") {
        var data = [{
            'desc': msg,
            'data': OBJETOS_LAB,
            'type': type,
            'elemt_resp': elemt_resp
        }];
        this.register(data);
    }
    static register(data) {
        /*
        var data = [{
            'desc': 'Lavou a ...',
            'data': [{}],
            'type': ''
        }];
        */
        if (!data) {
            return;
        }
        console.warn('PracticeRegistration', data);

        for (let i = 0; i < data.length; i++) {
            const item = data[i];
            
            var dados = [
                { 'name': 'desc', 'value': item.desc },
                { 'name': 'id_aluno', 'value': ID_USUARIO },
                { 'name': 'id_pratica', 'value': ID_PRATICA },
                { 'name': 'data', 'value': JSON.stringify(item) },
                { 'name': 'type', 'value': item.type }
            ];
            
            $.ajax({
                type: "post",
                url: URL_SITE + 'area_laboratorio/index-app.php?app=jogo&file=save-acao-aluno-pratica-jogo&id_pratica=' + ID_PRATICA,
                data: dados,
                success: function (response) {
                    if(item.type == 'SAVE')
                        CookieP.setCookie('id_save', response.id);

                    $(item.elemt_resp).text(response.id);
                    console.log('id: ' + response.id);
                }
            });
        }
    }
}