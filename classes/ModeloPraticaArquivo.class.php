<?php
class ModeloPraticaArquivo{

    public function insert($dados)
    {
        $db = Conexao::getInstance();
        $sql = "INSERT INTO modelo_pratica_arquivo
                (
                    nome_moprar,
                    scr_img_moprar,
                    type_img_moprar,
                    tipo_moprar,
                    fk_id_modelo_pratica
                )
                VALUES
                (
                    :nome_moprar,
                    :scr_img_moprar,
                    :type_img_moprar,
                    :tipo_moprar,
                    :fk_id_modelo_pratica
                )";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nome_moprar', $dados['nome_moprar']);
        $stmt->bindValue(':scr_img_moprar', $dados['scr_img_moprar']);
        $stmt->bindValue(':type_img_moprar', $dados['type_img_moprar']);
        $stmt->bindValue(':tipo_moprar', $dados['tipo_moprar']);
        $stmt->bindValue(':fk_id_modelo_pratica', $dados['fk_id_modelo_pratica']);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public function update($dados)
    {
        $db = Conexao::getInstance();
        $sql = "UPDATE modelo_pratica_arquivo
                SET
                    nome_moprar=:nome_moprar
                    scr_img_moprar=:scr_img_moprar,
                    type_img_moprar=:type_img_moprar,
                    tipo_moprar=:tipo_moprar,
                    fk_id_modelo_pratica=:fk_id_modelo_pratica
                WHERE cod_moprar = :cod_moprar";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nome_moprar', $dados['nome_moprar']);
        $stmt->bindValue(':scr_img_moprar', $dados['scr_img_moprar']);
        $stmt->bindValue(':type_img_moprar', $dados['type_img_moprar']);
        $stmt->bindValue(':tipo_moprar', $dados['tipo_moprar']);
        $stmt->bindValue(':fk_id_modelo_pratica', $dados['fk_id_modelo_pratica']);
        $stmt->bindValue(':cod_moprar', $dados['cod_moprar']);
        $stmt->execute();
        return true;
    }
}
?>