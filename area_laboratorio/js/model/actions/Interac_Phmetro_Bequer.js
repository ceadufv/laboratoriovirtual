class Interac_Phmetro_Bequer{
    init(objPh, objBequer){
        try{
            objPh.objCalculoPh.gameobject.setInteractive();
        }catch(e){}

        objPh.objCalculoPh = objBequer;
        objPh.setEletrodoObjeto();
    }
}