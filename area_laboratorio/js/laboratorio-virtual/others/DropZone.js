class DropZone {
    add(zone_data) {
        //console.log(zone_data);
        var sprite = GAME_SCENE.add.sprite(zone_data.x, zone_data.y, 'drop_zone');
        //sprite.setInteractive();
        //sprite.input.dropZone = true;
        var zone = GAME_SCENE.add.zone(zone_data.x, zone_data.y).setCircleDropZone(200);
        zone.zone_sprite = sprite;
        zone.refClass = this;
        this.gameobject = zone;
        this.region = zone_data.region;
        this.x = zone.x - 10;
        this.y = zone.y -90;
        this.ocupado = false;
    }
    setOcupado(ocupado){
        this.ocupado = ocupado;
    }
    getOcupado(){
        return this.ocupado;
    }
    drop(){
        this.ocupado = true;
    }
    hover(){
        if(!this.ocupado)
            this.gameobject.zone_sprite.setTint(0xff0000);
    }
    normal(){
        this.gameobject.zone_sprite.clearTint(0xff0000);
    }
}