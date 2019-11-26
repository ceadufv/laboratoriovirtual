class PractiveRestore {

    static clickRestore(id) {
        var id_save = CookieP.getCookie('id_save');
        if ($('.resp-save-id').text()) {
            id_save = $('.resp-save-id').text();
        }
        Laboratorio.pause();
        bootbox.prompt({
            title: "Dígite o ID",
            centerVertical: true,
            value: id_save,
            callback: function (result) {
                Laboratorio.resume();
                if (result) {
                    PractiveRestore.restoreDataRegister(result);
                }
            }
        });
    }
    //PractiveRestore.restoreDataRegister(12);
    static restoreDataRegister(id) {
        $.ajax({ url: URL_SITE + 'area_laboratorio/index-app.php?app=jogo&file=get-historico-usuario-pratica-jogo&id=' + id }).done(function (resp) {
            if (!resp.success || !resp.data)
                return;

            var data = JSON.parse(resp.data);
            console.warn(data);
            SceneObjectsSLab.destroyAll();
            PractiveRestore.restoreObjetcsPratica(data);
            DropZones.ckeckUsado();
            PRATICA_POPOVER.toFront();
        });
    }

    static restoreObjetcsPratica(data) {
        var dados = data.data;
        for (let i = 0; i < dados.length; i++) {
            let item = dados[i];
            item.restore = true; //se foi vindo de restauracao

            let item_sets = CloneObjectArray.objectCopy(item);
            let objCreate;

            //object merge
            item = CloneObjectArray.mergeObject(item, item.datadefault);

            if (item.gameobject != undefined) {
                item.x = item.gameobject.x;
                item.y = item.gameobject.y;
            }

            if (item.container != undefined) {
                item.x = item.container.x;
                item.y = item.container.y;
            }

            delete item.gameobject;
            delete item.container;
            delete item.datadefault;
            delete item.graphics;
            if (item.conceito == undefined) {
                item.conceito = item.concept;
            }

            console.warn('item', item);
            objCreate = ConceptCreate.criar(item.conceito, item);

            //setando novas datas
            delete item_sets.gameobject;
            delete item_sets.container;
            //delete item_sets.datadefault;
            delete item_sets.graphics;
            if (objCreate.setData)
                objCreate.setData(item_sets);

            if (objCreate.changeTexture) {
                objCreate.changeTexture();
            }
        }

        
        PractiveRestore.rotinaPhmetro();
    }

    static rotinaPhmetro() {
        //restaura o eletrodo onde ele ficava
        var phMetros = SceneObjectsSLab.getObjectClass('Phmetro');
        for (let i = 0; i < phMetros.length; i++) {
            phMetros[i].setEletrodoObjeto();
        }
    }
}