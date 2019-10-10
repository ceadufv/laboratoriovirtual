<?php
/**
 * @author Marcelo
 */

class Usuario {

    public function getPraticasAluno(){

        $db = Conexao::getInstance();
        $sql = "SELECT id_modelo_pratica AS id, nome_pratica, resumo 
                FROM modelo_pratica 
                ORDER BY nome_pratica";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    

    //Pega os alunos cadastrados no banco de dados
    public function getAlunos()
    {
        $db = Conexao::getInstance();
        $sql = "SELECT id_usuario, nome, email, usuario 
                FROM usuarios_cadastrados 
                WHERE id_tipo_usuario = 3";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function insertAluno($dados)
    {
        $db = Conexao::getInstance();

        $nomeUsuario = $dados["nome_aluno"];
        $emailUsuario = $dados["email_aluno"];
        $loginUsuario = $dados["usuario_aluno"];
        $senha = sha1('123456');

        $sql = "INSERT INTO usuarios_cadastrados 
                (nome, 
                email, 
                usuario, 
                senha, 
                id_tipo_usuario) 
                VALUES 
                (:nome,
                :email,
                :usuario,
                :senha, 
                3)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":nome", $nomeUsuario);
        $stmt->bindValue(":email", $emailUsuario);
        $stmt->bindValue(":usuario", $loginUsuario);
        $stmt->bindValue(":senha", $senha);
        if($stmt->execute())
            return true;
    }


    function resetarSenhaAluno($id_usuario)
    {
        $db = Conexao::getInstance();

        $senha = sha1('123456');

        $sql = "UPDATE usuarios_cadastrados
                SET senha = :senha
                WHERE id_usuario = :id_usuario";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":senha", $senha);
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
    }
}