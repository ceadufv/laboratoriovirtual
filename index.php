<?php
if (!file_exists("lab-config.php")) 
  header("location:install.php");

include "lab-config.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <!-- responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NeoAlice</title>
  <!-- jquery -->
  <script src="<?php echo URL_SITE; ?>plugins/vendor/jquery/3.4/jquery-3.4.1.min.js"></script>
  <script src="<?php echo URL_SITE; ?>plugins/vendor/jquery/3.4/jquery-migrate-1.4.1.min.js"></script>

  <!-- bootstrap -->
  <script src="<?php echo URL_SITE; ?>plugins/vendor/bootstrap/4.3.1/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo URL_SITE; ?>plugins/vendor/bootstrap/4.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="<?php echo URL_SITE; ?>plugins/vendor/bootstrap/4.3.1/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="<?php echo URL_SITE; ?>plugins/vendor/fontawesome/5.11.2/css/all.css">
  <link rel="shortcut icon" type="image/png" href="<?php echo URL_SITE; ?>imagens/icons/favicon.png" />

  <!-- Arquivos próprios -->
  <link rel="stylesheet" href="estilos/basicos.css">
  <link rel="stylesheet" href="estilos/style.css">
</head>

<body>
  <div class="section login">
    <div class="container">
      <div class="row d-flex justify-content-center align-items-center">

        <div class="caixinha interna">
          <h1><small>Bem-vindo à NeoAlice</small><br />Laboratório Virtual de Química</h1>
          <h2>UFV - 2019</h2>

          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
            <polygon points="0,0 0,100 100,100" />
          </svg>
          <div class="content">

            <form class="opcoeslogin">

              <h3>Insira suas credenciais de acesso ao laboratório</h3>

              <div class="usuariosenha">

                <div class="input-group input-group-sm margem-inferior-p1">
                  <div class="input-group-prepend icone-formulario-principal">
                    <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-user-tag"></i></div>
                  </div>
                  <input type="text" class="form-control texto-icone" placeholder="NOME DE USUÁRIO" id="usuarioLogin">
                </div>
                <div class="input-group input-group-sm margem-inferior-p1">
                  <div class="input-group-prepend icone-formulario-principal">
                    <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-user-lock"></i></div>
                  </div>
                  <input type="password" class="form-control texto-icone" placeholder="SENHA" id="senhaLogin">
                </div>
              </div>
              <button type="button" class="btn btn-primary" onclick="login()">CONFIRMAR</button>

              <div class="loginsenha">
                <!-- <a href="#">Esqueci o login/senha </a> -->
                <a href="javascript:void();" class="botao-cadastrar" onclick="abrirCadastro()">Quero me cadastrar</a>
              </div>

              <div class="text-center texto-icone-p margem-superior-p1" id="logCadastrar"></div>
              <div class="text-center texto-icone-p margem-superior-p1" id="logLogin">
                <p class="log-login">

                </p>
              </div>
            </form>
          </div>
        </div>

        <!-- Seção de cadastro -->
        <div class="section conteudo div-cadastro oculta opcoeslogin">
          <div class="content">
            <h2>CADASTRO DE USUÁRIO</h2>

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
              <input type="text" class="form-control texto-icone" placeholder="NOME DE USUÁRIO" id="usuarioCadastro">
            </div>
            <div class="input-group input-group-sm margem-inferior-p1">
              <div class="input-group-prepend icone-formulario-principal">
                <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-user-lock"></i>
                </div>
              </div>
              <input type="password" class="form-control texto-icone" placeholder="SENHA" id="senhaCadastro">
              <input type="hidden" id="listaTipoUsuario" value="1" />
            </div>

            <div class="input-group input-group-sm margem-inferior-p1">
              <div class="input-group-prepend icone-formulario-principal">
                <div class="input-group-text texto-icone icone-formulario-secundario" id="iconeAlt1"><i class="fas fa-question icone-alt"></i>
                </div>
              </div>
              <select class="form-control texto-icone" onchange="alterarIconeTipo()" id="listaTipoUsuario">
                <option value="">Tipo de usuário</option>
                <option value="1" selected>Estudante</option>
                <option value="2" disabled>Professor</option>
              </select>
            </div>

            <div class="text-center">
              <button type="button" class="btn btn-sm botao-confirmar" onclick="cadastrarUsuario()">Confirmar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="container-fluid footer" id="contato">
    <div class="row">
      <div class="col-md-5 m-3">
        <div class="address">
          <img class="icone img-responsive" src="imagens/endereco2.png">
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
              <h3>Realização:</h3>
            </div>
            <div>
              <hr>
              <a href="http://www.ufv.br" target="blank"><img src="imagens/UFV.png"></a>
              <a href="http://www.cead.ufv.br" target="blank"><img src="imagens/cead.png"></a>
              <a href="http://www.deq.ufv.br" target="blank"><img src="imagens/GPEQA.png"></a>
              <a href="http://www.capes.gov.br/uab" target="blank"><img src="imagens/uab2.png"></a>
              <a href="http://www.capes.gov.br/" target="blank"><img src="imagens/capes2.png"></a>
            </div>
          </div>
        </div>
      </div>
      <div class="w-100"></div>
      <div class="col copyright">
        <div class="float-left">
          <h4>©2019 - Todos os Direitos Reservados - Desenvolvido pela Cead</h4>
        </div>
        <div class="float-right creative">
          <img src="https://acervo.cead.ufv.br/wp-content/themes/acervo/img/creativecommons.png">
          <p><small>Exceto onde indicado de outra forma, todos os conteúdos disponibilizados nesta página são licenciados sob uma licença Creative Commons</small></p>
        </div>
      </div>
    </div>
  </footer>
  <script src="js/cadastrar.js"></script>
  <script src="js/pages/index.js"></script>
</body>

</html>