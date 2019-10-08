<div class="row">
    <div class="administrar col-md-12">
        <h3>
            <span>Práticas disponíveis</span>
        </h3>

        <div class="input-group">
        <select id="select_acessar_laboratorio" class="custom-select" required>
        <?php

        // Lista as praticas disponiveis para o aluno
        $sql = $lab->getPraticasAluno($_SESSION['id_usuario']);
        
        if(count($sql)) {

            foreach($sql as $row) 
            { ?>
                <option value=<?php echo $row['id']?>> 
                    <?php   echo $row["nome_pratica"]; 
                            echo ' - '; 
                            // se o resumo for grande demais, adiciona três pontinhos pra não quebrar o select ...
                            $row["resumo"] = (strlen($row["resumo"]) > 60) ? substr($row["resumo"],0,60).'...' : $row["resumo"]; 
                            echo $row["resumo"];
                    ?> 
                </option>;
        <?php }
        }else{
            echo "Não há práticas disponíveis";
        } 
        ?>
        </select>
        <div class="input-group-append">
            <button class="btn btn-primary" onclick="acessar_laboratorio('salvar')"><i class="fa fa-check-circle"></i> Realizar prática</button>
            <button class="btn btn-success" onclick="acessar_laboratorio('treino')"><i class="fa fa-check-circle"></i> Treinar</button>
        </div>
    
        <script>
        function acessar_laboratorio(tipo_acesso){
            var id = $('#select_acessar_laboratorio option:selected').val();
            location.href="../area_laboratorio/lab.php?id_pratica="+id+'&tipo_acesso='+tipo_acesso;
        }
        </script>
        </div>
        <br>
    </div>
</div>

