class DropZone {
    add(zone_data) {
        var zone = GAME_SCENE.add.zone(zone_data.x, zone_data.y).setCircleDropZone(100);
        zone.setOrigin(0);
        var sprite = GAME_SCENE.add.sprite(zone.x, zone.y, 'drop_zone');
        sprite.setOrigin(0.5);
        zone.zone_sprite = sprite;
        zone.A_REF_CLASS = this;
        this.gameobject = zone;
        this.region = zone_data.region;
        this.x = zone.x;
        this.y = zone.y;
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