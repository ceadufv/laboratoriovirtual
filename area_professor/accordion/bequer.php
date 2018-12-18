


  <div class="form-row informacoes">
    <div class="col-auto">

        <h3 data-toggle="tooltip" data-placement="bottom" title="Como a lavagem da vidraria com a solução deve ser realizada. Em todo caso, o usuário terá que solicitar essa etapa">Animação da Ambientação</h3>
        <select class="custom-select bequer-ambientacao bequer-<?php echo($valor) ?> " >
            <option value="auto">Automática</option>
            <option value="manual">Manual</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
        <select class="custom-select bequer-qtd_ambientes bequer-<?php echo($valor) ?> ">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
        <select class="custom-select bequer-agitacao bequer-<?php echo($valor) ?> ">
            <option value="auto">Automático</option>
            <option value="manual">Manual</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
        <select class="custom-select bequer-mistura bequer-<?php echo($valor) ?> ">
            <option value="false">Não permite</option>
            <option value="true">Permite</option>
        </select>
    </div>
</div>

<section class="d-flex justify-content-center">
    <table class="table">
        <tbody>
            <tr>
                <td><h3 data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">Tamanhos disponíveis</h3></td>
                <td><h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">Quantidade máxima</h3></td>

                <td><h3 data-toggle="tooltip" data-placement="bottom" title="Máximo de líquido que pode ser adicionado ao béquer para evitar o derramento acidental. O valor deve estar entre 80% e 95%">Volume Máximo (%)</h3></td>
                <td><h3 data-toggle="tooltip" data-placement="bottom" title="O desvio padrão considera o erro associado à escala externa do béquer ou à altura aparente. Deve estar entre 5% e 20%">Desvio Padrão</h3></td>
            </tr>
            <?php
            $valores = array(
                5, 10, 50, 100, 250, 400, 500, 600, 1000, 2000
            );
            foreach ($valores as $valor):
                ?>
                <tr class="linha-bequer" data-id="<?php echo $valor; ?>">
                    <td style="text-align: left;">  
                        <input class="bequer-disponivel bequer-<?php echo($valor) ?>" type="checkbox" 
                        onclick="ativacao_itens(this,<?php echo $valor;?>)"> <span><?php echo $valor;?> mL</span>
                    </td>
                    <td>  
                        <input class="bequer-qtd_maxima bequer-<?php echo($valor) ?>" type="number" min="0" max="10" value="0">
                    </td>
                    <td> 
                        <input class="bequer-volume_maximo bequer-<?php echo($valor) ?>" type="number" min="80" max="95" value="80">
                    </td>
                    <td> 
                        <input class="bequer-desvio_padrao bequer-<?php echo($valor) ?>" type="number" min="5" max="20" value="10">
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</section>
