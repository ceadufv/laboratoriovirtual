class Phmetro extends ObjetoDefault {
    objCalculoPh = null;
    ph_atual = 7;
    variacaoPhDefault = 5;
    variacaoPh = 5;
    variacaoPhDelta = 0;
    variacaoPhEnable = true;

    constructor(data) {
        super(data);
        this.addObject(data);
        this.countUpdate = 0;
        console.error('Phmetro.constructor', data);
    }

    /**
     * coloca o eletrodo no objeto que ele está medindo e faz os calculos
     */
    setEletrodoObjeto() {
        try {
            this.objCalculoPh = SceneObjectsSLab.getObjectId(this.objCalculoPh.id);
            this.objCalculoPh.gameobject.disableInteractive();
        } catch (e) {
            var bequerRepouso = SceneObjectsSLab.getObjectClass('BequerRepouso');
            if (bequerRepouso.length) {
                this.objCalculoPh = bequerRepouso[0];
                bequerRepouso[0].gameobject.disableInteractive();
            }
        }

        try {
            var eletrodo = this.container.getByName('eletrodo');
            eletrodo.x = this.objCalculoPh.gameobject.x - this.container.x;
            eletrodo.y = this.objCalculoPh.gameobject.y - this.container.y - 150;

            //calcula o ph da solucao
            this.ph_atual = this.calcularPhSolucao();
            this.objCalculoPh.gameobject.disableInteractive();

            this.variacaoPh = this.variacaoPhDefault;
            this.variacaoPhEnable = true;
            this.variacaoPhDelta = 0;

        } catch (e) {
            console.log('Phmetro', e);
        }
    }

    addObject(data) {
        this.container = GAME_SCENE.add.container(data.x, data.y);

        this.insertSprites();

        //inserindo textos
        this.insertTextos();

        var eletrodo = this.container.getByName('eletrodo');
        eletrodo.A_REF_CLASS = this;
        this.insertDrag(eletrodo);
        this.gameobject = eletrodo;

        //update add
        var classe = this;
        eletrodo.preUpdate = function (time, delta) {
            classe.myUpdate(time, delta);
        }
    }

    /**
     * limpa e joga em uma solucao de repouso
     */
    clearMedidorEletrodo(){
        try{
            this.objCalculoPh.gameobject.setInteractive();
        }catch(e){}

        this.objCalculoPh = null;
        this.setEletrodoObjeto();
    }

    drop(pointer, dropZone) {
        this.x = 290;
        this.y = 152;
        console.log('Phmetro.drop()', dropZone);
        super.drop(pointer, dropZone);
        this.A_REF_CLASS.updateEletrodo();
        if (dropZone.type == 'Zone') {
            this.x = 290;
            this.y = 152;
            this.A_REF_CLASS.clearMedidorEletrodo();
        }
        DropZones.ckeckUsado();
    }

    insertSprites() {
        var container = this.container;
        var image3 = GAME_SCENE.add.sprite(244.12, -113.39, 'phmetro_braco');
        image3.name = 'braco';
        container.add(image3);

        var image4 = GAME_SCENE.add.sprite(307.12, 20.47, 'phmetro_frente');
        container.add(image4);

        var image1 = GAME_SCENE.add.sprite(0, 0, 'phmetro');
        container.add(image1);

        var eletrodo = GAME_SCENE.add.sprite(290, 152, 'eletrodo');
        eletrodo.name = 'eletrodo';
        container.add(eletrodo);

        this.graphics = GAME_SCENE.add.graphics({ lineStyle: { width: 5, color: 0x9e9e9e } });
        this.graphics.clear();
        container.add(this.graphics);
    }

    insertTextos() {
        //get date now
        var utc = new Date().toJSON().slice(0, 10).split('-').reverse().join('/');

        var fonte = 'Open Sans Condensed';
        var TextopH = GAME_SCENE.add.text(-37.80, -102.37, '7.000', { fontFamily: fonte, fontSize: 32, color: '#ffffff' });
        TextopH.name = 'phvisor';

        var TextoModo1 = GAME_SCENE.add.text(-122.84, -119.69, 'Modo: pH', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });
        var TextoModo2 = GAME_SCENE.add.text(-126, -67.72, utc, { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });

        var TextoModo3 = GAME_SCENE.add.text(67.72, -119.69, '25º C', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });
        TextoModo3.name = 'temperatura';

        var TextoModo4 = GAME_SCENE.add.text(-10, -66.14, 'CAL:', { fontFamily: 'Arial', fontSize: 17, color: '#ffffff' });
        TextoModo4.name = 'calibracao';


        this.container.add(TextopH);
        this.container.add(TextoModo1);
        this.container.add(TextoModo2);
        this.container.add(TextoModo3);
        this.container.add(TextoModo4);

        console.log('Container Phmetro', this.container.list);
    }

    updatePHVisor() {
        this.countUpdate = 0;
        this.container.getByName('phvisor').text = QuimicaFormulas.calcularVariacao(this.ph_atual, this.variacaoPh);
        this.container.getByName('temperatura').text = (QuimicaFormulas.MC(1) + 20).toFixed(0) + 'º C';
    }

    updateEletrodo() {
        var image3 = this.container.getByName('braco');
        var eletrodo = this.container.getByName('eletrodo');

        this.graphics.clear();
        this.graphics.beginPath();
        this.graphics.moveTo(image3.x + 40, image3.y);
        this.graphics.lineTo(eletrodo.x, eletrodo.y - 100);
        this.graphics.strokePath();
        this.graphics.closePath();

        this.container.bringToTop(this.graphics);
        this.container.bringToTop(eletrodo);
    }

    changeTexture() {
        var visor = this.container.getByName('calibracao');
        visor.text = this.data_cabibracao;
    }

    toFront() {
        GAME_SCENE.children.bringToTop(this.container);
    }

    /**
     * trata as variaveis para calcular o PH
     */
    calcularPhSolucao() {
        var solucoes_itens = [];
        var composicao = null;
        try {
            composicao = this.objCalculoPh.composicao[0];
        } catch (e) {
            return 7;
        }

        if (composicao) {
            for (let i = 0; i < composicao.itens.length; i++) {
                let item = composicao.itens[i];
                var substancia = Substancias.searchSubstanciaData(item.id);
                solucoes_itens.push({
                    name: substancia.nome,
                    pkw: 14,
                    pk: substancia.dados[3],
                    qc: substancia.dados[2],
                    r: substancia.dados[1],
                    c: item.concentracao,
                    qMax: substancia.dados[0]
                });
            }
            let ph = QuimicaPH.procurarPH(solucoes_itens);
            return ph;
        } else {
            return 7;
        }
    }

    calcVariacaoPh(delta) {
        if (this.variacaoPhEnable) {
            this.variacaoPhDelta += delta;
            if (this.variacaoPhDelta > 7000) {
                this.variacaoPh = 0.1;
                this.variacaoPhEnable = false;
                this.variacaoPhDelta = 0;
            } else if (this.variacaoPhDelta > 5000) {
                this.variacaoPh = 0.2;
            } else if (this.variacaoPhDelta > 3000) {
                this.variacaoPh = 0.4;
            }
        }
    }

    myUpdate(time, delta) {
        this.calcVariacaoPh(delta);
        this.countUpdate++;
        if (this.countUpdate > 120) {
            this.updatePHVisor();
            //this.toFront();
        }

        this.updateEletrodo();
    }
}