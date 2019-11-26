class SceneObjectsSLab {

    //SceneObjectsSLab.destroyAll();
    static destroyAll() {
        var tam = OBJETOS_LAB.length;
        for (var i = 0; i < tam; i++) {
            var objt = OBJETOS_LAB[i];
            objt.update = function () { };
            console.log(objt);
            //objt.destroy();
            if (objt.gameobject != undefined && objt.gameobject != '') {
                objt.gameobject.destroy();
            }
            if (objt.container != undefined && objt.container != '') {
                objt.container.destroy();
            }
        }
        OBJETOS_LAB = [];
    }

    //SceneObjectsSLab.setDropZone();
    static setDropZone(drop = true) {
        for (var i = 0; i < OBJETOS_LAB.length; i++) {
            if (OBJETOS_LAB[i].gameobject)
                OBJETOS_LAB[i].gameobject.input.dropZone = drop;
        }
    }

    //SceneObjectsSLab.add
    static add(item) {
        OBJETOS_LAB.push(item);
        SceneObjectsSLab.addIds();
    }

    static getOneId() {
        return SceneObjectsSLab.generateID();
    }

    //adiciona ids em todos objetos
    static addIds() {
        for (let i = 0; i < OBJETOS_LAB.length; i++) {
            if (OBJETOS_LAB[i].id) {
                continue;
            }
            OBJETOS_LAB[i].id = SceneObjectsSLab.getOneId();
        }
    }

    static generateID() {
        var id = Math.floor((Math.random() * (5000 - 1) + 1));
        if (SceneObjectsSLab.checkId(id)) {
            SceneObjectsSLab.generateID();
            console.warn('SceneObjectsSLab -> gerando id novamente!!!');
        } else
            return id;
    }

    /** pega o objeto 'class' pelo ID 
     * 
     * SceneObjectsSLab.getObjectId();
    */
    static getObjectId(id) {
        for (let i = 0; i < OBJETOS_LAB.length; i++) {
            if (OBJETOS_LAB[i].id == id) {
                return OBJETOS_LAB[i];
            }
        }
        return false;
    }

    static checkId(id) {
        for (let i = 0; i < OBJETOS_LAB.length; i++) {
            if (OBJETOS_LAB[i].id == id) {
                return true;
            }
        }
        return false;
    }

    /** deleta o objeto pelo ID */
    static deleteObjectId(id) {
        for (let i = 0; i < OBJETOS_LAB.length; i++) {
            if (OBJETOS_LAB[i].id == id) {
                OBJETOS_LAB.splice(i, 1);
                return true;
            }
        }
        return;
    }
    
    /** pega o objeto pelo nome da 'class'
     * 
     * SceneObjectsSLab.getObjectClass();
    */
    static getObjectClass(name_class) {
        var saida = [];
        for (let i = 0; i < OBJETOS_LAB.length; i++) {
            if (OBJETOS_LAB[i].constructor.name == name_class) {
                saida.push(OBJETOS_LAB[i]);
            }
        }
        return saida;
    }

}