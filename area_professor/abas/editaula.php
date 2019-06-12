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
      <button class="botao_criar_solucao btn azul" onclick="criar_solucao()" class="btn btn-primary" data-toggle="modal" data-target=".modal-edit-solucao"><i class="fas fa-plus-circle"></i> CRIAR NOVA SOLUÇÃO</button>
    </h3>

    <div class="composicao">

      <div>
        <select id="select_solucoes" class="custom-select">
          <?php 
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
          ?>
        </select>
        <div class="composicao_solucao_option"><h4>COMPOSIÇÃO: <?php echo $o[0]['descricao'] ?></h4></div>
      </div>
      <div>
        <button class="botao_adicionar btn verde" onclick="adicionar_solucao_armario()">Adicionar ao Armário de Soluções</button>
        <button class="botao_editar_solucao btn verde" onclick="editar_solucao()" class="btn btn-primary" data-toggle="modal" data-target=".modal-edit-solucao">EDITAR SOLUÇÃO</button>
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

  <div class="modal fade bd-example-modal-lg modal-edit-solucao" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <?php include('funcoes/edit_solucao.php') ?>
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
        <select class="custom-select bequer-ambientacao bequer-<?php echo($valor) ?> " >
            <option value="auto">Automática</option>
            <option value="manual">Manual</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
        <select class="custom-select bequer-qtd_ambientes bequer-<?php echo($valor) ?> ">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
        <select class="custom-select bequer-agitacao bequer-<?php echo($valor) ?> ">
            <option value="auto">Automático</option>
            <option value="manual">Manual</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
        <select class="custom-select bequer-mistura bequer-<?php echo($valor) ?> ">
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
                ?>
                <tr class="linha-bequer" data-id="<?php echo $valor; ?>">
                    <td style="text-align: left;">  
                        <input value="<?php echo $valor; ?>" data-name="id" name="bequer-<?php echo($valor); ?>" class="bequer-disponivel bequer-<?php echo($valor); ?>" type="checkbox" 
                        onclick="ativacao_itens(this,<?php echo $valor;?>)" /> <span><?php echo $valor;?> mL</span>
                    </td>
                    <td>  
                        <input data-name="qtd_maxima" class="bequer-qtd_maxima bequer-<?php echo($valor) ?>" type="number" min="0" max="10" value="0">
                    </td>
                    <td> 
                        <input data-name="volume_maximo" class="bequer-volume_maximo bequer-<?php echo($valor) ?>" type="number" min="80" max="95" value="80">
                    </td>
                    <td> 
                        <input data-name="desvio_padrao" class="bequer-desvio_padrao bequer-<?php echo($valor) ?>" type="number" min="5" max="20" value="10">
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
    <select name="balaovolumetrico_ambientacao" class="custom-select balaovolumetrico-ambientacao balaovolumetrico-<?php echo($valor) ?> " >
        <option value="auto">Automática</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
    <select name="balaovolumetrico_qtd_ambientes" class="custom-select balaovolumetrico-qtd_ambientes balaovolumetrico-<?php echo($valor) ?> ">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
    <select name="balaovolumetrico_agitacao" class="custom-select balaovolumetrico-agitacao balaovolumetrico-<?php echo($valor) ?> ">
        <option value="auto">Automático</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
    <select name="balaovolumetrico_mistura" class="custom-select balaovolumetrico-mistura balaovolumetrico-<?php echo($valor) ?> ">
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
            ?>
            <tr class="linha-balaovolumetrico" data-id="<?php echo $valor; ?>">
            <td style="text-align: left;">  
                <input data-name="id" class="balaovolumetrico-disponivel balaovolumetrico-<?php echo($valor) ?>" type="checkbox" 
                    onclick="ativacao_itens(this,<?php echo $valor;?>)" name="balao-<?php echo($valor) ?>" value="<?php echo($valor) ?>"> <span><?php echo $valor;?> mL</span>
            </td>
            <td>  
                <input data-name="qtd_maxima" class="balaovolumetrico-qtd_maxima balaovolumetrico-<?php echo($valor) ?>" type="number" min="0" max="10" value="0">
            </td>
            <td> 
                <input data-name="faixa_aceitavel" class="balaovolumetrico-faixa_aceitavel balaovolumetrico-<?php echo($valor) ?>" type="number" min="90" max="110" value="110">
            </td>
            <td> 
                <input data-name="desvio_padrao" class="balaovolumetrico-desvio_padrao balaovolumetrico-<?php echo($valor) ?>" type="number" min="0.0" max="1.0" step="0.01"  value="0.01">
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
    <select class="custom-select pipetavolumetrica-ambientacao pipetavolumetrica-<?php echo($valor) ?> " >
        <option value="auto">Automática</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
    <select class="custom-select pipetavolumetrica-qtd_ambientes pipetavolumetrica-<?php echo($valor) ?> ">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
    <select class="custom-select pipetavolumetrica-agitacao pipetavolumetrica-<?php echo($valor) ?> ">
        <option value="auto">Automático</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
    <select class="custom-select pipetavolumetrica-mistura pipetavolumetrica-<?php echo($valor) ?> ">
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
            ?>
            <tr class="linha-pipetavolumetrica" data-id="<?php echo $valor; ?>">
            <td style="text-align: left;">  
                <input data-name="id" name="pipeta-<?php echo($valor) ?>" class="pipetavolumetrica-disponivel pipetavolumetrica-<?php echo($valor) ?>" type="checkbox" 
                    onclick="ativacao_itens(this,<?php echo $valor;?>)" value="<?php echo $valor;?>"> <span><?php echo $valor;?> mL</span>
            </td>
            <td>  
                <input data-name="qtd_maxima" class="pipetavolumetrica-qtd_maxima pipetavolumetrica-<?php echo($valor) ?>" type="number" min="0" max="10" value="0">
            </td>
            <td> 
                <input data-name="faixa_aceitavel" class="pipetavolumetrica-faixa_aceitavel pipetavolumetrica-<?php echo($valor) ?>" type="number" min="90" max="110" value="110">
            </td>
            <td> 
                <input data-name="desvio_padrao" class="pipetavolumetrica-desvio_padrao pipetavolumetrica-<?php echo($valor) ?>" type="number" min="0.0" max="1.0" step="0.01"  value="0.01">
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
	  <select disabled class="custom-select pipetador-animacao pipetador-<?php echo($valor) ?> " >
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
	          "Pera", "Pi-pump2" , "Pi-pump5" , "Pi-pump10", "Macropipetador", "Automático"
	        );
	        foreach ($valores as $valor):
	      ?>
	      <tr class="linha-pipetador" data-id="<?php echo $valor; ?>">
	        <td style="text-align: left;">  
	          <input data-name="id" name="pipetador-<?php echo($valor) ?>" class="pipetador-disponivel pipetador-<?php echo($valor) ?>" type="checkbox" 
	                onclick="ativacao_itens(this,'<?php echo $valor;?>')" value="<?php echo $valor;?>" /> <span class="nomepipetador"><?php echo $valor;?></span>
	        </td>
	        <td>
	        <img src="accordion/pipetadores/<?php echo($valor) ?>.jpg"  width="100">
	        </td>
	        <td>
	          <select data-name="tamanho" disabled class="custom-select pipetador-tamanho pipetador-<?php echo($valor) ?> ">
	            <option value="unico">Único</option>
	          </select>
	        </td>
	        
	        <td>  
	            <input data-name="qtd_maxima" disabled class="pipetador-qtd_maxima pipetador-<?php echo($valor) ?>" type="number" min="0" max="2" value="1">
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
  <select disabled class="custom-select micropipeta-animacao micropipeta-<?php echo($valor) ?> " >
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
        ?>
        <tr class="linha-micropipeta" data-id="<?php echo $valor; ?>">
            <td style="text-align: left;">  
            <input class="micropipeta-disponivel micropipeta-<?php echo($valor) ?>" type="checkbox" 
                   onclick="ativacao_itens(this,'<?php echo $valor;?>')" value="<?php echo $valor;?>"> <span><?php echo $valor;?> µL</span>
            </td>
            <td>  
                <input class="micropipeta-qtd_maxima micropipeta-<?php echo($valor) ?>" type="number" min="0" max="10" value="0">
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
							<button disabled class="btn btn-link collapsed" data-toggle="collapse" data-target="#cubeta" aria-expanded="false" aria-controls="collapseThree">
								<strong><i class="fas fa-check-circle"></i> Cubeta</strong>
								<i class="fa" aria-hidden="true"></i>
							</button>
						</h5>
					</div>
					<div id="cubeta" class="collapse" aria-labelledby="headingThree">
						<div class="card-body">
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
				<button id = "salvar" type="button" class="btn btn-outline-primary" onclick="salvaOuAtualiza()">Salvar</button>
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

		function campos() {
			var data = {};
			var fields = $('input');


			data.solucoes = [];
			$('.id_solucoes_pratica').each(function () {
				data.solucoes.push($(this).attr('data-id'));
			});

			console.log(data.solucoes)


			for (var i = 0 ; i < fields.length ; i++) {
			  //
			  var type = $(fields[i]).attr('type');
			  var name = $(fields[i]).attr('name');

			  // 
			  switch (type) {
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

                        if (!data[inicio]) data[inicio] = [];
                        var d = data[inicio];
                        var vol = name.split('-').pop();
                        dvol = {};
                        
	    				$(parent).find('input').each(function () {
	    					var n = $(this).attr('data-name');

                            if ($(this).val() == 'on') console.log(node, $(this).val())
                            dvol[n] = $(this).val();
	    				});
                        data[inicio].push(dvol);
			    	}
			    break;
			    default:

			    break;
			  }
			}
			console.log(data);
		}

		campos();

	</script>
</div>
