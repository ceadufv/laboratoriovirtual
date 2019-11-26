class Interac_Phmetro_Self{
    constructor(){
      
    }
    init(objClass){
        this.objClass = objClass;
        objClass.gameobject.setTint(0x0000ff);
        var menu = [
            {
                text: 'CALIBRAR PHMETRO',
                func: 'calibrarPhmetro'
            }
        ];
        MenuInteract.montModalInteracMenu(menu);
    }
    
    calibrarPhmetro(){
        //get date now
       var utc = new Date().toJSON().slice(0,10).split('-').reverse().join('/');
       //var visor = this.objClass.container.list[9]; 
       var visor = this.objClass.container.getByName('calibracao');
       visor.text = 'CAL: '+utc;
       this.objClass.data_cabibracao = visor.text;
       this.objClass.calibrado = true;
       
       var data = [
           {img: 'assets/actions/lerpadrao4.gif', title: 'Lendo primeiro padrão'},
           {img: 'assets/actions/lavareletrodo.gif', title: 'Lavando'},
           {img: 'assets/actions/secareletrodo.gif', title: 'Secando'},
           {img: 'assets/actions/lerpadrao7.gif', title: 'Lendo segundo padrão'},
           {img: 'assets/actions/lavareletrodo.gif', title: 'Lavando'},
           {img: 'assets/actions/secareletrodo.gif', title: 'Secando'},
        ];
       PageAnimation.open(data);
    }
}