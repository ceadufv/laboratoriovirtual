
<section class="criarnovasolucao">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3>Criar nova solução</h3>
      </div>
    </div>
    <div class="row row-eq-height">
      <div class="col-4">
        <div class="box">
          <h4>Rótulo</h4>
          <h5>Nome:</h5>
          <textarea id="nome_solucao" rows="1" cols="20" placeholder="Insira o nome da solução"></textarea>
          <h5>Descrição:</h5>
          <textarea id="descricao_solucao" rows="3" cols="20" placeholder="Insira a descrição da solução"></textarea>
          <h5>Responsável pelo preparo:</h5>
          <input id="nome_tecnico" type="text" value="Técnico do NeoAlice">
          <h5>Data de criação:</h5>
          <select id="data_de_criacao" class="custom-select">
            <option value=1>Dia da aula </option>
            <option value=2>Dia anterior à aulas </option>
            <option value=3>Cerca de uma semana antes da aula </option>
            <option value=4>Cerca de um mês antes da aula </option>
            <option value=5>Cerca de dois meses antes da aula </option>
          </select>
        </div>
      </div>
      <div class="col-4">
        <div class="box">
          <h4>Composição</h4>
          <select id="especies_disponiveis" class="custom-select">
            <?php
            global $banco;
            $solucoes_selecionadas = $banco -> prepare('SELECT * FROM substancias');
            $solucoes_selecionadas -> execute();
            $item = $solucoes_selecionadas -> fetchAll(PDO::FETCH_ASSOC);
            foreach ($item as $res) { 
              ?>
              <option value="<?php echo $res['id_substancia']?>"><?php echo $res['nome']?></option>
            <?php };
            ?>
          </select>
        </div>
      </div>
      <div class="col-4 concentracao">
        <div class="box">
          <h4>Concentração (mol/L)</h4>
          <input autofocus min="0" value="0.1" type="number" step="0.1">
          <button onclick="adicionar_especie()" class="btn verde">Adicionar</button>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="especienasolucao">
          <h5>Espécies na Solução</h5>
          <table>
            <tbody id="especies_na_solucao">
              <tr>
                <td class="align-self-center" width=350 colspan=4 ></td>
              </tr>
            </tbody>
          </table>
        </div>
        <button class="btn btn-primary btn-criar" onclick="concluir_criar_solucao()"> CONCLUIR CRIAÇÃO  </button>
        <button class="btn btn-primary btn-editar" onclick="concluir_editar_solucao()"> CONCLUIR EDIÇÃO </button>
      </div>
    </div>

  </section>

