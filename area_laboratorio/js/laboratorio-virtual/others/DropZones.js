class DropZones {
    static addAll() {
        this.DROPZONES = []
        var zones = [
            { x: 240, y: 450 },
            { x: 600, y: 450 },
            { x: 960, y: 450 },
            { x: 1320, y: 450 },
            { x: 240, y: 740 },
            { x: 600, y: 740 },
            { x: 960, y: 740 },
            { x: 1320, y: 740 },
            { x: 2402, y: 508 },
            { x: 1805, y: 650 },
            { x: 1700, y: 318 },
            { x: 1902, y: 318 },
            { x: 2350, y: 730 },
            { x: 2065, y: 537 },
            { x: 2100, y: 720 },
            { x: 2128, y: 572 },
            { x: 2100, y: 760 },
            { x: 1550, y: 740 }
        ];
        for (var i = 0; i < zones.length; i++) {
            var drop = new DropZone();
            drop.add(zones[i]);
            this.DROPZONES.push(drop);
        }
    }
}

class DropZone {
    add(zone) {
        var sprite = GAME_SCENE.add.sprite(zone.x, zone.y, 'drop_zone');
        var zone = GAME_SCENE.add.zone(zone.x, zone.y).setCircleDropZone(200);
        zone.zone_sprite = sprite;
        this.zone = zone;
    }
}