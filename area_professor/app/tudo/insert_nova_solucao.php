<?php 
header("Content-type: application/json; charset=utf-8");
include(URL_SYSTEM.'banco/conexao.php');

$nomes_composicao = implode(", ",@$_REQUEST['nomes_composicao']);
$ids_composicao = implode(", ",@$_REQUEST['ids_composicao']);
$conc_lista_solucao = implode(", ",@$_REQUEST['conc_lista_solucao']);
$descricao_solucao = @$_REQUEST['descricao_solucao'];
$nome_tecnico = @$_REQUEST['nome_tecnico'];
$data_de_criacao = @$_REQUEST['data_de_criacao'];
$nome_solucao = @$_REQUEST['nome_solucao'];

$resultado = array();
$resultado['nomes']=$nomes_composicao;
$resultado['ids_composicao']=$ids_composicao;
$resultado['concentracoes']=$conc_lista_solucao;
$resultado['descricao_solucao']=$descricao_solucao;
$resultado['nome_tecnico']=$nome_tecnico;
$resultado['nome_solucao']=$nome_solucao;


global $banco;
$sql_pratica = "INSERT INTO solucoes (descricao, tecnico, nome, intervalo, concentracao, nomes_composicao, ids_composicao) 
                VALUES (?,?,?,?,?,?,?)";
$stmt = $banco->prepare($sql_pratica);
$stmt->bindValue(1,$descricao_solucao);
$stmt->bindValue(2,$nome_tecnico);
$stmt->bindValue(3,$nome_solucao);
$stmt->bindValue(4,$data_de_criacao);
$stmt->bindValue(5,$conc_lista_solucao);
$stmt->bindValue(6,$nomes_composicao);
$stmt->bindValue(7,$ids_composicao);
  
    if($stmt->execute()){
        

        $resultado['status'] = true;
    }else{
        $resultado['status'] = false;
    }


// echo $resultado;
echo json_encode($resultado);

?>