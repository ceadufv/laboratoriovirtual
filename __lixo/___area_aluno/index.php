<?php include('../banco/sessao.php');
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Área do aluno</title>
  <!-- Arquivos externos -->
  <script src="../frameworks/jquery.js"></script>
  <script src="../frameworks/popper/dist/umd/popper.js"></script>
  <script src="../frameworks/bootstrap_js/bootstrap.js"></script>
  <link rel="stylesheet" href="../frameworks/bootstrap_css/bootstrap.css">
  <link rel="stylesheet" href="../frameworks/fontawesome/web-fonts-with-css/css/fontawesome-all.css">
  <!-- Arquivos próprios -->
  <link rel="stylesheet" href="../estilos/basicos.css">
  <link rel="stylesheet" href="../estilos/style.css">

  <script src="Configurador.js"></script>
</head>

<body>

  <div class="interno">

    <div class="container">
      <div class="row menu p-2">
        <div class="col">
          <h1><span>Laboratório de Química</span></h1>
          <h2>Aluno</h2>
        </div>
      </div>

      <section class="menu">
        <div class="botoes">
          <button class="opcoes ativo tab-criacao" onclick="aba('criacao')">Painel de controle</button>
          <!--
          <button class="opcoes tab-alunos" onclick="aba('alunos')">Gerenciar Alunos</button>
          <button class="opcoes tab-relatorios" onclick="aba('relatorios')">Relatórios</button>
          <button class="opcoes tab-conta" onclick="aba('conta')">Minha conta</button>
          <button class="opcoes tab-contato" onclick="aba('contato')">Ajuda</button>        
        -->
          <button class="opcoes tab-sair" onclick="sair()">Sair</button>
        </div>
      </section>

      <section class="conteudolinks">
        <div class="container">
          <div class="row">

           <!-- Seção para criação de práticas -->
           <div class="section div-secoes div-criacao opcoeslogin">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <div class="form">

                    <button onclick="formularioAcessarLaboratorio()">
                      <span>Acessar Laboratório</span> <i class="fas fa-angle-right"></i>
                    </button>                    
<!--
                    <button onclick="formularioCriacaoPratica()">
                      <span>Relatorios</span> <i class="fas fa-angle-right"></i>
                    </button>

                    <button onclick="formularioCriacao('-1')">
                      <span>Criar sem um modelo</span> <i class="fas fa-angle-right"></i>
                    </button>
-->
                  </div>
                </div>
              </div>
            </div>

          <!-- Conteúdo do formulário de criação -->
          <div class="section margem-superior oculta" id="div-formulario">

            <h2>Modelo: <span class="modelo-titulo"></span> <small>| <i class="fas fa-edit"></i></small></h2>
            
            <div class="tabela">

              <!-- Lista de vidrarias -->
              <h3>Vidrarias:</h3>
              <div class="row">
                <div class="col-md-6 mt-2">
                  <div class="form-inline">
                    <div class="input-group mb-3">
                      <select class="custom-select" id="listaNomes"></select>
                      <div class="input-group-append">
                        <label class="input-group-text" onclick="criar()">Adicionar</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Vidrarias cadastradas -->
              <div class="row">
                <div class="col-12" id="listaDados"></div>
              </div>

            </div>

          </div><!-- ./#div-formulario -->


          </div>

          <!-- Seção para gerar relatórios e feedback -->
          <div class="section div-secoes div-relatorios oculta">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <p>Gerar relatório e colher <i>feedback</i>. Nesta seção você poderá gerar relatórios sobre as práticas que você criou, assim como <i>feedbacks</i> enviados pelos alunos que você acomapanha.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Seção para gerenciar alunos acompanhados -->
          <div class="section div-secoes div-alunos oculta">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <p>Gerenciamento de alunos. Aqui é possível ver a lista de alunos que você acompanha, deletar do acompanhamento e adicionar novos.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal conta -->
          <div class="section div-secoes div-conta oculta">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <p>Conta</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal de contato -->
          <div class="section div-secoes div-contato oculta">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <p>Fale conosco</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </section>

  </div>



</div>
</div>

<!-- Modal de alterações cadastrais
<div class="modal div-conta" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="texto-icone-mx m-0">Alteração de dados cadastrais</p>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
 -->

<!-- Modal de contato
<div class="modal div-contato" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
-->  

<!-- Modal para seleção de prática modelo -->
<div class="modal div-pratica-modelo" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Escolha um modelo de prática</h3>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <select class="custom-select listaPraticasModelo"></select>
          <div class="input-group-append">
            <button class="input-group-text" onclick="formularioCriacao(1)">Selecionar</button>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>

<!-- Escolha uma prática -->
<div class="modal div-pratica" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Escolha uma prática</h3>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <select class="custom-select listaPraticasModelo"></select>
          <div class="input-group-append">
            <button class="input-group-text btn-acessar-pratica">Selecionar</button>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>


<!-- Seção de cadastro -->
<div class="modal div-cadastrar-usuario" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h3>Cadastrar usuário</h3>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

		<div class="modal-body">
		    <div class="input-group input-group-sm margem-inferior-p1">
		      <div class="input-group-prepend icone-formulario-principal">
		        <div class="input-group-text texto-icone icone-formulario-secundario">
		          <i class="far fa-user"></i>
		        </div>
		      </div>
		      <input type="text" class="form-control texto-icone" placeholder="Nome Completo" id="nomeCadastro">
		    </div>
		    <div class="input-group input-group-sm margem-inferior-p1">
		      <div class="input-group-prepend icone-formulario-principal">
		        <div class="input-group-text texto-icone icone-formulario-secundario"><i class="far fa-envelope"></i>
		        </div>
		      </div>
		      <input type="text" class="form-control texto-icone" placeholder="e-mail" id="emailCadastro">
		    </div>
		    <div class="input-group input-group-sm margem-inferior-p1">
		      <div class="input-group-prepend icone-formulario-principal">
		        <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-user-tag"></i>
		        </div>
		      </div>
		      <input type="text" class="form-control texto-icone" placeholder="Nome de Usuario" id="usuarioCadastro">
		    </div>
		    <div class="input-group input-group-sm margem-inferior-p1">
		      <div class="input-group-prepend icone-formulario-principal">
		        <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-user-lock"></i>
		        </div>
		      </div>
		      <input type="password" class="form-control texto-icone" placeholder="Senha" id="senhaCadastro">
		    </div>
		    <div class="input-group input-group-sm margem-inferior-p1">
		      <div class="input-group-prepend icone-formulario-principal">
		        <div class="input-group-text texto-icone icone-formulario-secundario" id="iconeAlt1"><i class="fas fa-question icone-alt"></i>
		        </div>
		      </div>
		      <select class="form-control texto-icone" onchange="alterarIconeTipo()" id="listaTipoUsuario">
		        <option value="">Tipo de usuário</option>
		        <option value="1">Estudante</option>
		        <option value="2">Professor</option>
		      </select>
		    </div>
    
		    <div class="text-center">
		      <button type="button" class="btn btn-sm botao-confirmar" onclick="cadastrarUsuario()">Confirmar</button>
		    </div>
		</div>

      </div>
    </div>
  </div>

<!-- Modal de configurações de objetos -->
<div class="modal" tabindex="-1" role="dialog" id="modalCriacao" vidrariaID="-1" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="textoGeral m-0" id="tituloModalConf">Configurar Vidraria</p>
      </div>

      <div class="modal-body" id="corpoModalConf">
        <!-- Formulário para escolha de tamanhos -->
        <div class="formularioadd vol oculta">
          <div class="form-inline textoIcone">
            <div class="col-6"><p>Tamanho</p></div>
            <div class="col-6"><select class="custom-select caixa-total" id="opcoesTamanho"></select></div>
          </div>
        </div>
        <!-- Formulário para preenchimento máximo -->
        <div class="formularioadd premax oculta">
          <div class="form-inline textoIcone">
            <div class="col-6"><p>Preenchimento máximo (%)</p></div>
            <div class="col-6"><input type="number" step='0.01' value='0.00' placeholder='0.00' min="0.00" class="form-control caixa-total" id="maximo"></div>
          </div>
        </div>
        <!-- Formulário para preenchimento mínimo -->
        <div class="formularioadd premin oculta">
          <div class="form-inline textoIcone">
            <div class="col-6"><p>Preenchimento mínimo (%)</p></div>
            <div class="col-6"><input type="number" step='0.01' value='0.00' placeholder='0.00' min="0.00" class="form-control caixa-total" id="minimo"></div>
          </div>
        </div>
        <!-- Formulário para desvio padrão -->
        <div class="formularioadd dp oculta">
          <div class="form-inline textoIcone">
            <div class="col-6"><p>Desvio padrão</p></div>
            <div class="col-6"><input type="number" step='0.01' value='0.00' placeholder='0.00' min="0.00" class="form-control caixa-total" id="desvio"></div>
          </div>
        </div>
        <!-- Formulário para rótulo que será exibido -->
        <div class="form-inline textoIcone">
          <div class="col-6"><p>Rótulo</p></div>
          <div class="col-6"><input type="text" class="form-control caixa-total" id="rotulo"></div>
        </div>
        <!-- Formulário para lista de substâncias -->
        <div class="formularioadd listainfo oculta">
          <div class="form-inline textoIcone">

            <div class="col-6"><p>Substâncias</p></div>
            <div class="col-3">
              <div class="botoessubstancias">
                <select class="custom-select float-left" id="opcoesSubstancia"></select>
                <input type="number" class="custom-select conc float-left" placeholder="Conc. mol/L">
                <button class="btn btn-outline-info float-left" onclick="addDadosFrasco()"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>

          <!-- Área para inserção de elementos da -->
          <div class="formularioadd listainfo oculta margemTop">
            <div class="opcoesadd textoIcone">
              <h3 class="text-center">Conteúdo</h3>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-danger btn-sm" onclick="cancelar()"><i class="fas fa-ban"></i> Cancelar</button>
        <button class="btn btn-success btn-sm" onclick="confirmar()"><i class="far fa-save"></i> Salvar</button>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid footer" id="contato">
  <div class="row">
    <div class="col-md-5 m-3">
      <div class="address">
        <img class="icone img-responsive" src="../imagens/endereco2.png">
        <div>
          <p>Prédio da CEAD, Avenida PH Rolfs s/n</p>
          <p>Campus Universitário, 36570-000, Viçosa/MG</p>
          <p>Telefones: (31) 3899 2858 | (31) 3899 3987</p>
          <p>E-mail: cead@ufv.br</p>
        </div>  
      </div>
    </div>
    <div class="col m-3">
      <div class="logos">
        <div class="parceiros">
          <div>
            <h3>Parceiros:</h3>
          </div>
          <div>
            <hr>
            <a href="http://www.capes.gov.br/uab" target="blank"><img src="../imagens/uab2.png"></a>
            <a href="http://www.capes.gov.br/" target="blank"><img src="../imagens/capes2.png"></a>
            <a href="http://www.ufv.br" target="blank"><img src="../imagens/ufv2.png"></a>
          </div>
        </div>
        <div class="realizacao">
          <div>
            <h3>Realização:</h3>
          </div>
          <div>
            <hr>
            <a href="http://www.cead.ufv.br" target="blank"><img src="../imagens/cead.png"></a>
            <a href="http://www.deq.ufv.br" target="blank"><img src="../imagens/deq.png"></a>
          </div>
        </div>
      </div>
    </div>
    <div class="w-100"></div>
    <div class="col copyright">
      <div class="float-left">
        <h4>©2018 - Todos os Direitos Reservados - Desenvolvido pela Cead</h4>
      </div>
      <div class="float-right creative">
        <img src="https://acervo.cead.ufv.br/wp-content/themes/acervo/img/creativecommons.png">
        <p><small>Exceto onde indicado de outra forma, todos os conteúdos disponibilizados nesta página são licenciados sob uma licença Creative Commons</small></p>
      </div>
    </div>
  </div>
</footer>

<script src="tela_professor.js"></script>	
<script src="../js/cadastrar.js"></script>
<script>

  var configurador = new Configurador();
  init();

  function cadastrarUsuario() {
  	cadastrar('../banco/data.php', function (res) {
  		$('.div-cadastrar-usuario').modal('hide');
  	});
  }

  function sair() {
    window.location = '../';
  }
</script>

</body>
</html>
