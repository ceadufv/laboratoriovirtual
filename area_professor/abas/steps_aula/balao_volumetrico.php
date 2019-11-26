<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#balaovolumetrico" aria-expanded="false" aria-controls="collapseThree">
                <strong><i class="fas fa-check-circle ativo"></i> Balão Volumétrico</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="balaovolumetrico" class="collapse" aria-labelledby="headingThree">
        <div class="card-body">
            <!-- balaovolumetrico -->

            <section class="justify-content-center" style="margin: 10px">
                <h3 data-toggle="tooltip" data-placement="bottom" title="Como a lavagem da vidraria com a solução deve ser realizada. Em todo caso, o usuário terá que solicitar essa etapa">Animação da Ambientação</h3>
                <select disabled name="balao_ambientacao">
                    <option value="auto">Automática</option>
                    <option value="manual">Manual</option>
                </select>
                <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
                <select disabled name="balao_qtd_ambientes">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
                <select disabled  name="balao_agitacao">
                    <option value="auto">Automático</option>
                    <option value="manual">Manual</option>
                </select>
                <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
                <select disabled name="balao_mistura">
                    <option value="false">Não permite</option>
                    <option value="true">Permite</option>
                </select>

            </section>
            <section class="d-flex justify-content-center" style="margin: 10px">
                <table class="table">
                    <tbody>
                        <tr>
                            <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">
                                <h3>Disponível</h3>
                            </td>

                            <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">
                                <h3>Tamanho</h3>
                            </td>
                            <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">
                                <h3>Quantidade máxima</h3>
                            </td>
                            <td data-toggle="tooltip" data-placement="bottom" title="Variação que é permitida ocorrer no ajuste do volume. O usuário não saberá o volume correto.">
                                <h3>Faixa de Volume aceitável (%)</h3>
                            </td>
                            <td data-toggle="tooltip" data-placement="bottom" title="O desvio padrão considera o erro associado ao menisco do balão volumétrico ou à altura aparente. Pode estar entre 0 (sem erro) a 1,0% . O valor default é 0,01%">
                                <h3>Desvio Padrão (%)</h3>
                            </td>
                        </tr>
                        <?php
                        $objBalaoVolumetrico = new BalaoVolumetrico();
                        if (empty($pratica_sel['dados']['baloes']))
                            $balao_volumetrico = $objBalaoVolumetrico->getDefaultItens();
                        else
                            $balao_volumetrico = $pratica_sel['dados']['baloes'];
                            
                        foreach ($balao_volumetrico as $balao) {
                            $disabled = ($balao['disabled'] == 'S' ? 'disabled' : '');
                            ?>
                            <tr>
                                <td>
                                    <select <?php echo ($disabled); ?> name="balao_disponivel[]">
                                        <option value="S" <?php echo ($balao['disponivel'] == 'S' ? 'selected' : '');?>>SIM</option>
                                        <option value="N" <?php echo ($balao['disponivel'] == 'N' ? 'selected' : '');?>>NÂO</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="balao_tamanho[]" value="<?php echo $balao['tamanho']; ?>" />
                                    <span><?php echo ($balao['tamanho']); ?> mL</span>
                                </td>
                                <td>
                                    <input <?php echo $disabled; ?> name="balao_qtd_maxima[]" type="number" min="0" max="10" value="<?php echo $balao['qtd_maxima'];?>">
                                </td>
                                <td>
                                    <input <?php echo $disabled; ?> name="balao_faixa_aceitavel[]" type="number" min="0" max="110" step="0.1" value="<?php echo $balao['faixa_aceitavel']?>">
                                </td>
                                <td>
                                    <input <?php echo $disabled; ?> name="balao_desvio_padrao[]" type="number" min="0.0" max="1.0" step="0.01" value="<?php echo $balao['desvio_padrao']?>">
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
            <!-- /balaovolumetrico -->
        </div>
    </div>
</div>