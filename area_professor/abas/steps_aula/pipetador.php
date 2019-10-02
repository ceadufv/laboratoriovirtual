<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#pipetador" aria-expanded="false" aria-controls="collapseThree">
                <strong><i class="fas fa-check-circle ativo"></i> Pipetador</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="pipetador" class="collapse" aria-labelledby="headingThree">
        <div class="card-body">
            <!-- pipetador -->
            <section class="justify-content-center" style="margin: 10px">
                <h3 title="Animação automática: o volume é preenchido automaticamente até o menisco; Animação manual: deve-se clicar com o cursor em posição do pipetador para ocorrer a pipetagem">Animação do uso</h3>
                <select disabled name="pipetador_animacao">
                    <option value="auto">Automática</option>
                    <option value="manual">Manual</option>
                </select>
            </section>
            <section class="d-flex justify-content-center" style="margin: 10px">
                <table class="table">
                    <tbody>
                        <tr>
                            <td data-toggle="tooltip" data-placement="bottom" title="Tipo disponível no laboratório">
                                <h3>Disponível</h3>
                            </td>
                            <td data-toggle="tooltip" data-placement="bottom" title="Tipo disponível no laboratório">
                                <h3>Tipo de pipetador</h3>
                            </td>
                            <td data-toggle="tooltip" data-placement="bottom" title="Fotos dos tipos">
                                <h3>Foto</h3>
                            </td>
                            <td data-toggle="tooltip" data-placement="bottom" title="Tamanho disponível no laboratório">
                                <h3>Tamanho</h3>
                            </td>
                            <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">
                                <h3>Quantidade máxima</h3>
                            </td>
                        </tr>
                        <?php
                        $objPipetador = new Pipetador();
                        if (empty($pratica_sel['dados']['pipetadores']))
                            $pipetadores = $objPipetador->getDefaultItens();
                        else
                            $pipetadores = $pratica_sel['dados']['pipetadores'];

                        foreach ($pipetadores as $key => $pipetador){
                            ?>
                            <tr>
                                <td>
                                    <select name="pipetador_disponivel[]">
                                        <option value="S" <?php echo ($pipetador['disponivel'] == 'S' ? 'selected' : '');?>>SIM</option>
                                        <option value="N" <?php echo ($pipetador['disponivel'] == 'N' ? 'selected' : '');?>>NÂO</option>
                                    </select>
                                    <input type="hidden" name="pipetador_nome[]" value="<?php echo $pipetador['nome']; ?>" />
                                    <input type="hidden" name="pipetador_img[]" value="<?php echo ($pipetador['img']) ?>" />
                                </td>
                                <td>
                                    <?php echo $pipetador['nome']; ?>
                                </td>
                                <td>
                                    <img data-name="imagem" src="accordion/pipetadores/<?php echo ($pipetador['img']) ?>.jpg" width="100">
                                </td>
                                <td>
                                    <select name="pipetador_tamanho[]" disabled>
                                        <option selected value="unico">Único</option>
                                    </select>
                                </td>

                                <td>
                                    <input disabled name="pipetador_qtd_maxima[]" type="number" min="0" max="2" value="1">
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
            <!-- /pipetador -->
        </div>
    </div>
</div>