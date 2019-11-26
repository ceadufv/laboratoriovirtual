class Interac_Micropipeta_Ponteira {

    init(objMicropeta, objPonteira) {
        var data = objMicropeta.datadefault;
        data.x = objMicropeta.gameobject.x;
        data.y = objMicropeta.gameobject.y;
        data.conceito = 'micropipeta_ponteira';

        SceneObjectsSLab.add(new MicropipetaPonteira(data));
        objPonteira.destroy();
        objMicropeta.destroy();
    }
}