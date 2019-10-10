class Interac_Solucao_Solucao{
    constructor(){
        console.error('interacSolucao_Solucao Okkk');
    }
    init(objctInit, objctDrop){
        this.objctInit = objctInit;
        this.objctDrop = objctDrop;

        console.error('init');
        console.warn(objctInit);
        console.warn(objctDrop);

        objctDrop.gameobject.setTint(0x0000ff);
        objctInit.gameobject.setTint(0x0000ff);
        var menu = [
            {
                text: 'Misturar',
                func: 'misturar'
            }
        ];
        MenuInteract.montModalInteracMenu(menu);
    }
    
    misturar(){
        alert('misturar');
    }
}