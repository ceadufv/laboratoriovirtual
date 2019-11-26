class Substancias{
    //Substancias.searchSubstanciaData
    //procura a substancia pelo ID
    static searchSubstanciaData(id) {
        var substancias = PRATICA_DATA.elementos;
        for (let i = 0; i < substancias.length; i++) {
            if (substancias[i].id == id) {
                return substancias[i];
            }
        }
        return false;
    }
}