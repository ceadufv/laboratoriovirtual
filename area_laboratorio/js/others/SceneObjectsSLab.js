class SceneObjectsSLab{

    //SceneObjectsSLab.add
    static add(item){
        OBJETOS_LAB.push(item);
        SceneObjectsSLab.addIds();
    }

    static getOneId(){
        return SceneObjectsSLab.generateID();
    }

    //adiciona ids em todos objetos
    static addIds(){
        for (let i = 0; i < OBJETOS_LAB.length; i++) {
           if(OBJETOS_LAB[i].id){
               continue;
           }
           OBJETOS_LAB[i].id = SceneObjectsSLab.getOneId();
        }
    }

    static generateID(){
        var id = Math.floor((Math.random() * (5000 - 1) + 1));
        if(SceneObjectsSLab.checkId(id)){
            generateID();
            console.warn('SceneObjectsSLab -> gerando id novamente!!!');
        }else
            return id;
    }

    static checkId(id){
        for (let i = 0; i < OBJETOS_LAB.length; i++) {
           if(OBJETOS_LAB[i].id == id){
               return true;
           }
        }
        return false;
    }

    /** deleta o objeto pelo ID */
    static deleteObjectId(id){
        for (let i = 0; i < OBJETOS_LAB.length; i++) {
           if(OBJETOS_LAB[i].id == id){
                OBJETOS_LAB.splice(i, 1);
                return true;
           }
        }
        return;
    }
}