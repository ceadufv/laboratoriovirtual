<div class="navegacao">
    <a onclick="aba('inicio')" href="#">Administração</a> >
    <a onclick="aba('aulas')" href="#" class="disciplina_caminho"></a> >
    <a> Registros de alunos</a> >
</div>
<p>Nesta aba é possível ver o que cada aluno realizou nas práticas disponíveis.</p>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Data</th>
            <th scope="col">Aluno</th>
            <th scope="col">Prática</th>
            <th scope="col">Descrição</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $sql = $lab->getRegistros(@$_SESSION['id_usuario']);

        if(count($sql)) {

            foreach($sql as $row) 
            { 
                echo "<tr>" .
                "<td>" . $row["data_acao"] . "</td>" .
                "<td>" . $row["nome"] . "</td>" .
                "<td>" . $row["nome_pratica"] . "</td>" .
                "<td>" . $row["descricao"] . "</td>" .
                "</tr>";
            }
        }else{
            echo "Nenhum aluno realizou práticas";
        } 
    ?>
    </tbody>
</table>
<?php 

    
?>