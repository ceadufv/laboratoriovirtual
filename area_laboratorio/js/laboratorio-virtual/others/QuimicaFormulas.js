class QuimicaFormulas {
    static cargaefetiva(pH, q0, somapKa, numpKa, j) {
        var termo0 = 1
        var alfai = 0;
        for (var i = 1; i <= numpKa[j - 1]; i++) {
            termo0 = termo0 + Math.pow(10, i * pH - somapKa[i - 1][j - 1]);
        }
        var alfa0 = 1 / termo0;
        var qef1 = alfa0 * q0[j - 1];
        for (var i = 1; i <= numpKa[j - 1]; i++) {
            alfai = Math.pow(10, i * pH - somapKa[i - 1][j - 1]) / termo0;
            qef1 = alfai * (q0[j - 1] - 1) + qef1;
        }
        return qef1;
    }
    
    static wat(pH, pKw, Hfi) {
        if (QuimicaFormulas.IsMissing(Hfi)) {
            Hfi = 0
        }
        return Math.pow(10, (-pH + Hfi)) - Math.pow(10, pH - pKw + Hfi);
    }

    static IsMissing(arg) {
        if (!arg || arg == "" || arg == undefined || arg.length <= 0) {
            return true;
        } else {
            return false;
        }
    }
}