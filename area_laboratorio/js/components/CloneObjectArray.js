class CloneObjectArray {

    static objectCopy(src) {
        return JSON.parse(JSON.stringify(src));
    }

    /**
     *@author wellerson
     * CloneObjectArray.mergeObject(obj1, obj2);
    se a key já existir no obj1 ele ignora
    */
    static mergeObject(obj1, obj2) {
        var obj1 = this.objectCopy(obj1);
        var obj2 = this.objectCopy(obj2);

        //object merge
        Object.keys(obj2).forEach(function (key) {
            if (!obj1[key])
                obj1[key] = obj2[key];
        });
        return obj1;
    }
}