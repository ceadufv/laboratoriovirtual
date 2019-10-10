<?php
/**
 * @author Wellerson
 */
class ModeloPraticaUUsuario
{
    function getHistoricoUsuario($id_usuario)
    {
        $db = Conexao::getInstance();
        $sql = 'SELECT 
                   *
                FROM modelo_pratica_u_usuario
                LEFT JOIN modelo_pratica ON fk_id_modelo_pratica = id_modelo_pratica
                WHERE fk_id_usuario = :id_usuario';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvarHistorico($dados)
    {
        $db = Conexao::getInstance();
        $sql = "INSERT INTO modelo_pratica_u_usuario
                (
                    fk_id_modelo_pratica,
                    fk_id_usuario,
                    des_mopr_u_us,
                    dados_mopr_u_us
                )
                VALUES
                (
                    :fk_id_modelo_pratica,
                    :fk_id_usuario,
                    :des_mopr_u_us,
                    :dados_mopr_u_us
                )";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            ':fk_id_modelo_pratica' => $dados['fk_id_modelo_pratica'],
            ':fk_id_usuario' => $dados['fk_id_usuario'],
            ':des_mopr_u_us' => $dados['des_mopr_u_us'],
            ':dados_mopr_u_us' => $dados['dados_mopr_u_us']
        ));
        return $db->lastInsertId();
    }
}
