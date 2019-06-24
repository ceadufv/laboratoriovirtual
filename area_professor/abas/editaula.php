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
        <button class="botao_editar_solucao btn verde" onclick="editar_solucao()" class="btn btn-primary" data-toggle="modal" data-target=".modal-edit-solucao"><i class="fa fa-pen"></i> EDITAR SOLUÇÃO</button>      	
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
         <select name="bequer_ambientacao" class="custom-select bequer-ambientacao bequer" data-name="bequer_ambientacao">
            <option value="auto">Automática</option>
            <option value="manual">Manual</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
        <select data-name="bequer_quantidade" name="bequer_quantidade" class="custom-select bequer-qtd_ambientes">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
        <select data-name="bequer_agitacao" name="bequer_agitacao" class="custom-select bequer-agitacao">
            <option value="auto">Automático</option>
            <option value="manual">Manual</option>
        </select>
    </div>
    <div class="col-auto">
        <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
        <select data-name="bequer_mistura" name="bequer_mistura" class="custom-select bequer-mistura bequer">
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
                        <input value="<?php echo $valor; ?>" data-name="id" name="bequer" class="bequer-disponivel bequer" type="checkbox" 
                        onclick="toggle(this)" /> <span><?php echo $valor;?> mL</span>
                    </td>
                    <td>  
                        <input data-name="qtd_maxima" class="bequer-qtd_maxima bequer" type="number" min="0" max="10" value="0">
                    </td>
                    <td> 
                        <input data-name="volume_maximo" class="bequer-volume_maximo bequer" type="number" min="80" max="95" value="80">
                    </td>
                    <td> 
                        <input data-name="desvio_padrao" class="bequer-desvio_padrao bequer" type="number" min="5" max="20" value="10">
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
    <select data-name="balaovolumetrico_ambientacao" name="balaovolumetrico_ambientacao" class="custom-select balaovolumetrico-ambientacao balaovolumetrico" >
        <option value="auto">Automática</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
    <select data-name="balaovolumetrico_qtd_ambientes"  name="balaovolumetrico_qtd_ambientes" class="custom-select balaovolumetrico-qtd_ambientes balaovolumetrico">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
    <select data-name="balaovolumetrico_agitacao" name="balaovolumetrico_agitacao" class="custom-select balaovolumetrico-agitacao balaovolumetrico">
        <option value="auto">Automático</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
    <select data-name="balaovolumetrico_mistura" name="balaovolumetrico_mistura" class="custom-select balaovolumetrico-mistura balaovolumetrico">
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
                <input data-name="id" class="balaovolumetrico-disponivel balaovolumetrico" type="checkbox" 
                    onclick="toggle(this)" name="balao" value="<?php echo($valor) ?>"> <span><?php echo $valor;?> mL</span>
            </td>
            <td>  
                <input data-name="qtd_maxima" class="balaovolumetrico-qtd_maxima balaovolumetrico" type="number" min="0" max="10" value="0">
            </td>
            <td> 
                <input data-name="faixa_aceitavel" class="balaovolumetrico-faixa_aceitavel balaovolumetrico" type="number" min="90" max="110" value="110">
            </td>
            <td> 
                <input data-name="desvio_padrao" class="balaovolumetrico-desvio_padrao balaovolumetrico" type="number" min="0.0" max="1.0" step="0.01"  value="0.01">
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
    <select class="custom-select" name="pipetavolumetrica_ambientacao">
        <option value="auto">Automática</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Quantidade de ambientações necessárias">Número de vezes a ambientar</h3>
    <select class="custom-select" name="pipetavolumetrica_qtd_ambientes">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Método de agitação">Agitação</h3>
    <select class="custom-select" name="pipetavolumetrica_agitacao">
        <option value="auto">Automático</option>
        <option value="manual">Manual</option>
    </select>
    <h3 data-toggle="tooltip" data-placement="bottom" title="Permite a mistura de outra solução ao béquer ambientado e sem volume definido">Mistura</h3>
    <select class="custom-select pipetavolumetrica-mistura" name="pipetavolumetrica_mistura">
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
                <input data-name="id" name="pipeta" class="pipetavolumetrica-disponivel pipetavolumetrica" type="checkbox" 
                    onclick="toggle(this)" value="<?php echo $valor;?>"> <span><?php echo $valor;?> mL</span>
            </td>
            <td>  
                <input data-name="qtd_maxima" class="pipetavolumetrica-qtd_maxima pipetavolumetrica" type="number" min="0" max="10" value="0">
            </td>
            <td> 
                <input data-name="faixa_aceitavel" class="pipetavolumetrica-faixa_aceitavel pipetavolumetrica" type="number" min="90" max="110" value="110">
            </td>
            <td> 
                <input data-name="desvio_padrao" class="pipetavolumetrica-desvio_padrao pipetavolumetrica" type="number" min="0.0" max="1.0" step="0.01"  value="0.01">
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
	  <select disabled class="custom-select" name="pipetador_animacao">
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
	          <input data-name="id" name="pipetador" class="pipetador-disponivel pipetador" type="checkbox" 
	                onclick="toggle(this)" value="<?php echo $key;?>" /> <span class="nomepipetador"><?php echo $valor;?></span>
	        </td>
	        <td>
	        <img data-name="imagem" src="accordion/pipetadores/<?php echo($key) ?>.jpg" width="100">
	        </td>
	        <td>
	          <select name="pipetador_tamanho" disabled>
	            <option value="unico">Único</option>
	          </select>
	        </td>
	        
	        <td>  
	            <input name="qtd_maxima" data-name="qtd_maxima" disabled type="number" min="0" max="2" value="1">
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
  <select disabled name="micropipeta_animacao">
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
            <input class="micropipeta-disponivel micropipeta" type="checkbox" 
                   onclick="toggle(this)" value="<?php echo $valor;?>"> <span><?php echo $valor;?> µL</span>
            </td>
            <td>  
                <input class="micropipeta-qtd_maxima micropipeta" type="number" min="0" max="10" value="0">
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
- Implementar a area de upload das apostilas
- 
*/
        function carregar() {
            var data = {
               "solucoes":[
					{
						nome: 'Solução 1',
						descricao: 'Descricao 1',
						tecnico: 'Tecnico 1',
						criacao: 1,
						especies: [
							{ id: 1, concentracao:0.1 },
							{ id: 2, concentracao:0.2 },
							{ id: 3, concentracao:0.3 }
						]
					},
					{
						nome: 'Solução 2',
						descricao: 'Descricao 2',
						tecnico: 'Tecnico 3',
						criacao: 2,
						especies: [
							{ id: 4, concentracao:0.4 },
							{ id: 5, concentracao:0.5 },
							{ id: 6, concentracao:0.6 }
						]
					},					
               ],
               "bancada":"2",
               "bequer_ambientacao":"manual",
               "bequer_quantidade":"3",
               "bequer_agitacao":"manual",
               "bequer_mistura":"false",
               "bequer":[
                  {
                     "id":"50",
                     "qtd_maxima":"3",
                     "volume_maximo":"80",
                     "desvio_padrao":"10"
                  },
                  {
                     "id":"100",
                     "qtd_maxima":"3",
                     "volume_maximo":"80",
                     "desvio_padrao":"10"
                  },
                  {
                     "id":"250",
                     "qtd_maxima":"2",
                     "volume_maximo":"80",
                     "desvio_padrao":"10"
                  }
               ],
               "balaovolumetrico_ambientacao":"auto",
               "balaovolumetrico_qtd_ambientes":"1",
               "balaovolumetrico_agitacao":"auto",
               "balaovolumetrico_mistura":"false",
               "balao":[
                  {
                     "id":"25",
                     "qtd_maxima":"3",
                     "faixa_aceitavel":"110",
                     "desvio_padrao":"0.01"
                  },
                  {
                     "id":"50",
                     "qtd_maxima":"3",
                     "faixa_aceitavel":"110",
                     "desvio_padrao":"0.01"
                  },
                  {
                     "id":"100",
                     "qtd_maxima":"3",
                     "faixa_aceitavel":"110",
                     "desvio_padrao":"0.01"
                  }
               ],
               "pipetavolumetrica_ambientacao":"manual",
               "pipetavolumetrica_qtd_ambientes":"1",
               "pipetavolumetrica_agitacao":"auto",
               "pipetavolumetrica_mistura":"false",
               "pipeta":[
                  {
                     "id":"5",
                     "qtd_maxima":"3",
                     "faixa_aceitavel":"110",
                     "desvio_padrao":"0.01"
                  },
                  {
                     "id":"10",
                     "qtd_maxima":"3",
                     "faixa_aceitavel":"110",
                     "desvio_padrao":"0.01"
                  }
               ],
               "pipetador_animacao":"auto",
               "pipetador_tamanho":"unico",
               "micropipeta_animacao":"auto"
            };

            for (var i in data) {
                carregaCampo(i, data[i]);
            }
        } 

        function carregaCampo(campo, valor) {
            var obj = $('*[name="'+campo+'"]');

            //
            if ($(obj).attr('type') == 'radio') {
                $(obj).each(function () {
                    var check = ($(this).val() == valor);
                    $(this).prop('checked',check);
                });
            }

            //
            if ($(obj).attr('type') == 'checkbox') {


                $(obj).each(function () {
                    var existe = false;
                    for (var i = 0 ; i < valor.length ; i++) {
                        if (valor[i].id == $(this).val()) {
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
        /*

            // Limpa os campos atuais
            $('*[type=checkbox]').each(function () {
                $(this).prop('checked',false);
            })


        */

		function campos() {
			var data = {};
			var fields = $('input,select:not([data-id])');

            //data.config = [];
			data.solucoes = [];

			$('.id_solucoes_pratica').each(function () {
				data.solucoes.push($(this).attr('data-id'));
			});

			for (var i = 0 ; i < fields.length ; i++) {
			  //
			  var type = ($(fields[i]).attr('type')||$(fields[i]).prop('tagName')).toLowerCase();
			  var name = $(fields[i]).attr('name');

			  // 
			  switch (type) {
                case "select":
                    //data[name] = $(fields[i]).val();
                    if (name) {
                        data[name] = $(fields[i]).val();
                        //console.log(fields[i], ':: ', $(fields[i]).val())
                    }
                    /* else {
                        console.log(fields[i])
                    }*/
                break;
			    case "radio":
                    console.log(data[name], name);
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
                        
	    				$(parent).find('input,select').each(function () {
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
            console.log(data)
			// console.log(JSON.stringify(data));
		}

		//campos();

	</script>
</div>
