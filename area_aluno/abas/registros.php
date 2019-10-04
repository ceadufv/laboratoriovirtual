<div class="container">
  <div class="row">
    <div class="col-md-12 meuperfil">

      <h3>Minhas ações</h3>

      <h4>Nesta aba é possível ver o que você já realizou nas práticas disṕoniveis.</h4>

      <table class="table">
        <thead>
          <tr>
            <th scope="col">Data</th>
            <th scope="col">Prática</th>
            <th scope="col">Descrição</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $sql = $lab->getRegistrosAluno(@$_SESSION['id_usuario']);

          if(count($sql)) {

            foreach($sql as $row) 
            { 
              echo "<tr>" .
              "<td>" . $row["data_acao"] . "</td>" .
              "<td>" . $row["nome_pratica"] . "</td>" .
              "<td>" . $row["descricao"] . "</td>" .
              "</tr>";
            }
          }else{
            echo "<p><i class='fas fa-info-circle'></i> Você ainda não realizou nenhuma ação</p>";
          } 
          ?>
        </tbody>
      </table>
      <?php 


      ?>

    </div>
  </div>
</div>
