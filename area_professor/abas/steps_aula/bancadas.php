<div class="card">
    <div class="card-header" id="headingOne">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#bancadas" aria-expanded="false" aria-controls="collapseOne">
                <strong><i class="fas fa-check-circle ativo"></i> Bancadas</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="bancadas" class="collapse bancadas" aria-labelledby="headingOne">
        <div class="card-body">
            <h3>Selecione uma opção:</h3>
            <div class="radio">
                <label><input type="radio" value="1" name="bancada_tipo" checked> pHmetro </label>
            </div>
            <div class="radio">
                <label><input type="radio" value="2" name="bancada_tipo" <?php echo $pratica_sel['dados']['bancada_tipo'] == 2 ? 'checked' : ''?>> Espectrofotômetro </label>
            </div>
        </div>
    </div>
</div>