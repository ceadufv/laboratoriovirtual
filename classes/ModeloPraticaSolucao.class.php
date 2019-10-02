<?php
class ModeloPraticaSolucao{

    public function getItensHtml($solucoes)
    {
        $html = '<table class="table">
                    <tbody>';
        foreach ($solucoes as $solucao) { 
            $html .= "<tr id='sol-{$solucao['nome_moprsi']}'>";
                $html .= '<td>';
                    $html .= "<span>".$solucao['nome_moprsi']."</span>";
                $html .= '</td>';
                $html .= '<td>';
                    $html .= '<button onclick="novaSolucao(this);" data-toggle="modal" data-target=".modal-edit-solucao" cod_moprsi="'.$solucao['cod_moprsi'].'" id_pratica="'.$solucao['fk_cod_mopr'].'"  type="button" class="btn verde btn btn-primary btn-sm">
                                <i class="fa fa-pen"></i> EDITAR SOLUÇÃO
                            </button>';
                 $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>
                </table>';
        return $html;
    }

    public function getSolucoesPratica($id_modelo_pratica)
    {
        $db = Conexao::getInstance();
        $sql = "SELECT * FROM modelo_pratica_solucao WHERE fk_cod_mopr = :fk_cod_mopr";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':fk_cod_mopr', $id_modelo_pratica);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSolucao($cod_moprsi)
    {
        $db = Conexao::getInstance();
        $sql = "SELECT * FROM modelo_pratica_solucao WHERE cod_moprsi = :cod_moprsi";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':cod_moprsi', $cod_moprsi);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertSolucaoPratica($dados)
    {
        $db = Conexao::getInstance();
        $sql = "INSERT INTO modelo_pratica_solucao
                (
                    nome_moprsi,
                    desc_moprsi,
                    resp_moprsi,
                    data_criacao_moprsi,
                    composicoes,
                    fk_cod_mopr,
                    armario_moprsi
                )
                VALUES
                (
                    :nome_moprsi,
                    :desc_moprsi,
                    :resp_moprsi,
                    :data_criacao_moprsi,
                    :composicoes,
                    :fk_cod_mopr,
                    :armario_moprsi
                )
        ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nome_moprsi', $dados['nome_moprsi']);
        $stmt->bindValue(':desc_moprsi', $dados['desc_moprsi']);
        $stmt->bindValue(':resp_moprsi', $dados['resp_moprsi']);
        $stmt->bindValue(':data_criacao_moprsi', $dados['data_criacao_moprsi']);
        $stmt->bindValue(':composicoes', $dados['composicoes']);
        $stmt->bindValue(':fk_cod_mopr', $dados['fk_cod_mopr']);
        $stmt->bindValue(':armario_moprsi', $dados['armario_moprsi']);
        $stmt->execute();
        return true;
    }

    public function updateSolucaoPratica($dados)
    {
        $db = Conexao::getInstance();
        $sql = "UPDATE modelo_pratica_solucao
                SET 
                    nome_moprsi = :nome_moprsi,
                    desc_moprsi = :desc_moprsi,
                    resp_moprsi = :resp_moprsi,
                    data_criacao_moprsi = :data_criacao_moprsi,
                    composicoes = :composicoes,
                    armario_moprsi = :armario_moprsi
                WHERE cod_moprsi = :cod_moprsi 
        ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nome_moprsi', $dados['nome_moprsi']);
        $stmt->bindValue(':desc_moprsi', $dados['desc_moprsi']);
        $stmt->bindValue(':resp_moprsi', $dados['resp_moprsi']);
        $stmt->bindValue(':data_criacao_moprsi', $dados['data_criacao_moprsi']);
        $stmt->bindValue(':composicoes', $dados['composicoes']);
        $stmt->bindValue(':cod_moprsi', $dados['cod_moprsi']);
        $stmt->bindValue(':armario_moprsi', $dados['armario_moprsi']);
        $stmt->execute();
        return true;
    }
}
?>