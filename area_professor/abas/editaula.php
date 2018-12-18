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
								<h4><input type="radio" value ="1" name="bancada" checked> pHmetro </h4>
							</div>
							<div class="radio">
								<h4><input type="radio" value ="2" name="bancada"> Espectrofotômetro </h4>
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
							<?php include("accordion/solucoes.php"); ?>
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
							<?php include("accordion/bequer.php"); ?>
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
							<?php include("accordion/balaovolumetrico.php"); ?>
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
							<?php include("accordion/pipetavolumetrica.php"); ?>
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
							<?php include("accordion/pipetador.php"); ?>
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
							<?php include("accordion/micropipeta.php"); ?>	
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
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
	</script>
</div>