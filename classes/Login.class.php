<?php

/**
 * classe para corrigir gambiarra dos outros
 */
class Login
{
    // Função de validação de login
    public static function logar($user, $pass)
    {
        global $banco;
        try {
            // Busca usuário no banco
            $consulta = $banco->prepare('SELECT nome, id_tipo_usuario, usuario, id_usuario, email FROM usuarios_cadastrados WHERE usuario = :usuario AND senha = :senha');
            $consulta->execute(array(':usuario' => $user, ':senha' => sha1($pass)));
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

            // Verifica se há usuário cadastrado
            if (count($resultado) === 1) {
                // Faz o login
                $_SESSION['nome'] = $resultado[0]['nome'];
                $_SESSION['usuario'] = $resultado[0]['usuario'];
                $_SESSION['email'] = $resultado[0]['email'];
                $_SESSION['id_usuario'] = $resultado[0]['id_usuario'];
                $_SESSION['tipo_usuario'] = intval($resultado[0]['id_tipo_usuario']);

                if (intval($resultado[0]['id_tipo_usuario']) === 2) {
                    $_SESSION['administrador'] = true;
                } else {
                    $_SESSION['administrador'] = false;
                }
                echo json_encode(array('sucesso' => true, 'log' => 'Login realizado com sucesso.', 'tipo' => intval($resultado[0]['id_tipo_usuario'])));
            } else {
                // Erro de login
                echo json_encode(array('sucesso' => false, 'log' => 'Usuário ou senha inválidos.'));
            }
        } catch (PDOException $e) {
            echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
        }
    }



    // Verifica se o arquivo sessao esta sendo aberto diretamente ou atraves de outro arquivo
    public static function acessandoDiretamente()
    {
        if (strpos($_SERVER['PHP_SELF'], 'sessao.php') !== FALSE)
            return true; // qualquer pessoa não logada

        $url = $_SERVER['REQUEST_URI'];
        // não professor acessando área do professor
        if ((strpos($url, 'area_professor') !== FALSE) && $_SESSION['administrador'] != 1) {
            return true;
        } elseif ((strpos($url, 'area_aluno') !== FALSE) && $_SESSION['administrador'] == 1) {
            // professor acessando área do aluno
            return true;
        }
        return false;
    }

    public static function logado()
    {
        if (self::acessandoDiretamente() || empty($_SESSION['usuario'])) {
            return false;
        }
    }

    public static function checkUser()
    {
        if (self::logado()) {
            self::redirect();
        }
    }

    public static function logout()
    {
        unset($_SESSION);
        session_destroy();
        self::redirect();
    }
    public static function redirect()
    {
        header('location:' . URL_SITE);
        exit();
    }
}
