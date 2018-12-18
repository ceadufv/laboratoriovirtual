<section class="justify-content-center" style="margin: 10px">
  <h3 title="Animação automática: o volume é preenchido automaticamente até o menisco; Animação manual: deve-se clicar com o cursor em posição do pipetador para ocorrer a pipetagem">Animação do uso</h3>
  <select disabled class="custom-select pipetador-animacao pipetador-<?php echo($valor) ?> " >
    <option value="auto">Automática</option>
    <option value="manual">Manual</option>
  </select>
</section>
<section class="d-flex justify-content-center" style="margin: 10px">
  <table class="table">
    <tbody>
      <tr>
        <td data-toggle="tooltip" data-placement="bottom" title="Tipo disponível no laboratório"><h3>Tipo de pipetador</h3></td>
        <td data-toggle="tooltip" data-placement="bottom" title="Fotos dos tipos"><h3>Foto</h3></td>
        <td data-toggle="tooltip" data-placement="bottom" title="Tamanho disponível no laboratório"><h3>Tamanho</h3></td>
        <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível"><h3>Quantidade máxima</h3></td>
        
      </tr>
      <?php
      $valores = array(
          "Pera", "Pi-pump2" , "Pi-pump5" , "Pi-pump10", "Macropipetador", "Automático"
        );
        foreach ($valores as $valor):
      ?>
      <tr class="linha-pipetador" data-id="<?php echo $valor; ?>">
        <td style="text-align: left;">  
          <input class="pipetador-disponivel pipetador-<?php echo($valor) ?>" type="checkbox" 
                onclick="ativacao_itens(this,'<?php echo $valor;?>')"> <span class="nomepipetador"><?php echo $valor;?></span>
        </td>
        <td>
        <img src="accordion/pipetadores/<?php echo($valor) ?>.jpg"  width="100">
        </td>
        <td>
          <select disabled class="custom-select pipetador-tamanho pipetador-<?php echo($valor) ?> ">
            <option value="unico">Único</option>
          </select>
        </td>
        
        <td>  
            <input disabled class="pipetador-qtd_maxima pipetador-<?php echo($valor) ?>" type="number" min="0" max="2" value="1">
        </td>
      </tr>
      <?php
        endforeach;
      ?>
    </tbody>
  </table>
</section>