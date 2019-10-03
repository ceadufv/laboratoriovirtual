<div class="card">
    <div class="card-header" id="headingOne">
        <h5 class="mb-0">
            <button <?php echo (empty($pratica_sel['id_modelo_pratica']) ? 'disabled' : '')?> type="button" class="btn btn-link" data-toggle="collapse" data-target="#material" aria-expanded="false" aria-controls="collapseOne">
                <strong><i class="fas fa-check-circle ativo"></i> Material didático</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="material" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
            <h3>Caderno:</h3>
            <input type="file" name="caderno_file_caderno" /> <br />
            <button type="button" class="btn btn-success" id="enviar-caderno">Enviar caderno</button>

            <div id="caderno-arquivos">
                <?php echo $html_arquivos_caderno;?>
            </div>
        </div>
    </div>
    <div id="material" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
            <h3>Roteiro:</h3>
            <input type="file" name="material_file_roteiro" /><br />
            <button type="button" class="btn btn-success" id="enviar-roteiro">Enviar roteiro</button>

            <div id="roteiro-arquivos">
                <?php echo $html_arquivos_roteiro;?>
            </div>
        </div>
    </div>
</div>