<script type="text/javascript" src="js/abas/registros.js"></script>

<div class="container">
  <div class="row">
    <div class="col-md-12 meuperfil">
      <h3>Minhas ações</h3>
      <h4>Nesta aba é possível ver o que você já realizou nas práticas disṕoniveis.</h4>

      <div class="container">
        <table id="tabela" class="table table-striped table-bordered table-data" style="width:100%">
          <thead>
            <tr>
              <th scope="col">Prática</th>
              <th scope="col">Descrição</th>
              <th scope="col">Data</th>
            </tr>
          </thead>
          <tbody>
            <?php
          //  require_once("../classes/LabJogo.class.php");

            //$sql = $lab->getRegistrosAluno($_SESSION['id_usuario']);

            if (count($sql)) {

              foreach ($sql as $row) { ?>
                <tr>
                  <td><?php echo $row['nome_pratica'] ?></td>
                  <td><?php echo $row['descricao'] ?></td>
                  <td><?php echo date('d/m/Y H:i:s', strtotime($row["data_acao"])) ?></td>
                </tr>
            <?php
              }
            } else {
              echo "<p><i class='fas fa-info-circle'></i> Você ainda não realizou nenhuma ação</p>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>