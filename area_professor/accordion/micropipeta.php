<section class="justify-content-center" style="margin: 10px">
  <h3 title="Animação automática: o volume é preenchido automaticamente; Animação manual: deve-se clicar com o cursor nas posições corretas da micropipeta para ocorrer a pipetagem">Animação do uso</h3>
  <select disabled class="custom-select micropipeta-animacao micropipeta-<?php echo($valor) ?> " >
    <option value="auto">Automática</option>
    <option value="manual">Manual</option>
  </select>
</section>
<section class="d-flex justify-content-center" style="margin: 10px">
    <table class="table">
        <tbody>
        <tr>
            <td><h3 data-toggle="tooltip" data-placement="bottom" title="Faixas de volume disponíveis no laboratório">Faixa de volume</h3></td>
            <td><h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">Quantidade máxima</h3></td>
        </tr>
        <?php
            $valores = array(
            "10-100","50-200","100-1000","1000-5000"
            );
            foreach ($valores as $valor):
        ?>
        <tr class="linha-micropipeta" data-id="<?php echo $valor; ?>">
            <td style="text-align: left;">  
            <input class="micropipeta-disponivel micropipeta-<?php echo($valor) ?>" type="checkbox" 
                   onclick="ativacao_itens(this,'<?php echo $valor;?>')"> <span><?php echo $valor;?> µL</span>
            </td>
            <td>  
                <input class="micropipeta-qtd_maxima micropipeta-<?php echo($valor) ?>" type="number" min="0" max="10" value="0">
            </td>
        </tr>
        <?php
            endforeach;
        ?>
        </tbody>
    </table>
</section>
											