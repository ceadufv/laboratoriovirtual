<div class="card">
    <div class="card-header" id="headingOne">
        <h5 class="mb-0">
            <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#cenarios" aria-expanded="false" aria-controls="collapseOne">
                <strong><i class="fas fa-check-circle ativo"></i> Cenário</strong>
                <i class="fa" aria-hidden="true"></i>
            </button>
        </h5>
    </div>
    <div id="cenarios" class="collapse bancadas" aria-labelledby="headingOne">
        <div class="card-body">
            <div class="form-group">
            <label>Selecione uma opção: <small>O cénario vai alterar de acordo com o escolhido.</small></label>
            <select class="form-control" name="fk_id_cenario">
                <option value="1" <?php echo ($pratica_sel['fk_id_cenario'] == 1 ? 'selected' : '')?>>Cénario 1</option>
                <option value="2" <?php echo ($pratica_sel['fk_id_cenario'] == 2 ? 'selected' : '')?>>Cénario 2</option>
            </select>
            </div>
        </div>
    </div>
</div>