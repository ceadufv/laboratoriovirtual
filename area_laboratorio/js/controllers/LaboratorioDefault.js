class LaboratorioDefault {
    static addItensScene() {
        console.log('LaboratorioDefault.addSceneItens');

        //BG
        GAME_SCENE.add.sprite(0, 0, 'background').setOrigin(0);
        LaboratorioDefault.criarArmarios();
        LaboratorioDefault.criarZonesDrops();

        //add Popover
        PRATICA_POPOVER = new Popover({ x: 0, y: 0 });
        
        //LaboratorioDefault.criarObjetos();
        var ID_PRATICA_RESTORE = PRATICA_DATA.id_save;
        if (ID_PRATICA_RESTORE) {
            PractiveRestore.restoreDataRegister(ID_PRATICA_RESTORE);
        }
    }
    static criarArmarios() {
        var armario_solucoes = GAME_SCENE.add.sprite(0, 900, 'bancada_armario').setInteractive({
            pixelPerfect: true,
            alphaTolerance: 120,
            draggable: false,
            cursor: 'pointer',
        });
        armario_solucoes.setOrigin(0);
        armario_solucoes.on('pointerdown', function () { Armario.abrirArmario('armario_solucoes'); GAME_SCENE.sound.play('a_open_porta');});
    }

    static criarZonesDrops() {
        var json = PRATICA_DATA.cenario.placeholder;
        DropZones.addAll(json);
    }

    /*
    static criarObjetos() {
        //{concept: "pia", region: "pia", static: true}
        var itens = PRATICA_DATA.cenario.objetos;
        for (var j = 0; j < itens.length; j++) {
            var drop = DropZones.getOneDropZoneLivre();
            itens[j].x = drop.x;
            itens[j].y = drop.y;
            var item = itens[j];
            if (item.concept) {
                switch (item.concept) {
                    case 'pia':
                        item.x = 2409.7999999999997;
                        item.y = 292.27500086116794;
                        break;
                }
                ConceptCreate.criar(item.concept, item);
            }
        }
    }
    */
}