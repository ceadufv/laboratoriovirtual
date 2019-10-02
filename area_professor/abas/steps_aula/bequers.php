<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#bequer" aria-expanded="false" aria-controls="collapseThree">
                <strong><i class="fas fa-check-circle ativo"></i> Béquer</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="bequer" class="collapse" aria-labelledby="headingThree">
        <div class="card-body">
            <div class="form-row informacoes">
                <div class="col-auto">

                    <h3 data-toggle="tooltip" data-placement="bottom" title="Como a lavagem da vidraria com a solução deve ser realizada. Em todo caso, o usuário terá que solicitar essa etapa">Animação da Ambientação</h3>
                    <select disabled data-armario="vidrarias" name="bequer_ambientacao" class="custom-select bequer-ambientacao bequer" data-name="bequer_ambientacao">
                        <option value="auto">Automática</option>
                        <option value="manual">Manual</option>
                    </select>
                </div>
                <div class="col-auto">
                    <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">
                        Número de vezes a ambientar
                    </h3>
                    <select disabled name="bequer_qtd_ambientes" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="col-auto">
                    <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
                    <select disabled data-armario="vidrarias" data-name="bequer_agitacao" name="bequer_agitacao" class="custom-select bequer-agitacao">
                        <option value="auto">Automático</option>
                        <option value="manual">Manual</option>
                    </select>
                </div>
                <div class="col-auto">
                    <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
                    <select disabled data-armario="vidrarias" data-name="bequer_mistura" name="bequer_mistura" class="custom-select bequer-mistura bequer">
                        <option value="false">Não permite</option>
                        <option value="true">Permite</option>
                    </select>
                </div>
            </div>

            <section class="d-flex justify-content-center">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <h3 data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">ATIVO</h3>
                            </td>
                            <td>
                                <h3 data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">Tamanhos disponíveis</h3>
                            </td>
                            <td>
                                <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">Quantidade máxima</h3>
                            </td>

                            <td>
                                <h3 data-toggle="tooltip" data-placement="bottom" title="Máximo de líquido que pode ser adicionado ao béquer para evitar o derramento acidental. O valor deve estar entre 80% e 95%">Volume Máximo (%)</h3>
                            </td>
                            <td>
                                <h3 data-toggle="tooltip" data-placement="bottom" title="O desvio padrão considera o erro associado à escala externa do béquer ou à altura aparente. Deve estar entre 5% e 20%">Desvio Padrão</h3>
                            </td>
                        </tr>
                        <?php
                        $objBequer = new Bequer();
                        if(empty($pratica_sel['dados']['bequers']))
                            $bequers = $objBequer->getDefaultItens();
                        else
                            $bequers = $pratica_sel['dados']['bequers'];

                        foreach ($bequers as $key => $bequer) {
                            $disabled = ($bequer['disabled'] == 'S') ? 'disabled' : '';
                        ?>
                            <input type="hidden" value="<?php echo $bequer['disabled'];?>" name="bequer_disabled[]" />
                            <tr>
                                <td>
                                    <select <?php echo ($disabled);?> name="bequer_disponivel[]">
                                        <option value="N" <?php echo ($bequer['disponivel'] == 'N' ? 'selected' : '');?>>NÃO</option>
                                        <option value="S" <?php ($bequer['disponivel'] == 'S') ? 'selected' : '' ?>>SIM</option>
                                    </select>
                                    <input type="hidden" name="bequer_tamanho[]" value="<?php echo $bequer['tamanho']; ?>" />
                                </td>
                                <td><span><?php echo $bequer['tamanho']; ?> mL</span></td>
                                <td>
                                    <input <?php echo ($disabled);?> value="<?php echo $bequer['qtd_maxima']; ?>" name="bequer_qtd_maxima[]" type="number" min="0" max="10">
                                </td>
                                <td>
                                    <input <?php echo ($disabled);?> value="<?php echo $bequer['volume_maximo']; ?>" name="bequer_volume_maximo[]" type="number" min="80" max="95">
                                </td>
                                <td>
                                    <input <?php echo ($disabled);?> value="<?php echo $bequer['desvio_padrao']; ?>" name="bequer_desvio_padrao[]" type="number" min="5" max="20">
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>