<?php
/**
 * Arquivo de configuração
 * @version 1.0.0
*/
$action = @$_REQUEST['action'];
$error = @$_REQUEST['error'];
$path = pathinfo(__FILE__);
$config_file = $path['dirname'] . "/lab-config.php";
$error_message = @$_REQUEST['error_message'];
$error_title = @$_REQUEST['error_title'];
$debug = @$_REQUEST['debug'];
$database_created = 0;

// Estados
$estado = "index";

// Verifica o estado atual do processo de instalacao
switch ($action) {
  case "criar-config":
    $estado = "erro-criar-config";

    // Verifica se conseguira escrever no arquivo
    if (is_writeable($config_file)) {
      $estado = "criar-config";
    }

    $db_name = @$_REQUEST['db_name'];
    $db_user = @$_REQUEST['db_user'];
    $db_password = @$_REQUEST['db_password'];
    $db_host = @$_REQUEST['db_host'];

    $file = sprintf("<?php
/**
* As configurações básicas do Laboratorio Virtual de Quimica
*/

define('DB_NAME', '%s');
define('DB_USER', '%s');
define('DB_PASSWORD', '%s');
define('DB_HOST', '%s');
define('LAB_DEBUG', false);

/** Caminho absoluto para o diretório raiz */
if ( !defined('ABSPATH') ) define('ABSPATH', dirname(__FILE__) . '/');
?>
", addslashes($db_name), addslashes($db_user), addslashes($db_password), addslashes($db_host));

    break;
  case "instalar":
    $estado = "erro-criar-config";

    // Verifica se o arquivo lab-config.php existe e se possui as constantes esperadas
    if (file_exists($config_file)) {
      @include($config_file);

      if (
        defined('DB_NAME') &&
        defined('DB_USER') &&
        defined('DB_HOST')
      ) {
        $estado = "instalar";
      }
    }

    if ($estado != "instalar") {
      header("location:install.php?action=error&error_title=" . urlencode("Erro no arquivo de configuração") . "&error_message=" . urlencode("Não foi possível criar o arquivo \"$config_file\"."));
      exit;
    }
    break;
}

// Executa a acao esperada para o estado atual
switch ($estado) {
  case "criar-config":
    // Cria o arquivo de configuracao
    $fp = @fopen($config_file, "w+");
    $fwrite = @fwrite($fp, $file);
    @fclose($fp);

    if ($fwrite) {
      header("location:install.php?action=instalar");
      exit;
    } else {
      header("location:install.php?action=error&error_title=" . urlencode("Erro no arquivo de configuração") . "&error_message=" . urlencode("O arquivo \"$config_file\" não foi criado corretamente."));
      exit;
    }
    break;
  case "instalar":
    // Tenta se conectar
    include "banco/conexao.php";

    // Se a conexao falhar
    if (!$dbh) {
      header("location:install.php?action=error&error_title=" . urlencode("Erro ao tentar acessar o banco de dados") . "&error_message=" . urlencode($error_message));
      exit;
    }

    $new_password = str_pad(rand(0, 99999), 5, "0", STR_PAD_LEFT);
    $sql = file_get_contents("quimica.sql");
    $sql = str_replace("__MYSENHA__", sha1($new_password), $sql);

    if ($dbh) {
      try {
        $database_created = $dbh->exec($sql);
      } catch (PDOException $e) {
        $error_message = $e->getMessage();
        header("location:install.php?action=error&error_title=" . urlencode("Erro ao tentar escrever no banco de dados") . "&error_message=" . urlencode($error_message));
        exit;
      }
    }
    break;
}

echo $estado;
?>
    <!DOCTYPE html>
    <html>

    <head>
      <meta charset="UTF-8">
      <title>NeoAlice</title>
      <!-- Arquivos externos -->

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
      <!-- <link rel="stylesheet" href="frameworks/fontawesome/web-fonts-with-css/css/fontawesome-all.css"> -->
      <!-- Arquivos próprios -->
      <link rel="stylesheet" href="estilos/basicos.css">
      <link rel="stylesheet" href="estilos/style.css">

      <link rel="shortcut icon" type="image/png" href="imagens/favicon.png" />

    </head>

    <body>

      <div class="section login">
        <div class="container">
          <div class="row d-flex justify-content-center align-items-center">

            <div class="caixinha interna">
              <h1><br />Laboratório Virtual de Química</h1>
              <h2>Universidade Federal de Viçosa</h2>

              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon points="0,0 0,100 100,100" />
              </svg>
              <div class="content">
                <?php
                if ($error_message) {
                  ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo "<strong>" . $error_title . ":</strong> " . $error_message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php
                }
                ?>
                <?php



                if ($estado == "index") :
                  ?>
                  <!--  -->
                  <form class="opcoeslogin" method="post" action="install.php?action=criar-config">

                    <h3>Instalação do Banco de Dados</h3>
                    <p>
                      <small>O laboratório virtual precisa de um banco de dados MySQL para funcionar. Informe a seguir os dados para criação do banco</small>
                    </p>

                    <div class="">
                      <div class="input-group input-group-sm margem-inferior-p1">
                        <div class="input-group-prepend icone-formulario-principal">
                          <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-server"></i></div>
                        </div>
                        <input type="text" name="db_host" class="form-control texto-icone" placeholder="Servidor">
                      </div>
                    </div>

                    <div class="">
                      <div class="input-group input-group-sm margem-inferior-p1">
                        <div class="input-group-prepend icone-formulario-principal">
                          <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-database"></i></div>
                        </div>
                        <input type="text" name="db_name" class="form-control texto-icone" placeholder="Nome do banco de dados">
                      </div>
                    </div>

                    <div class="">
                      <div class="input-group input-group-sm margem-inferior-p1">
                        <div class="input-group-prepend icone-formulario-principal">
                          <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-user-tag"></i></div>
                        </div>
                        <input type="text" name="db_user" class="form-control texto-icone" placeholder="Usuário" id="usuarioLogin">
                      </div>
                      <div class="input-group input-group-sm margem-inferior-p1">
                        <div class="input-group-prepend icone-formulario-principal">
                          <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-key"></i></div>
                        </div>
                        <input type="password" name="db_password" class="form-control texto-icone" placeholder="Senha" id="senhaLogin">
                      </div>
                    </div>

                    <button type="submit" class="btn btn-block">Instalar Laboratório</button>

                    <div class="text-center texto-icone-p margem-superior-p1" id="logLogin">
                      <p class="log-login"></p>
                    </div>
                  </form>
                <?php
                endif;

                //if ($estado == "criar-config"):
                if ($estado == "erro-criar-config") {
                  ?>
                  <form class="opcoeslogin" method="post" action="install.php?action=instalar">
                    <div class="form-group">
                      <strong></strong>
                      <label for="">Não foi possível criar o arquivo "lab-config.php". Por gentileza, copie o conteudo abaixo e crie o arquivo manualmente no seguinte caminho: <?php
                                                                                                                                                                                  echo $config_file;
                                                                                                                                                                                  ?></label>
                      <textarea class="form-control" rows="7" style="font-family: courier; font-weight: normal"><?php echo $file; ?></textarea>

                      <button type="submit" class="btn btn-block">Continuar instalando</button>
                    </div>
                  </form>
                <?php
                }

                if ($estado == "instalar") {
                  ?>
                  <form class="opcoeslogin" method="post" action="index.php">
                    <div class="form-group">
                      <?php if ($database_created === 0) : ?>
                        <strong>Laboratório instalado com sucesso!</strong>
                        Anote as credenciais abaixo. Você irá precisar delas para acessar o laboratório<br /><br />
                        <div class="alert alert-success" role="alert">
                          <strong>Usuário:</strong> admin<br />
                          <strong>Senha:</strong> <?php echo $new_password; ?>
                        </div>
                        <button type="submit" class="btn btn-block">Acessar o laboratório</button>
                      <?php else : ?>
                        <strong>O banco de dados já existe!</strong>
                        Já existe uma instalação do laboratório no banco de dados '<?php echo DB_NAME; ?>'. Clique em acessar o laboratório se quiser prosseguir utilizando a instalação atual.<br /><br />
                        <button type="submit" class="btn btn-block">Acessar o laboratório</button>
                      <?php endif; ?>
                    </div>
                  </form>
                <?php
                }
                //endif;
                ?>
                <div class="logomarcas">
                  <!--
              <h3>Realização:</h3>
              <div>

              </div>
            -->
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

    </body>

    </html>