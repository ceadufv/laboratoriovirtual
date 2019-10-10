<?php

    include('conexao.php');

    $comandos = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if($comandos['acao'] === 'buscar_dados_pratica') {
        buscarDados($comandos['id_pratica']);
    }

    function buscarDados($idPratica) {
        global $banco;
        try {
            $consulta = $banco -> prepare('SELECT a.json_obj_pratica, b.json_instrumento FROM objeto_pratica a, instrumento_pratica b WHERE a.id_pratica = b.id_pratica AND b.id_pratica = :id_pratica');
            $consulta -> execute(array('id_pratica' => intval($idPratica)));
            $dados = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo json_encode(array('sucesso' => false, 'log' => $e -> getMessage()));
        }
    }

?>