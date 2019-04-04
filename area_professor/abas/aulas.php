<?php
?><div class="container">
  <div class="row">
    <div class="col-md-12">

      <div class="navegacao">
        <a onclick="aba('inicio')" href="#">Administração</a> >
        <span class="disciplina_caminho"></span>
      </div>

      <h3>
        <span>Selecionar aula prática</span>
        <div class="form">
          <button id = "cadastrar" type="button" class="btn btn-outline-primary" onclick="cadastraAula()">
            <span>Cadastrar nova prática</span>
            <i class="fas fa-angle-right"></i>
          </button>  
        </div> 

      </h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="minhasaulas">
        <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
        <h4>Práticas cadastradas</h4>

        <ul class="list-unstyled">
        <?php
          $sql = $lab->getAulas(@$_REQUEST['id_disciplina']);
          if(count($sql)) {

              foreach($sql as $row) 
              { ?>
                  <li id='<?php echo $row["id"]?>'> 
                    <span class="option inactive" id='<?php echo $row["id"]?>' onclick="getResumo(<?php echo $row['id']?>)">
                      <?php echo $row["nome_pratica"]?>
                    </span>
                    <span>                
                      <button type="button" class="btn azul" onclick="edit_pratica(<?php echo $row['id']?>)"><i class="fas fa-edit" aria-hidden="true"></i> EDITAR</button>    
                      <!-- location.href='../area_professor/index.php?id_pratica=&acao=editaraula' -->            
                      <button type="button" class="btn azul" onclick="location.href='../area_laboratorio/lab.php?id_pratica='+<?php echo $row['id']?>+'&tipo_acesso=treino'">
                        <i class="far fa-eye"></i> Visualizar
                      </button> 
                      <button type="button" class="btn azul" onclick="aba('registros')">
                        <i class="far fa-file-alt"></i> Registro/Alunos
                      </button> 
                      
                      <button id="excluir-<?php echo $row["id"]?>" class="btn vermelho" data-toggle="confirmation" data-title="Tem certeza que deseja excluir a prática?" data-placement="right" data-singleton="true" 
                        data-btn-ok-label="SIM " data-btn-ok-class="verde"
                        data-btn-cancel-label="NÃO" data-btn-cancel-class="vermelho"
                        data-title="Confirma exclusão?">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                      <script> 
                      $('[data-toggle=confirmation]').confirmation({
                        rootSelector: '[data-toggle=confirmation]',
                        container: 'body',
                        onConfirm: function() {
                          deletar_pratica(<?php echo $row["id"] ?>);
                        },
                        onCancel: function() {
                        },
                      });
                      </script>
                    </span>
                  </li>
          <?php }
          }else{
              echo "Não há práticas cadastradas";
          } ?>
        </ul>
      </div>
      
      <div class="exibirresumo">
        <div class="form-check">
          <input class="form-check-input" checked type="checkbox" value="" id="mostrar-resumo">
          <label class="form-check-label" for="mostrar-resumo">
            Mostrar resumo
          </label>
        </div>           
        
        <div id="container-resumo" class="conteudoresumo">
          <p id="show_resumo"> Clique na prática desejada para ver seu resumo </p>     
        </div>
      </div>
      

    </div>
  </div>

</div>