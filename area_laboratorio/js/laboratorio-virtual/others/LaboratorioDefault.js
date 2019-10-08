class LaboratorioDefault {
    static addItensScene() {
        console.log('LaboratorioDefault.addSceneItens');

        //BG
        GAME_SCENE.add.sprite(0, 0, 'background').setOrigin(0);

        LaboratorioDefault.criarArmarios();
        LaboratorioDefault.criarZonesDrops();
        LaboratorioDefault.criarObjetos();
    }
    static criarArmarios() {
        //ARMARIO
        var armario_solucoes = GAME_SCENE.add.sprite(485, 988, 'armario_solucoes').setInteractive({
            pixelPerfect: true,
            alphaTolerance: 120,
            draggable: false,
            cursor: 'pointer',
        });
        var armario_vidrarias = GAME_SCENE.add.sprite(1653, 988, 'armario_vidrarias').setInteractive({
            pixelPerfect: true,
            alphaTolerance: 120,
            draggable: false,
            cursor: 'pointer',
        });
        armario_solucoes.on('pointerdown', function () { Armario.abrirArmario('armario_solucoes'); });
        armario_vidrarias.on('pointerdown', function () { Armario.abrirArmario('armario_vidrarias'); });
    }

    static criarZonesDrops() {
        var json = PRATICA_DATA.cenario.placeholder;
        DropZones.addAll(json);
    }

    static criarObjetos() {
        /*{concept: "pia"
        region: "pia"
        static: true}*/
        var itens = PRATICA_DATA.cenario.objetos;
        for (var j = 0; j < itens.length; j++) {

            var drops = DropZones.getZonesLivres();
            var drop = drops[0];

            switch (itens[j].concept) {
                case 'pia':
                    var op = new Pia({ x: 2409.7999999999997, y: 292.27500086116794 });
                    OBJETOS_LAB.push(op);
                    break;
                case 'pisseta':
                    var op = new Pisseta({ x: drop.x, y: drop.y });
                    OBJETOS_LAB.push(op);
                    break;
                case 'bequer_vazio':
                    var op = new BequerVazio({ x: drop.x, y: drop.y });
                    OBJETOS_LAB.push(op);
                    break;
                case 'lenco':
                    var op = new Lenco({ x: drop.x, y: drop.y });
                    OBJETOS_LAB.push(op);
                    break;
                case 'phmetro':
                    var op = new Phmetro({ x: drop.x, y: drop.y });
                    OBJETOS_LAB.push(op);
                    break;
                case 'bequer_repouso':
                    var op = new BequerRepouso({ x: drop.x, y: drop.y });
                    OBJETOS_LAB.push(op);
                    break;
            }
            /*
            GAME_SCENE.add.sprite(itens[j].x, itens[j].y, itens[j].concept)
            .setInteractive({ pixelPerfect: true, draggable: true, cursor: 'pointer' });
            */
        }
    }

}