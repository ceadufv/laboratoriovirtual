class DropZones {
    static addAll(zones) {
        this.DROPZONES = []
        /*var zones = [
            { x: 1550, y: 740 }
        ];
        */
       console.error(zones);
        for (var i = 0; i < zones.length; i++) {
            if(zones[i].hidden)
                continue;

            var drop = new DropZone();
            drop.add(zones[i]);
            this.DROPZONES.push(drop);
        }
    }

    //DropZones.getZonesLivres();
    static getZonesLivres() {
        var result = [];
        DropZones.ckeckUsado();
        var drops = DropZones.DROPZONES;
        for(var i=0;i<drops.length;i++){
            if(!drops[i].ocupado)
                result.push(drops[i]);
        }
        return result;
    }

    //DropZones.getZonesUsados();
    static getZonesUsados() {
        var result = [];
        DropZones.ckeckUsado();
        var drops = DropZones.DROPZONES;
        for(var i = 0;i<drops.length;i++){
            if(drops[i].ocupado)
                result.push(drops[i]);
        }
        return result;
    }

    //DropZones.ckeckUsado();
    static ckeckUsado(){
        var drops = DropZones.DROPZONES;
        var objetos = OBJETOS_LAB;
        for(var i = 0;i<drops.length;i++){
            drops[i].ocupado = false;
            drops[i].gameobject.input.dropZone = true;
            for(var j=0;j<objetos.length;j++){
                if(objetos[j].gameobject.x == drops[i].x && objetos[j].gameobject.y == drops[i].y){
                    //console.warn('drop usado');
                    drops[i].gameobject.input.dropZone = false;
                    drops[i].ocupado = true;
                }
            }
        }
    }
}