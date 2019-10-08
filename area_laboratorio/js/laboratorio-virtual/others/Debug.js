class Debug {
    static debug = true;
    static offs_debug = ["ObjetoDefault", "MenuInteract", "PageAnimation"];
    
    static log(msg, tipo = '') {
        if (this.offs_debug.includes(tipo))
            return;

        if (!Debug.debug)
            return;

        console.log(msg);
    }
    static error(msg, tipo = '') {

        if (this.offs_debug.includes(tipo))
            return;

        if (!Debug.debug)
            return;
        console.error(msg);
    }

    static warn(msg, tipo = '') {

        if (this.offs_debug.includes(tipo))
            return;

        if (!Debug.debug)
            return;
        console.warn(msg);
    }


}