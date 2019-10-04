<div class="row">
    <div class="administrar col-md-12">
        <h3>
            <span>Práticas disponíveis</span>
        </h3>

        <div class="input-group">
        <select id="select_acessar_laboratorio" class="custom-select" required>
        <?php
        include_once('../banco/conexao.php');

        // Lista as praticas disponiveis para o aluno
        $sql = $lab->getPraticasAluno(@$_SESSION['id_usuario']);
        
        if(count($sql)) {

            foreach($sql as $row) 
            { ?>
                <option value=<?php echo $row['id']?>> <?php echo $row["nome_pratica"]?> </option>;
        <?php }
        }else{
            echo "Não há práticas disponíveis";
        } 
        ?>
        </select>
        <div class="input-group-append">
            <button class="btn azul" onclick="acessar_laboratorio('salvar')"><i class="fa fa-check-circle"></i> Realizar prática</button>
            <button class="btn verde" onclick="acessar_laboratorio('treino')"><i class="fa fa-check-circle"></i> Treinar</button>
        </div>
    
        <script>
        function acessar_laboratorio(tipo_acesso){
            var id = $('#select_acessar_laboratorio option:selected').val();
            location.href="lab.php?id_pratica="+id+'&tipo_acesso='+tipo_acesso;
        }
        </script>
        </div>
        <br>
        
        <p>Resumo da prática: </p>
        <div id="aula_resumo" class="conteudoresumo">
           Clique na prática desejada para ver seu resumo   
        </div>
    </div>
</div>

