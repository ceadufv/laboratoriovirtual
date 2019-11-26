class Interac_Pipetador_Pipeta {
    init(objPipetador, objPipeta) {
        var data = {
            'pipetador': objPipetador.datadefault,
            'pipeta': objPipeta.datadefault,
            'x': objPipeta.gameobject.x,
            'y': objPipeta.gameobject.y
        };
        
        data = CloneObjectArray.mergeObject(data, objPipeta.datadefault);
        SceneObjectsSLab.add(new PipetaPipetador(data));
        objPipetador.destroy();
        objPipeta.destroy();
    }
}