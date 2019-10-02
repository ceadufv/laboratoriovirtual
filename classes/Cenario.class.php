<?php
class Cenario{
    function getCenario($id_cenario)
    {
        $db = Conexao::getInstance();
        $sql = "SELECT * from cenario where id_cenario = :id_cenario";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_cenario', $id_cenario);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $result['data'] = json_decode($result['data']);
        return $result;
    }
}
?>