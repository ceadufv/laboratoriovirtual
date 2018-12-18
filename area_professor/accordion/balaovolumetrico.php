<section class="justify-content-center" style="margin: 10px">

    <h3 data-toggle="tooltip" data-placement="bottom" title="Como a lavagem da vidraria com a solução deve ser realizada. Em todo caso, o usuário terá que solicitar essa etapa">Animação da Ambientação</h3>
    <select class="custom-select balaovolumetrico-ambientacao balaovolumetrico-<?php echo($valor) ?> " >
        <option value="auto">Automática</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
    <select class="custom-select balaovolumetrico-qtd_ambientes balaovolumetrico-<?php echo($valor) ?> ">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
    <select class="custom-select balaovolumetrico-agitacao balaovolumetrico-<?php echo($valor) ?> ">
        <option value="auto">Automático</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
    <select class="custom-select balaovolumetrico-mistura balaovolumetrico-<?php echo($valor) ?> ">
        <option value="false">Não permite</option>
        <option value="true">Permite</option>
    </select>
    
</section>
<section class="d-flex justify-content-center" style="margin: 10px">
    <table class="table">
        <tbody>
            <tr>
            <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório"><h3>Tamanhos disponíveis</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível"><h3>Quantidade máxima</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="Variação que é permitida ocorrer no ajuste do volume. O usuário não saberá o volume correto."><h3>Faixa de Volume aceitável (%)</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="O desvio padrão considera o erro associado ao menisco do balão volumétrico ou à altura aparente. Pode estar entre 0 (sem erro) a 1,0% . O valor default é 0,01%"><h3>Desvio Padrão (%)</h3></td>
            </tr>
            <?php
            $valores = array(
                5, 10, 25, 50, 100, 200, 250, 500, 1000, 2000
            );
            foreach ($valores as $valor):
            ?>
            <tr class="linha-balaovolumetrico" data-id="<?php echo $valor; ?>">
            <td style="text-align: left;">  
                <input class="balaovolumetrico-disponivel balaovolumetrico-<?php echo($valor) ?>" type="checkbox" 
                    onclick="ativacao_itens(this,<?php echo $valor;?>)"> <span><?php echo $valor;?> mL</span>
            </td>
            <td>  
                <input class="balaovolumetrico-qtd_maxima balaovolumetrico-<?php echo($valor) ?>" type="number" min="0" max="10" value="0">
            </td>
            <td> 
                <input class="balaovolumetrico-faixa_aceitavel balaovolumetrico-<?php echo($valor) ?>" type="number" min="90" max="110" value="110">
            </td>
            <td> 
                <input class="balaovolumetrico-desvio_padrao balaovolumetrico-<?php echo($valor) ?>" type="number" min="0.0" max="1.0" step="0.01"  value="0.01">
            </td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</section>