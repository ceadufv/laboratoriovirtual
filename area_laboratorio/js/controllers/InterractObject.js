/**
 * interração entre objetos
 * sempre tem interação entre objetos class é chamada
 */
class InterractObject{
    static callInterractDuo(classObjOn, classObjDrop){
        try {
            console.warn('Interração', 'ObjetoDefault');
            var class_str = 'new Interac_' + classObjOn.constructor.name + '_' + classObjDrop.constructor.name + '()';
            CLASS_INTERRACT_NOW = eval(class_str);
            CLASS_INTERRACT_NOW.init(classObjOn, classObjDrop);
            console.log('SET CLASS_INTERRACT_NOW', CLASS_INTERRACT_NOW, 'ObjetoDefault');
        } catch (e) {
            console.error('Classe não definida!!!', class_str);
            console.error('Error-ObjectDefault ', e);

            //Não encontrou interração
            MenuInteract.montModalInteracMenu([]);
        }
    }

    //InterractObject.callInterractOne()
    static callInterractOne(classObjOn){
        try {
            var class_str = 'new Interac_' + classObjOn.constructor.name + '_Self()';
            CLASS_INTERRACT_NOW = eval(class_str);
            CLASS_INTERRACT_NOW.init(classObjOn);
        } catch (e) {
            console.error('Error-ObjectDefault ', e);
            //Não encontrou interração
            MenuInteract.montModalInteracMenu([]);
        }
    }
}