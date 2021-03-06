<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#micropipeta" aria-expanded="false" aria-controls="collapseThree">
                <strong><i class="fas fa-check-circle ativo"></i> Micropipeta Volume Variável</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="micropipeta" class="collapse" aria-labelledby="headingThree">
        <div class="card-body">
            <section class="justify-content-center" style="margin: 10px">
                <h3 title="Animação automática: o volume é preenchido automaticamente; Animação manual: deve-se clicar com o cursor nas posições corretas da micropipeta para ocorrer a pipetagem">Animação do uso</h3>
                <select disabled name="micropipeta_animacao">
                    <option value="auto">Automática</option>
                    <option value="manual">Manual</option>
                </select>
            </section>
            <section class="d-flex justify-content-center" style="margin: 10px">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <h3 data-toggle="tooltip" data-placement="bottom" title="Faixas de volume disponíveis no laboratório">Disponível</h3>
                            </td>
                            <td>
                                <h3 data-toggle="tooltip" data-placement="bottom" title="Faixas de volume disponíveis no laboratório">Faixa de volume</h3>
                            </td>
                            <td>
                            </td>
                            <td>
                                <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">Quantidade máxima</h3>
                            </td>
                        </tr>
                        <?php
                        $objMicropipeta = new MicroPipeta();
                        if (empty($pratica_sel['dados']['micropipetas'])){
                            $micropipetas = $objMicropipeta->getDefaultItens();
                        }else
                            $micropipetas = $pratica_sel['dados']['micropipetas'];

                        foreach ($micropipetas as $micropipeta){
                            $disabled = ($micropipeta['disabled'] == 'S') ? 'disabled' : '';
                            ?>
                            <tr class="linha-micropipeta" data-id="<?php echo $valor; ?>">
                                <td style="text-align: left;">
                                    <select <?php echo ($disabled);?> name="micropipeta_disponivel[]">
                                        <option value="S" <?php echo ($micropipeta['disponivel'] == 'S' ? 'selected' : '');?>>SIM</option>
                                        <option value="N" <?php echo ($micropipeta['disponivel'] == 'N' ? 'selected' : '');?>>NÃO</option>
                                    </select>
                                </td>
                                <td>
                                    <input disabled type="text" name="micropipeta_name[]" value="<?php echo $micropipeta['nome']; ?>" />
                                </td>
                                <td>
                                    <input disabled type="text" name="micropipeta_volume_max[]" value="<?php echo $micropipeta['volume_max']; ?>" />
                                    <input disabled type="text" name="micropipeta_volume_min[]" value="<?php echo $micropipeta['volume_min']; ?>" />
                                </td>
                                <td>
                                    <input <?php echo $disabled; ?> name="micropipeta_qtd_maxima[]" type="number" min="0" max="10" value="<?php echo $micropipeta['qtd_maxima']; ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>

        </div>
    </div>
</div>