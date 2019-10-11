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
            $sessao = Login::getSession();
            $objModeloPraticaUUsuario = new ModeloPraticaUUsuario();
            $registros = $objModeloPraticaUUsuario->getHistoricoUsuario($sessao['id_usuario']);
            if (count($registros)) {
              foreach ($registros as $registro) { ?>
                <tr>
                  <td><?php echo $registro['nome_pratica'] ?></td>
                  <td><?php echo $registro['des_mopr_u_us'] ?></td>
                  <td><?php echo date('d/m/Y H:i:s', strtotime($registro["datei_mopr_u_us"])) ?></td>
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