class Interac_Pisseta_Phmetro{
    constructor(){
        console.error('Interac_Phmetro_Pisseta constructor');
    }
    init(objctInit, objctDrop){
        this.objctDrop = objctDrop;
        console.error('init');
        console.warn(objctInit);
        console.warn(objctDrop);
        //this.objctInit = objctInit;
        //this.objctDrop = objctDrop;

        //objctDrop.gameobject.setTint(0x0000ff);
        //objctInit.gameobject.setTint(0x0000ff);

        var menu = [
            {
                text: 'LAVAR E SECAR ELETRODO',
                func: 'lavar_secar_eletrodo'
            }
        ];
        MenuInteract.montModalInteracMenu(menu);
    }
    
    lavar_secar_eletrodo(){
       this.objctDrop.lavado = true;
       var data = [
           {img: 'assets/actions/lavareletrodo.gif'},
           {img: 'assets/actions/secareletrodo.gif'},
        ];
       PageAnimation.open(data);
    }
}