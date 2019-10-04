<?php
include(URL_SYSTEM . 'banco/conexao.php');
if ($_POST["acao"] == 'salvar') {
    $nome = $_POST["nome_aluno"];
    $email = $_POST["email_aluno"];
    $usuario = $_POST["usuario_aluno"];
    $senha = '123456';
    $senha = sha1($senha);
    $sql = "INSERT INTO usuarios_cadastrados (nome, email, usuario, senha, id_tipo_usuario) VALUES (?,?,?,?, 1)";
    $stmt1 = $dbh->prepare($sql);
    $stmt1->bindValue(1, $nome);
    $stmt1->bindValue(2, $email);
    $stmt1->bindValue(3, $usuario);
    $stmt1->bindValue(4, $senha);
    if ($stmt1->execute()) {
        $resultado['status'] = true;
    } else {
        $resultado['status'] = false;
    }

    if ($resultado) {
        header('location: '.URL_SITE.'area_professor/index.php?aba=alunos&cadastro=ok');
    }
}
