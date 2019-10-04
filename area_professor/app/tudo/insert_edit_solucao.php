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
$id_solucao = @$_REQUEST['id_solucao'];

$resultado = array();
$resultado['nomes']=$nomes_composicao;
$resultado['ids_composicao']=$ids_composicao;
$resultado['concentracoes']=$conc_lista_solucao;
$resultado['descricao_solucao']=$descricao_solucao;
$resultado['nome_tecnico']=$nome_tecnico;
$resultado['nome_solucao']=$nome_solucao;
$resultado['id_solucao']=$id_solucao;


global $banco;

$sql_pratica = "UPDATE solucoes 
                SET descricao=?, tecnico=?, nome=?, intervalo=?, concentracao=?, nomes_composicao=?, ids_composicao=? 
                WHERE id_solucao=?";

$stmt = $banco->prepare($sql_pratica);

    if($stmt->execute([
    $descricao_solucao,
    $nome_tecnico,
    $nome_solucao,
    $data_de_criacao,
    $conc_lista_solucao,
    $nomes_composicao,
    $ids_composicao,
    $id_solucao])
    ){
        $resultado['status'] = true;
    }else{
        $resultado['status'] = false;
    }

// echo $resultado;
echo json_encode($resultado);

?>