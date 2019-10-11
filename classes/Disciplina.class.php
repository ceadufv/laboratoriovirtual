<?php
/**
 * @author Marcelo
 */

class Disciplina {

    public function getDisciplinasProfessor($idProfessor)
    {
        $db = Conexao::getInstance();
        $sql = "SELECT *
                FROM disciplinas
                WHERE id_professor = :id_professor
                ORDER BY nome ASC";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":id_professor", $idProfessor);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
   
    function insertDisciplina($dados)
    {
        $db = Conexao::getInstance();

        $nome_disciplina = $dados["nome_disciplina"];
        $id_professor = $dados["id_professor"];


        $sql = "INSERT INTO disciplinas 
                (nome, 
                id_professor) 
                VALUES 
                (:nome,
                :id_professor)";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(":nome", $nome_disciplina);
        $stmt->bindValue(":id_professor", $id_professor);
        $stmt->execute();
        return true; 
    }

    function atualizarDisciplina($id_disciplina)
    {
        $db = Conexao::getInstance();

        $sql = "UPDATE disciplinas
                SET nome = :nome
                WHERE id_disciplina = :id_disciplina";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":id_disciplina", $id_disciplina);
        $stmt->execute();
    }

    function apagarDisciplina($id_disciplina)
    {
        $db = Conexao::getInstance();
        $stmt = $db->prepare("DELETE FROM disciplinas WHERE id_disciplina = :id_disciplina");
        $stmt->bindValue(':id_disciplina', $id_disciplina);
        $stmt->execute();
        return true;
    }
}

