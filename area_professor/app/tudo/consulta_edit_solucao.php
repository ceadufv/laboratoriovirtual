<?php 
header("Content-type: application/json; charset=utf-8");
include(URL_SYSTEM.'banco/conexao.php');

    $resultado = array();
    $resultado['status'] = true;

    $id_solucao = @$_REQUEST['id_solucao'];

    global $banco;
    $especies_solucao = $banco -> prepare("SELECT * FROM solucoes WHERE id_solucao=$id_solucao");
    $especies_solucao -> execute();
    $item = $especies_solucao -> fetchAll(PDO::FETCH_ASSOC);
    
    
    $nome_tecnico = $item[0]['tecnico'];
    $descricao_solucao  = $item[0]['descricao'];
    $nome_solucao  = $item[0]['nome'];
    $data_de_criacao = $item[0]['intervalo'];
    $conc_lista_solucao = $item[0]['concentracao'];
    $nomes_composicao = $item[0]['nomes_composicao'];
    $ids_composicao = $item[0]['ids_composicao'];
    

    $resultado['id_solucao'] = $id_solucao;
    $resultado['nome_tecnico'] = $nome_tecnico;
    $resultado['descricao_solucao'] = $descricao_solucao;
    $resultado['nome_solucao'] = $nome_solucao;
    $resultado['data_de_criacao'] = $data_de_criacao;
    $resultado['conc_lista_solucao'] = explode(",",$conc_lista_solucao);
    $resultado['nomes_composicao'] =  explode(",",$nomes_composicao);
    $resultado['ids_composicao'] =  explode(",",$ids_composicao);

echo json_encode($resultado);
// print_r($resultado);

?>