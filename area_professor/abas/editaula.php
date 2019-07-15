<!-- TODO: Simplificar a ativacao de itens na tela -->
<div class="container">
	<div class="row">
		<div class="col-md-12">

			<div class="navegacao">
				<a onclick="aba('inicio')" href="#">Administração</a> >
				<a value="" onclick="aba('aulas')" href="#" class="disciplina_caminho"></a> >
				<a class="cadastra_edita"> Cadastrar nova prática</a> >
			</div>

			<h3>
				<span>Cadastrar nova prática</span>
				<div class="form">
					<button id="fechar" onclick='aba("aulas")' class="voltar"><i class="fas fa-angle-left"></i> VOLTAR</button>
				</div>
			</h3>

			<div class="dadospratica">
				<div>
					TÍTULO: <input id="nome_aula" class="input-pratica" type="text" name="aula" placeholder="Digite aqui..." required>
					RESUMO: <input id="resumo_aula" class="resumoaula" class="input-pratica" type="text" name="aula" placeholder="Digite aqui..." required>

				</div>
			</div>

			<div id="accordion" class="accordion">
                <div class="card"> 
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#material" aria-expanded="false" aria-controls="collapseOne">
                                <strong><i class="fas fa-check-circle ativo"></i> Material didático</strong>
                                <i class="fa" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>
                    <div id="material" class="collapse" aria-labelledby="headingOne">
                        <div class="card-body">
                            <h3>Caderno:</h3>
                            <input type="file" />
                        </div>
                    </div>
                    <div id="material" class="collapse" aria-labelledby="headingOne">
                        <div class="card-body">
                            <h3>Roteiro:</h3>
                            <input type="file" />
                        </div>
                    </div>
                </div>

				<div class="card"> 
					<div class="card-header" id="headingOne">
						<h5 class="mb-0">
							<button class="btn btn-link" data-toggle="collapse" data-target="#bancadas" aria-expanded="false" aria-controls="collapseOne">
								<strong><i class="fas fa-check-circle ativo"></i> Bancadas</strong>
								<i class="fa" aria-hidden="true"></i>
							</button>
						</h5>
					</div>
					<div id="bancadas" class="collapse bancadas" aria-labelledby="headingOne">
						<div class="card-body">
							<h3>Selecione uma opção:</h3>
							<div class="radio">
								<h4><input type="radio" value="1" name="bancada" checked> pHmetro </h4>
							</div>
							<div class="radio">
								<h4><input type="radio" value="2" name="bancada"> Espectrofotômetro </h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingOne">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#solucoes" aria-expanded="true" aria-controls="collapseOne">
								<strong><i class="fas fa-check-circle ativo"></i> Soluções</strong>
								<i class="fa" aria-hidden="true"></i>
							</button>
						</h5>
					</div>
					<div id="solucoes" class="collapse" aria-labelledby="headingOne">
						<div class="card-body">
<!-- solucoes -->

<div class="solucoes">

  <div class="solucoespreparadas">
    <h3>
      <span>Soluções já preparadas:</span>
      <button class="botao_criar_solucao btn azul" onclick="editar_solucao(true)" class="btn btn-primary" data-toggle="modal" data-target=".modal-edit-solucao"><i class="fas fa-plus-circle"></i> CRIAR NOVA SOLUÇÃO</button>
    </h3>

    <div class="composicao">

      <div>
        <select id="select_solucoes" class="custom-select">
<?php 
/*
          global $banco;
          try {
            $solucoes = $banco -> prepare('SELECT * FROM solucoes');
            $solucoes -> execute();
            $o = $solucoes -> fetchAll(PDO::FETCH_ASSOC);

            foreach ($o as $res) { ?>
              <option value=<?php echo $res['id_solucao']?> descricao="<?php echo $res['descricao'] ?>" ><?php echo $res['nome']?></option>
            <?php };
          } catch(PDOException $e) {
            echo json_encode(array('sucesso' => false, 'log' => $e -> getMessage()));
          }
*/          
?>
        </select>
        <div class="composicao_solucao_option"><h4>COMPOSIÇÃO: <?php echo $o[0]['descricao'] ?></h4></div>
      </div>
      <div>
        <button class="botao_editar_solucao btn verde" onclick="editar_solucao(false)" class="btn btn-primary"><i class="fa fa-pen"></i> EDITAR SOLUÇÃO</button>      	
        <button class="botao_adicionar btn verde" onclick="adicionar_solucao_armario()"><i class="fas fa-plus-circle"></i> Adicionar ao Armário</button>
      </div>

    </div>

  </div>
  <table class="armario form-row">
      <thead>
          <tr>
              <td class="align-self-center" width=350 colspan=4 >
              <h3>ARMÁRIO</h3>
              </td>
          </tr> 
      </thead>
      <tbody id="lista_solucoes_pratica">
          <tr>
              <td class="align-self-center" width=350 colspan=4 >
              </td>
          </tr>
      <tbody>
  </table>
  </div>

  <div class="modal fade bd-example-modal-lg modal-edit-solucao" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_solucao">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">



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
          <input autofocus min="0" value="0.1" type="number" step="0.1" id="especies_concentracao" />
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
        <button class="btn btn-primary btn-criar" onclick="concluir_criar_solucao()"> Salvar  </button>
        <button class="btn btn-primary btn-criar" onclick="$('#modal_solucao').modal('hide')"> Cancelar  </button>
      </div>
    </div>

</section>


      </div>
    </div>
  </div>
<!-- /solucoes -->
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#bequer" aria-expanded="false" aria-controls="collapseThree">
								<strong><i class="fas fa-check-circle ativo"></i> Béquer</strong>
								<i class="fa" aria-hidden="true"></i>
							</button>
						</h5>
					</div>
					<div id="bequer" class="collapse" aria-labelledby="headingThree">
						<div class="card-body">
<!-- bequer -->

  <div class="form-row informacoes">
    <div class="col-auto">

        <h3 data-toggle="tooltip" data-placement="bottom" title="Como a lavagem da vidraria com a solução deve ser realizada. Em todo caso, o usuário terá que solicitar essa etapa">Animação da Ambientação</h3>
         <select disabled data-armario="vidrarias" name="bequer_ambientacao" class="custom-select bequer-ambientacao bequer" data-name="bequer_ambientacao">
            <option value="auto">Automática</option>
            <option value="manual">Manual</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
        <select disabled data-armario="vidrarias" data-name="bequer_quantidade" name="bequer_quantidade" class="custom-select bequer-qtd_ambientes">
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
                <td><h3 data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório">Tamanhos disponíveis</h3></td>
                <td><h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">Quantidade máxima</h3></td>

                <td><h3 data-toggle="tooltip" data-placement="bottom" title="Máximo de líquido que pode ser adicionado ao béquer para evitar o derramento acidental. O valor deve estar entre 80% e 95%">Volume Máximo (%)</h3></td>
                <td><h3 data-toggle="tooltip" data-placement="bottom" title="O desvio padrão considera o erro associado à escala externa do béquer ou à altura aparente. Deve estar entre 5% e 20%">Desvio Padrão</h3></td>
            </tr>
            <?php
            $valores = array(
                5, 10, 50, 100, 250, 400, 500, 600, 1000, 2000
            );
            foreach ($valores as $valor):
            	$disabled = ($valor != 5 && $valor != 10 && $valor != 50 && $valor != 100 && $valor != 250)?" disabled":"";
                ?>
                <tr class="linha-bequer" data-id="<?php echo $valor; ?>">
                    <td style="text-align: left;">  
                        <input<?php echo $disabled; ?> value="<?php echo $valor; ?>" data-armario="vidrarias" data-name="volume" name="bequer" class="bequer-disponivel bequer" type="checkbox" 
                        onclick="toggle(this)" /> <span><?php echo $valor;?> mL</span>
                    </td>
                    <td>  
                        <input<?php echo $disabled; ?> data-name="disponiveis" name="disponiveis" class="bequer-qtd_maxima bequer" type="number" min="0" max="10" value="0">
                    </td>
                    <td> 
                        <input<?php echo $disabled; ?> data-name="volume_maximo" name="disponiveis" class="bequer-volume_maximo bequer" type="number" min="80" max="95" value="80">
                    </td>
                    <td> 
                        <input<?php echo $disabled; ?> data-name="desvio_padrao" name="disponiveis" class="bequer-desvio_padrao bequer" type="number" min="5" max="20" value="10">
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</section>
<!-- /bequer -->
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#balaovolumetrico" aria-expanded="false" aria-controls="collapseThree">
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
    <select disabled data-armario="vidrarias" data-name="balaovolumetrico_ambientacao" name="balaovolumetrico_ambientacao" class="custom-select balaovolumetrico-ambientacao balaovolumetrico" >
        <option value="auto">Automática</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
    <select disabled data-armario="vidrarias" data-name="balaovolumetrico_qtd_ambientes"  name="balaovolumetrico_qtd_ambientes" class="custom-select balaovolumetrico-qtd_ambientes balaovolumetrico">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
    <select disabled data-armario="vidrarias" data-name="balaovolumetrico_agitacao" name="balaovolumetrico_agitacao" class="custom-select balaovolumetrico-agitacao balaovolumetrico">
        <option value="auto">Automático</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
    <select disabled data-armario="vidrarias" data-name="balaovolumetrico_mistura" name="balaovolumetrico_mistura" class="custom-select balaovolumetrico-mistura balaovolumetrico">
        <option value="false">Não permite</option>
        <option value="true">Permite</option>
    </select>
    
</section>
<section class="d-flex justify-content-center" style="margin: 10px">
    <table class="table">
        <tbody>
            <tr>
            <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório"><h3>Tamanhos disponíveis</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível"><h3>Quantidade máxima</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="Variação que é permitida ocorrer no ajuste do volume. O usuário não saberá o volume correto."><h3>Faixa de Volume aceitável (%)</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="O desvio padrão considera o erro associado ao menisco do balão volumétrico ou à altura aparente. Pode estar entre 0 (sem erro) a 1,0% . O valor default é 0,01%"><h3>Desvio Padrão (%)</h3></td>
            </tr>
            <?php
            $valores = array(
                5, 10, 25, 50, 100, 200, 250, 500, 1000, 2000
            );
            foreach ($valores as $valor):
            	$disabled = ($valor != 5 && $valor != 10 && $valor != 25 && $valor != 50 && $valor != 100 && $valor != 200 && $valor != 250)?" disabled":"";
            ?>
            <tr class="linha-balaovolumetrico" data-id="<?php echo $valor; ?>">
            <td style="text-align: left;">  
                <input <?php echo $disabled; ?> data-armario="vidrarias" data-name="volume" class="balaovolumetrico-disponivel balaovolumetrico" type="checkbox" 
                    onclick="toggle(this)" name="balao" value="<?php echo($valor) ?>"> <span><?php echo $valor;?> mL</span>
            </td>
            <td>  
                <input <?php echo $disabled; ?> data-name="disponiveis" name="disponiveis" class="balaovolumetrico-qtd_maxima balaovolumetrico" type="number" min="0" max="10" value="0">
            </td>
            <td> 
                <input <?php echo $disabled; ?> data-name="faixa_aceitavel" class="balaovolumetrico-faixa_aceitavel balaovolumetrico" type="number" min="90" max="110" value="110">
            </td>
            <td> 
                <input <?php echo $disabled; ?> data-name="desvio_padrao" class="balaovolumetrico-desvio_padrao balaovolumetrico" type="number" min="0.0" max="1.0" step="0.01"  value="0.01">
            </td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</section>


<!-- /balaovolumetrico -->
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#pipetavolumetrica" aria-expanded="false" aria-controls="collapseThree">
								<strong><i class="fas fa-check-circle ativo"></i> Pipeta Volumétrica</strong>
								<i class="fa" aria-hidden="true"></i>
							</button>
						</h5>
					</div>
					<div id="pipetavolumetrica" class="collapse" aria-labelledby="headingThree">
						<div class="card-body">
<!-- pipetavolumetrica -->
<section class="justify-content-center" style="margin: 10px">

    <h3 data-toggle="tooltip" data-placement="bottom" title="Como a lavagem da vidraria com a solução deve ser realizada. Em todo caso, o usuário terá que solicitar essa etapa">Animação da Ambientação</h3>
    <select disabled data-armario="vidrarias" class="custom-select" name="pipetavolumetrica_ambientacao">
        <option value="auto">Automática</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
    <select disabled data-armario="vidrarias" class="custom-select" name="pipetavolumetrica_qtd_ambientes">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
    <select disabled data-armario="vidrarias" class="custom-select" name="pipetavolumetrica_agitacao">
        <option value="auto">Automático</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
    <select disabled data-armario="vidrarias" class="custom-select pipetavolumetrica-mistura" name="pipetavolumetrica_mistura">
        <option value="false">Não permite</option>
        <option value="true">Permite</option>
    </select>
</section>
<section class="d-flex justify-content-center" style="margin: 10px">
    <table class="table">
        <tbody>
            <tr>
            <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório"><h3>Tamanhos disponíveis</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível"><h3>Quantidade máxima</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="Variação que é permitida ocorrer no ajuste do volume. O usuário não saberá o volume correto."><h3>Faixa de Volume aceitável (%)</h3></td>
            <td data-toggle="tooltip" data-placement="bottom" title="O desvio padrão considera o erro associado ao menisco do balão volumétrico ou à altura aparente. Pode estar entre 0 (sem erro) a 1,0% . O valor default é 0,01%"><h3>Desvio Padrão (%)</h3></td>
            </tr>
            <?php
            $valores = array(
                1.0, 2.0, 3.0, 4.0, 5.0, 6.0, 7.0, 8.0, 9.0, 10, 15, 20, 25, 50, 100
            );
            foreach ($valores as $valor):
            	$disabled = ($valor != 5.0 && $valor != 10.0)?" disabled":"";
            ?>
            <tr class="linha-pipetavolumetrica" data-id="<?php echo $valor; ?>">
            <td style="text-align: left;">  
                <input <?php echo $disabled; ?> data-armario="vidrarias" data-name="volume" name="pipeta" class="pipetavolumetrica-disponivel pipetavolumetrica" type="checkbox" 
                    onclick="toggle(this)" value="<?php echo $valor;?>"> <span><?php echo $valor;?> mL</span>
            </td>
            <td>  
                <input <?php echo $disabled; ?> data-name="disponiveis" name="disponiveis" class="pipetavolumetrica-qtd_maxima pipetavolumetrica" type="number" min="0" max="10" value="0">
            </td>
            <td> 
                <input <?php echo $disabled; ?> data-name="faixa_aceitavel" class="pipetavolumetrica-faixa_aceitavel pipetavolumetrica" type="number" min="90" max="110" value="110">
            </td>
            <td> 
                <input <?php echo $disabled; ?> data-name="desvio_padrao" class="pipetavolumetrica-desvio_padrao pipetavolumetrica" type="number" min="0.0" max="1.0" step="0.01"  value="0.01">
            </td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</section>
<!-- /pipetavolumetrica -->
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#pipetador" aria-expanded="false" aria-controls="collapseThree">
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
	  <select data-armario="vidrarias" disabled class="custom-select" name="pipetador_animacao">
	    <option value="auto">Automática</option>
	    <option value="manual">Manual</option>
	  </select>
	</section>
	<section class="d-flex justify-content-center" style="margin: 10px">
	  <table class="table">
	    <tbody>
	      <tr>
	        <td data-toggle="tooltip" data-placement="bottom" title="Tipo disponível no laboratório"><h3>Tipo de pipetador</h3></td>
	        <td data-toggle="tooltip" data-placement="bottom" title="Fotos dos tipos"><h3>Foto</h3></td>
	        <td data-toggle="tooltip" data-placement="bottom" title="Tamanho disponível no laboratório"><h3>Tamanho</h3></td>
	        <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível"><h3>Quantidade máxima</h3></td>
	        
	      </tr>
	      <?php
	      $valores = array(
              "pera" => "Pipetador de três vias",
              "pi-pump2" => "Pi-pump de até 2 ml ",
              "pi-pump5" => "Pi-pump de até 5 ml",
              "pi-pump10" => "Pi-pump de até 10 ml",
              "macropipetador" => "Macropipetador",
              "automatico" => "Pipetador automático"
	        );
	        foreach ($valores as $key => $valor):
	      ?>
	      <tr class="linha-pipetador" data-id="<?php echo $valor; ?>">
	        <td style="text-align: left;">  
	          <input <?php echo ($key != "pera")?" disabled":""; ?> data-armario="vidrarias" data-name="volume" name="pipetador" class="pipetador-disponivel pipetador" type="checkbox" 
	                onclick="toggle(this)" value="<?php echo $key;?>" /> <span class="nomepipetador"><?php echo $valor;?></span>
	        </td>
	        <td>
	        <img data-name="imagem" src="accordion/pipetadores/<?php echo($key) ?>.jpg" width="100">
	        </td>
	        <td>
	          <select data-name="tamanho" data-armario="vidrarias" name="pipetador_tamanho" disabled>
	            <option value="unico">Único</option>
	          </select>
	        </td>
	        
	        <td>  
	            <input name="disponiveis" data-name="disponiveis" disabled type="number" min="0" max="2" value="1">
	        </td>
	      </tr>
	      <?php
	        endforeach;
	      ?>
	    </tbody>
	  </table>
	</section>
<!-- /pipetador -->
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#micropipeta" aria-expanded="false" aria-controls="collapseThree">
								<strong><i class="fas fa-check-circle ativo"></i> Micropipeta Volume Variável</strong>
								<i class="fa" aria-hidden="true"></i>
							</button>
						</h5>
					</div>
					<div id="micropipeta" class="collapse" aria-labelledby="headingThree">
						<div class="card-body">
<!-- micropipeta -->
<section class="justify-content-center" style="margin: 10px">
  <h3 title="Animação automática: o volume é preenchido automaticamente; Animação manual: deve-se clicar com o cursor nas posições corretas da micropipeta para ocorrer a pipetagem">Animação do uso</h3>
  <select data-armario="vidrarias" disabled name="micropipeta_animacao">
    <option value="auto">Automática</option>
    <option value="manual">Manual</option>
  </select>
</section>
<section class="d-flex justify-content-center" style="margin: 10px">
    <table class="table">
        <tbody>
        <tr>
            <td><h3 data-toggle="tooltip" data-placement="bottom" title="Faixas de volume disponíveis no laboratório">Faixa de volume</h3></td>
            <td><h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível">Quantidade máxima</h3></td>
        </tr>
        <?php
        $valores = array(
        "10-100","50-200","100-1000","1000-5000"
        );
        foreach ($valores as $valor):
        	$disabled = ($valor != "100-1000" )?" disabled":"";
        ?>
        <tr class="linha-micropipeta" data-id="<?php echo $valor; ?>">
            <td style="text-align: left;">  
            <input <?php echo $disabled; ?> class="micropipeta-disponivel micropipeta" data-armario="vidrarias" data-name="volume" name="micropipeta" type="checkbox" 
                   onclick="toggle(this)" value="<?php echo $valor;?>"> <span><?php echo $valor;?> µL</span>
            </td>
            <td>  
                <input <?php echo $disabled; ?> name="disponiveis" data-name="disponiveis" class="micropipeta-qtd_maxima micropipeta" type="number" min="0" max="10" value="0">
            </td>
        </tr>
        <?php
            endforeach;
        ?>
        </tbody>
    </table>
</section>
<!-- /micropepita -->
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">
							<button disabled class="btn btn-link collapsed" data-toggle="collapse" data-target="#proveta" aria-expanded="false" aria-controls="collapseThree">
								<strong><i class="fas fa-check-circle"></i> Proveta</strong>
								<i class="fa" aria-hidden="true"></i>
							</button>
						</h5>
					</div>
					<div id="proveta" class="collapse" aria-labelledby="headingThree">
						<div class="card-body">
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#cubeta" aria-expanded="false" aria-controls="collapseThree">
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
        <td data-toggle="tooltip" data-placement="bottom" title="Tamanhos disponíveis no laboratório"><h3>Tipos disponíveis</h3></td>
        <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível"><h3>Quantidade máxima</h3></td>
        </tr>
        <?php
        $valores = array(
        	"Cubeta de vidro",
        	"Cubeta de quartzo"
        );
        foreach ($valores as $valor):
        ?>
        <tr class="linha-cubeta" data-id="<?php echo $valor; ?>">
	        <td style="text-align: left;">  
	            <input data-armario="vidrarias" data-name="volume" class="cubeta-disponivel cubeta" type="checkbox" 
	                onclick="toggle(this)" name="cubeta" value="<?php echo($valor) ?>"> <span><?php echo $valor;?></span>
	        </td>
	        <td>  
	            <input name="disponiveis" data-name="disponiveis" class="cubeta-qtd_maxima cubeta" type="number" min="0" max="10" value="0">
	        </td>
        </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">
							<button disabled class="btn btn-link collapsed" data-toggle="collapse" data-target="#espatula" aria-expanded="false" aria-controls="collapseThree">
								<strong><i class="fas fa-check-circle"></i> Espátula</strong>
								<i class="fa" aria-hidden="true"></i>
							</button>
						</h5>
					</div>
					<div id="espatula" class="collapse" aria-labelledby="headingThree">
						<div class="card-body">
						</div>
					</div>
				</div>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="pratica-disponivel">
				<label class="form-check-label" for="pratica-disponivel"><b>Deixar aula disponivel aos alunos</b></label>
			</div>
			<div style="padding-top:10px;">
				<button id = "salvar" type="button" class="btn btn-outline-primary" onclick="salvar_pratica()">Salvar</button>
				<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#confirmarsaida">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="confirmarsaida" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body mb-4 mt-3 text-dark">
				Tem certeza que quer cancelar? Podem haver dados não salvos
			</div>
			<div class="modal-footer">
				<a href="index.php" type="button" class="btn btn-primary">OK</a>
				<a type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</a>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})

		function toggle(o) {
			// 
			var tr = $(o).parents('tr');
			var itens = tr.find('*[data-name]');
			var checked = $(o).prop('checked');

			// Desabilita os objetos irmaos do atual, pertencentes a mesma tr
			for (var i =  0 ; i < itens.length ; i++) {
				if ($(itens[i]).attr('name') == $(o).attr('name'))
					continue;

				if ($(itens[i]).prop('tagName') == 'IMG') {
					//
					//$(itens[i]).removeClass('disabled');

					//
					//if (!checked) $(itens[i]).addClass('disabled');			
				} else
					$(itens[i]).prop('disabled', !checked);
			}
		}
/*
TODO:
- Conferir se tudo esta carregando OK
- Incluir no mecanismo de "salvar" a lista de solucoes
- Implementar a area de upload das apostilas
*/
    var dados_pratica = {
      id: parseInt('<?php echo $_REQUEST['id_pratica']; ?>'),
      id_disciplina: parseInt('<?php echo $_REQUEST['id_disciplina']; ?>')
    };

        function load_pratica() {
            //

            $.ajax({
              url:'../area_laboratorio/data.php?action=pratica',
              data: {
                id_pratica:dados_pratica.id,
                id_disciplina:dados_pratica.id_disciplina
              }
            }).done(function (data) {

              $('.dadospratica').attr('data-id',data.id);
              $('#nome_aula').val(data.nome);
              $('#resumo_aula').val(data.resumo);

              dados_pratica = data;

              $('input[name="bancada"]').each(function() {
                $(this).prop('checked', $(this).val() == dados_pratica.id_cenario);
              });

              for (var i in dados_pratica.data) {
                carregaCampo(i, dados_pratica.data[i]);
              }
            });
        } 

        function indice_idsolucao_estoque (n){

        	for (var i = 0 ; i < solucoes_estoque.length ; i++) {
            	if (solucoes_estoque[i].id == n) return i; 
            }
            return -1;

        }


        var solucoes_estoque = [
			{
				"id": 1,
				"nome": "Sol. Estoque Ácida",
				"descricao": "Solução ácida utilizada como um modelo de solução",
				"tecnico": "Técnico CEAD",
				"intervalo": "3",
				"composicao": [
					{
						"id": "1",
						"nome": "Ácido Forte",
						"concentracao": "1"
					}
				],
				"estoque": true,
				"disponiveis": 5
			},
			{
				"id": 2,
				"nome": "Sol. Estoque Básica",
				"descricao": "Solução básica utilizada como um modelo de solução",
				"tecnico": "Técnico CEAD",
				"intervalo": "4",
				"composicao": [
					{
						"id": "2",
						"nome": "Base Forte",
						"concentracao": "1"
					}
				],
				"estoque": true,
				"disponiveis": 5
			},
			{
				"id": 3,
				"nome": "Sol. Branco p/ Espectrofotômetro",
				"descricao": "Solução utilizada como branco para medição no espectrofotômetro",
				"tecnico": "Técnico CEAD",
				"intervalo": "1",
				"composicao": [
					{
						"id": "102",
						"nome": "Branco",
						"concentracao": "0.0005"
					}
				],
				"estoque": true,
				"disponiveis": 5
			}

		];

        function carregaCampo(campo, valor) {
            var obj = $('*[name="'+campo+'"]');

            if (campo == 'solucoes')  {
				
				valor = solucoes_estoque.concat(valor);

                for (var i = 0 ; i < valor.length ; i++) {
                    $('#select_solucoes').append(
                        '<option value="'+valor[i].id+'">'+
                            valor[i].nome+
                        '</option>'
                    );
                }
            }
            else if (campo == 'armario_solucoes'){
            	//console.log(valor)
            	var conjunto = [];
            	for (var i = 0 ; i < valor.length ; i++){
            		console.log(valor[i].id,valor[i].nome)

            		var novalinha = "<tr class="+valor[i].id;
           			novalinha+= "><td class='id_solucoes_pratica' data-id="+valor[i].id;
            		novalinha+= ">"+valor[i].nome+"</td><td>";
            		novalinha+= "<button onclick='deletar_linha(this, atualizar_armario)' class='btn vermelho'>Excluir </button>";
            		novalinha+= "</td></tr>";

            		var linha = novalinha;
            		conjunto.push(linha)    		     		
	           	}

	           	//console.log(conjunto)
	           	$("#lista_solucoes_pratica").append(conjunto)
            	
            }
			else if (campo == 'armario_vidrarias'){
				for (var i in valor) {
	            	campos_armario(i, valor[i]);
				}
			}
            //
            else
            	campos_armario(campo, valor);
            
        }

    function campos_armario(campo, valor) {

    	var obj = $('*[name="'+campo+'"]');
    	if ($(obj).attr('type') == 'radio') {
            $(obj).each(function () {
                var check = ($(this).val() == valor);
                $(this).prop('checked',check);
            });
        }

        //
        else
        if ($(obj).attr('type') == 'checkbox') {

            $(obj).each(function () {
                var existe = false;
                for (var i = 0 ; i < valor.length ; i++) {
                    if (valor[i].volume == $(this).val()) {
                		var tr = $(this).parents('tr');

                		for (var j in valor[i]) {

                			if (j == 'id') continue;
                			if (j == 'volume') continue;

                			tr.find('*[data-name="'+j+'"]').val(valor[i][j]);
                		}

                        existe = true;
                        break;
                    }
                }

                //
                $(this).click();
                //
                if ($(this).prop('checked') != existe) {
                	$(this).click();
                }
            })
        }

        // 
        else {
            obj.val(valor);
        }
    }

        function adicionar_solucao_armario(){
            var nome = $("#select_solucoes option:selected").text();
            console.log('nome add', nome)
            var id_solucao = $("#select_solucoes option:selected").val();
            console.log('id add', id_solucao)

            if (!id_solucao) return false;

            // Nao permite que uma mesm solucao
            // seja adicionada ao armario mais de uma vez
            if ($('.id_solucoes_pratica[data-id="'+id_solucao+'"]').length) return;

            //
            var novalinha = "<tr class="+id_solucao;
            novalinha+= "><td class='id_solucoes_pratica' data-id="+id_solucao;
            novalinha+= ">"+nome+"</td><td>";
            novalinha+= "<button onclick='deletar_linha(this, atualizar_armario)' class='btn vermelho'>Excluir </button>";
            novalinha+= "</td></tr>";

            $("#lista_solucoes_pratica").append(novalinha); 

            atualizar_armario();
        };


        function atualizar_armario() {
            dados_pratica.data.armario = [];
            
            $('.id_solucoes_pratica').each(function () {
                var nome = $(this).text();
                var id_solucao = parseInt($(this).attr('data-id'));

                console.log('id', id_solucao)

                var dados = [];

				if(id_solucao > 100){
                	dados.push(dados_pratica.data.solucoes[indice_idsolucao(id_solucao)]);
                } else {
                	dados.push(solucoes_estoque[indice_idsolucao_estoque(id_solucao)]);
                }

                console.log ('dados', dados)

                var descricao_solucao = dados[0].descricao;
                var tecnico_solucao = dados[0].tecnico;
                var intervalo_solucao = dados[0].intervalo;
                var composicao_solucao = dados[0].composicao;
                var disponiveis_solucao = 5;

                dados_pratica.data.armario.push({ 
                	id:id_solucao, 
                	nome:nome,
                	descricao: descricao_solucao,
                	tecnico: tecnico_solucao,
                	intervalo: intervalo_solucao,
                	disponiveis: disponiveis_solucao,
                	composicao: composicao_solucao
                });
                //dados_pratica.data.armario.push({ id:id_solucao, nome:nome });
            });

        }       

        function listar_composicao() {
            var composicao = [];
            $('.linha_composicao').each(function () {
                composicao.push({
                    id: $(this).attr('data-id'),
                    nome: $(this).attr('data-nome'),
                    concentracao: $(this).attr('data-value')
                })
            });
            return composicao;
        }

        function proximo_id_solucao() {
          var result = 100;
          for (var i = 0 ; i < dados_pratica.data.solucoes.length ; i++) {
            if (!dados_pratica.data.solucoes[i]) continue;

            console.log(i, dados_pratica.data.solucoes[i])

            if (dados_pratica.data.solucoes[i]) result = dados_pratica.data.solucoes[i].id;
          }

          return result+1;
        }

        function indice_idsolucao (n){

        	for (var i = 0 ; i < dados_pratica.data.solucoes.length ; i++) {
            	if (dados_pratica.data.solucoes[i].id == n) return i; 
            }
            return -1;

        }


        function concluir_criar_solucao() {

            var composicao = listar_composicao();

            $('#modal_solucao').modal('hide');

            var id_solucao = parseInt($('#modal_solucao').attr('data-id'));

            var form_nome_solucao = $('#nome_solucao').val();
            var form_descricao = $('#descricao_solucao').val();
            var form_tecnico = $('#nome_tecnico').val();
            var form_intervalo = $('#data_de_criacao').val();

            if (id_solucao == -1) {
              id_solucao = proximo_id_solucao();

              dados_pratica.data.solucoes.push({
                id: id_solucao,
                nome: form_nome_solucao,
                descricao: form_descricao,
                tecnico: form_tecnico,
                intervalo: form_intervalo,
                composicao: composicao
              });

              $('#select_solucoes').append('<option value="'+id_solucao+'">' + dados_pratica.data.solucoes[indice_idsolucao(id_solucao)].nome + '</option>')
            } else {
              dados_pratica.data.solucoes[indice_idsolucao(id_solucao)] = {
                id: id_solucao,
                nome: form_nome_solucao,
                descricao: form_descricao,
                tecnico: form_tecnico,
                intervalo: form_intervalo,
                composicao: composicao
              };

              $('#select_solucoes option[value="'+id_solucao+'"]').text(form_nome_solucao);

            }            

        }


        function deletar_linha(obj) {
            var args = arguments;
            $(obj).parents('tr').remove();

            console.log(args)

            if (args.length > 1) args[1](obj);
        }

        function adicionar_especie(){
            var composicao = listar_composicao();

            var atual = {
                id: $('#especies_disponiveis').val(),
                nome: $('#especies_disponiveis option:selected').text(),
                concentracao: $('#especies_concentracao').val(),
            };

            for (var i = 0 ; i < composicao.length ; i++) {
                if (composicao[i].id == atual.id) return false;
            }

            adicionar_especie_lista(atual);
        };

        function adicionar_especie_lista(dado) {
            var novalinha = "<tr class=\"linha_composicao\" data-id=\""+dado.id+"\" data-nome=\""+dado.nome+"\" data-value=\""+dado.concentracao+"\"><td class='nomes_composicao'>"+dado.nome+"</td><td class='conc_lista_solucao'>"+dado.concentracao+"</td><td> mol/L</td><td><button class='btn vermelho' onclick='deletar_linha(this)'>Excluir </button></td></tr>";

            $("#especies_na_solucao").append(novalinha);
        }

        function criar_solucao(){

          // Limpar a tela
          $('#nome_solucao').val('')
          $('#descricao_solucao').val('')
          $('#nome_tecnico').val('') 
          $('#data_de_criacao').val('')

          $('.linha_composicao').remove(); 

        }

    var counter = 0;

    function editar_solucao(novo)
    {

      var id_solucao = parseInt($('#select_solucoes').val());

      if (!novo && !id_solucao) return false;

      // Criar
      if (novo){ 

        //
        $('#modal_solucao').attr('data-id', -1);
        criar_solucao();

      }
      // Editar
      else {

      	if (id_solucao <100) return false

        $('#modal_solucao').attr('data-id', id_solucao);

        //var id_solucao = $('#select_solucoes').val();
        var dados = dados_pratica.data.solucoes[indice_idsolucao(id_solucao)];

        $('#nome_solucao').val(dados.nome)
        $('#descricao_solucao').val(dados.descricao)
        $('#nome_tecnico').val(dados.tecnico) 
        $('#data_de_criacao').val(dados.intervalo)

        $('.linha_composicao').remove();

        for (var i = 0 ; i < dados.composicao.length ; i++) {
          adicionar_especie_lista(dados.composicao[i]);
        }

      }

      $('#modal_solucao').modal('show');
    }

		function salvar_pratica() {
			var data = {};
			var fields = $('input,select:not([data-id])');
			var id = parseInt($('.dadospratica').attr('data-id',data.id));

      if (!dados_pratica.data) dados_pratica.data = {};

			data.solucoes = dados_pratica.data.solucoes;
			data.armario_solucoes = dados_pratica.data.armario;
			data.armario_vidrarias = {};
			//data.armario_vidrarias.balao = [];

			for (var i = 0 ; i < fields.length ; i++) {
			  //
			  var type = ($(fields[i]).attr('type')||$(fields[i]).prop('tagName')).toLowerCase();
			  var name = $(fields[i]).attr('name');
			  var armario_vidrarias = ($(fields[i]).attr('data-armario') == 'vidrarias');
		  
			  // 
			  switch (type) {
                case "select":
                    if (name) {
                    	if (armario_vidrarias)
                    		data.armario_vidrarias[name] = $(fields[i]).val();
                    	else
                        	data[name] = $(fields[i]).val();
                    }
                break;
			    case "radio":
		            if (data[name] == undefined) {
		                var value = $('input[name="'+name+'"]:checked').val();
		                data[name] = value;
		            }
			    break;
			    case "checkbox":
			    	var node = fields[i];

			    	if (name && $(node).prop('checked')) {

                        var inicio = name.split('-')[0];

	    				var parent = $(node).parents('tr');

	    				var d;
	    				if (!armario_vidrarias) {
	                        if (!data[inicio]) data[inicio] = [];
                            d = data[inicio];
	                    } else {
	                    	if (!data.armario_vidrarias[inicio]) data.armario_vidrarias[inicio] = [];
                            d = data.armario_vidrarias[inicio];
	                    }

                        var vol = name.split('-').pop();
                        dvol = {};
                        
	    				$(parent).find('input,select').each(function () {
	    					var n = $(this).attr('data-name');
                            //if ($(this).val() == 'on') console.log(node, $(this).val())

                            if (n != 'disponiveis') 
	                            dvol[n] = $(this).val();                    
	                        else
	                        	dvol[n] = parseInt($(this).val());
						});

						dvol['id'] = counter+200;			
						counter++;
						//console.log(dvol)

    					if (armario_vidrarias) {
    						if (!data.armario_vidrarias[inicio])
    							data.armario_vidrarias[inicio] = [];

    						data.armario_vidrarias[inicio].push(dvol);
    					}
    					else
							data[inicio].push(dvol);
			    	}
			    break;
			    default:

			    break;
			  }
			}

			console.log(data);

      var id_pratica = $('.dadospratica').attr('data-id');

      //console.log(data)
      //console.log(data)
      //return false;

      $.ajax({
        url:'../area_laboratorio/data.php?action=salvar_pratica',
        method:'post',
        dataType: 'json',
        data: {
          disponivel:$('#pratica-disponivel').prop('checked')?1:0,          
          id: id_pratica,
          id_cenario: $('input[name="bancada"]:checked').val(),                    
          id_disciplina: dados_pratica.id_disciplina,
          nome: $('#nome_aula').val(),
          resumo: $('#resumo_aula').val(),
          data: JSON.stringify(data, null, "\t")
          //data: JSON.stringify(data, null, "\t")
        }
      }).done(function (data) {
      	alert('A aula foi salva com sucesso')
        $('.dadospratica').attr('data-id',data.id)
        //console.log($('.dadospratica').attr('data-id'), data.id)        
        dados_pratica.id = data.id;
      })

	}

		//campos();

	</script>
</div>
