<div class="container">
  <div class="conteudocriacaopraticas">
    <div class="row">
      <div class="administrar col-md-12">
        <h3>
          <span>Administrar disciplinas</span>
          <div class="form">
          </div>
        </h3>

        <div class="input-group">
          <select class="custom-select acessoDis" required id="listaDisciplinas">
            <?php

            $sql = $lab->getDisciplinasProfessor(@$_SESSION['id_usuario']);

            if (count($sql)) {

              foreach ($sql as $row) { ?>
                <option value=<?php echo $row['id_disciplina'] ?>> <?php echo $row["nome"] ?> </option>;
            <?php }
            } else {
              echo "Não há práticas disponíveis";
            }
            ?>
          </select>
          <div class="input-group-append">
            <button class="btn verde" onclick="selecionar_disciplina()"><i class="fa fa-check-circle"></i> Acessar</button>
            <button class="btn vermelho" data-toggle="confirmation-disciplina" data-title="Tem certeza que deseja excluir a disciplina?" data-placement="right" data-singleton="true" data-btn-ok-label="SIM" data-btn-ok-class="verde" data-btn-cancel-label="NÃO" data-btn-cancel-class="vermelho">
              <i class="fas fa-minus-circle"></i> Remover </button>
            <span class="divisao"></span>
            <button class="btn azul" type=button data-toggle="collapse" href="#adicionarDisciplina"><i class="fas fa-plus-circle"></i> Adicionar disciplina</button>
          </div>
        </div>

        <div class="collapse" id="adicionarDisciplina">
          <div class="card card-body">
            <div class="form-row">
              <div class="col-auto">
                <label class="my-1 mr-2" for="inlineFormCustomSelectPref"><b>Nova disciplina:</b></label>
              </div>
              <div class="col-auto">
                <input autofocus id="nome_disciplina_nova" class="input-disciplina" type="text" name="aula" placeholder="Digite o nome" required>
              </div>
              <div class="col-auto">
                <button id="salvarDisciplina" type="button" class="btn btn-outline-primary" onclick="salvarDisciplina()">Salvar</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="<?php echo URL_SITE; ?>area_professor/js/abas/inicio.js"></script>