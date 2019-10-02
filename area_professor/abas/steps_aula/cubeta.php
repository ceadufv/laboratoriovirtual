<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#cubeta" aria-expanded="false" aria-controls="collapseThree">
                <strong><i class="fas fa-check-circle ativo"></i> Cubeta</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="cubeta" class="collapse" aria-labelledby="headingThree">
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">
                            <h3>Disponíveis</h3>
                        </td>
                        <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">
                            <h3>Nomes</h3>
                        </td>
                        <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">
                            <h3>Quantidade máxima</h3>
                        </td>
                    </tr>
                    <?php
                    $objCubeta = new Cubeta();
                    if (empty($pratica_sel['dados']['cubetas']))
                        $cubetas = $objCubeta->getDefaultItens();
                    else
                        $cubetas = $pratica_sel['dados']['cubetas'];

                    foreach ($cubetas as $cubeta){
                        ?>
                        <tr>
                            <td>
                                <select name="cubeta_disponivel[]">
                                    <option value="S" <?php echo ($cubeta['disponivel'] == 'S' ? 'selected' : '');?>>SIM</option>
                                    <option value="N" <?php echo ($cubeta['disponivel'] == 'N' ? 'selected' : '');?>>NÂO</option>
                                </select>
                            </td>
                            <td>
                                <span><?php echo $cubeta['nome']; ?></span>
                                <input name="cubeta_nome[]" type="hidden" value="<?php echo $cubeta['nome']; ?>">
                            </td>
                            <td>
                                <input name="cubeta_qtd_maxima[]" type="number" min="0" max="10" value="<?php echo $cubeta['qtd_maxima']; ?>">
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>