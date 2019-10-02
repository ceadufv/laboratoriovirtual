<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#pipetavolumetrica" aria-expanded="false" aria-controls="collapseThree">
                <strong><i class="fas fa-check-circle ativo"></i> Pipeta Volumétrica</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="pipetavolumetrica" class="collapse" aria-labelledby="headingThree">
        <div class="card-body">
            <section class="justify-content-center" style="margin: 10px">

                <h3 data-toggle="tooltip" data-placement="bottom" title="Como a lavagem da vidraria com a solução deve ser realizada. Em todo caso, o usuário terá que solicitar essa etapa">Animação da Ambientação</h3>
                <select disabled name="pipeta_ambientacao">
                    <option value="auto">Automática</option>
                    <option value="manual">Manual</option>
                </select>
                <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
                <select disabled name="pipeta_qtd_ambientes">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
                <select disabled name="pipeta_agitacao">
                    <option value="auto">Automático</option>
                    <option value="manual">Manual</option>
                </select>
                <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
                <select disabled name="pipeta_mistura">
                    <option value="false">Não permite</option>
                    <option value="true">Permite</option>
                </select>
            </section>
            <section class="d-flex justify-content-center" style="margin: 10px">
                <table class="table">
                    <tbody>
                        <tr>
                            <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">
                                <h3>Disponíveis</h3>
                            </td>

                            <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">
                                <h3>Tamanhos</h3>
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
                        $objPipetaVolumetrica = new PipetaVolumetrica();
                        if (empty($pratica_sel['dados']['pipetas']))
                            $pipetas = $objBalaoVolumetrico->getDefaultItens();
                        else
                            $pipetas = $pratica_sel['dados']['pipetas'];

                        foreach ($pipetas as $key => $pipeta) {
                            $disabled = ($pipeta['disabled'] == 'S') ? 'disabled' : '';
                            ?>
                            <tr>
                                <td>
                                    <select <?php echo ($disabled); ?> name="pipeta_disponivel[]">
                                        <option value="S" <?php echo ($pipeta['disponivel'] == 'S' ? 'selected' : '');?>>SIM</option>
                                        <option value="N" <?php echo ($pipeta['disponivel'] == 'N' ? 'selected' : '');?>>NÃO</option>
                                    </select>
                                    <input type="hidden" name="pipeta_tamanho[]" value="<?php echo $pipeta['tamanho']; ?>" />
                                </td>
                                <td><span><?php echo $pipeta['tamanho']; ?> mL</span></td>
                                <td>
                                    <input <?php echo $disabled; ?> name="pipeta_qtd_maxima[]" type="number" min="0" max="10" value="0">
                                </td>
                                <td>
                                    <input <?php echo $disabled; ?> name="pipeta_faixa_aceitavel[]" type="number" min="90" max="110" value="110">
                                </td>
                                <td>
                                    <input <?php echo $disabled; ?> name="pipeta_desvio_padrao[]" type="number" min="0.0" max="1.0" step="0.01" value="0.01">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>