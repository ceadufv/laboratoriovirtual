<?php
    session_start();
    header("Content-type: application/json; charset=utf-8");

    include('../banco/conexao.php');
    $nome = @$_REQUEST['nome'];
    $id = @$_REQUEST['id'];

    $sql = "UPDATE disciplinas
        SET nome = ?
        WHERE id_disciplina = ?;";
    $stmt1 = $dbh->prepare($sql);
    $stmt1->bindValue(1,$nome);
    $stmt1->bindValue(2,$id);

    if($stmt1->execute()){  
        $resultado['status'] = true;
    }
    else{
        $resultado['status'] = false;
    }
    echo json_encode($resultado);

?>
