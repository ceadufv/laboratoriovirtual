<?php
class Substancias{
    public function getAllSubstancias()
    {
        $db = Conexao::getInstance();
        $sql = "SELECT * FROM substancias";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>