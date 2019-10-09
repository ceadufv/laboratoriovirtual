class Interac_Lenco_Phmetro{

    init(objctInit, objctDrop){
        this.objctDrop = objctDrop;
        var menu = [
            {
                text: 'SECAR',
                func: 'secar'
            }
        ];
        MenuInteract.montModalInteracMenu(menu);
    }

    secar(){
        this.objctDrop.seco = true;
    }
}