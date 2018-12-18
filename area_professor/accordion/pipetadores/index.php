<?php 
  include('../../banco/sessao.php');
?>
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8">
    <title>Pipetador - Construção da Aula</title>

    <link rel="stylesheet" href="../../awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts.js"></script>
  </head>
  <body>
    <header>
      <section>
        <div class="container-fluid">
          <div class="row">
            <div class="col-1 mt-3">
              <h1>NeoAlice</h1>
            </div>
            <div class="titulo-pratica col-10 mt-3 d-flex justify-content-center">
              <h1></h1>
            </div>
            <div class="col-1 d-flex justify-content-end p-0">
            <div class="controle">
              <button class="fechar" id="alterarPratica" data-toggle="modal" data-target="#confirmarsaida"><i class="fa fa-sign-out" aria-hidden="true"></i>SAIR</button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="modal fade" id="confirmarsaida" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body mb-4 mt-3 text-dark">
            Tem certeza que quer cancelar? Podem haver dados não salvos
            </div>
            <div class="modal-footer">
              <a href="../editaula.php" type="button" class="btn btn-primary">OK</a>
              <a type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</a>
            </div>
          </div>
        </div>
      </div>
    </header>
<form>
    <main>
      <section class="d-flex justify-content-center">
        <table class="table">
          <tbody>
            <tr>
              <td data-toggle="tooltip" data-placement="bottom" title="Tipo disponível no laboratório"><h3>Tipo de pipetador</h3></td>
              <td data-toggle="tooltip" data-placement="bottom" title="Fotos dos tipos"><h3>Foto</h3></td>
              <td data-toggle="tooltip" data-placement="bottom" title="Tamanho disponível no laboratório"><h3>Tamanho</h3></td>
              <td data-toggle="tooltip" data-placement="bottom" title="Quantidade máxima disponível"><h3>Quantidade máxima</h3></td>
              <td data-toggle="tooltip" data-placement="bottom" title="Animação automática: o volume é preenchido automaticamente até o menisco; Animação manual: deve-se clicar com o cursor em posição do pipetador para ocorrer a pipetagem"><h3>Animação do uso</h3></td>
              
            </tr>
            <?php
            $valores = array(
                "Pipetador de três vias", "Pi-pump de até 2 ml" , "Pi-pump de até 5 ml" , "Pi-pump de até 10 ml", "Macropipetador", "Pipetador automático"
              );
              foreach ($valores as $valor):
            ?>
            <tr class="linha" data-id="<?php echo $valor; ?>">
              <td style="text-align: left;">  
                <input disabled id="item_disponivel-<?php echo($valor) ?>" class="item-disponivel item-<?php echo($valor) ?>" type="checkbox" 
                      onclick="ativacao_itens(this,<?php echo $valor;?>)"> <?php echo $valor;?>
              </td>
              <td>
              <img src="<?php echo($valor) ?>.jpg" height="100" width="100">
              </td>
              <td>
                <select disabled id="qtd_ambientes-<?php echo($valor) ?>" class="item-qtd_ambientes item-<?php echo($valor) ?> ">
                  <option value="unico">Único</option>
                </select>
              </td>
             
              <td>  
                  <input disabled id="qtd_maxima-<?php echo($valor) ?>" class="item-qtd_maxima item-<?php echo($valor) ?>" type="number" min="0" max="10" value="0">
              </td>
              <td> 
                <select disabled id="ambientacao-<?php echo($valor)?>" class="item-ambientacao item-<?php echo($valor) ?> " >
                  <option value="auto">Automática</option>
                  <option value="manual">Manual</option>
                </select>
              </td>
              
            </tr>
            <?php
              endforeach;
            ?>
          </tbody>
        </table>
      </section>
    </main>

    <footer>
      <div class="container-fluid">
        <div class="row float-right">
          <div class="col mb-3">
            <button type="submit" id="salvar" class="btn btn-primary" onclick="post()">Salvar</button>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#confirmarsaida">Cancelar</button>             
          </div>
        </div>
      </div>
    </footer>
  </form>
  </body>
</html>