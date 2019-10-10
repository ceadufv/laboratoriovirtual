<?php

/**
 * classe para corrigir gambiarra dos outros
 */
class Login
{
    static $permissao_usuario;
    // Função de validação de login
    public static function logar($user, $pass)
    {
        global $banco;
        try {

            // Busca usuário no banco
            $consulta = $banco->prepare('SELECT nome, id_tipo_usuario, usuario, id_usuario, email FROM usuarios_cadastrados WHERE usuario = :usuario AND senha = :senha');
            $consulta->execute(array(':usuario' => $user, ':senha' => sha1($pass)));
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

            // Verifica se há usuário cadastrado
            if (!empty($resultado)) {
                // Faz o login
                $_SESSION['nome'] = $resultado['nome'];
                $_SESSION['usuario'] = $resultado['usuario'];
                $_SESSION['email'] = $resultado['email'];
                $_SESSION['id_usuario'] = $resultado['id_usuario'];
                $_SESSION['tipo_usuario'] = intval($resultado['id_tipo_usuario']);
                if (intval($resultado['id_tipo_usuario']) === 2) {
                    $_SESSION['administrador'] = true;
                } else {
                    $_SESSION['administrador'] = false;
                }
                echo json_encode(array('sucesso' => true, 'log' => 'Login realizado com sucesso.', 'tipo' => intval($resultado['id_tipo_usuario'])));
            } else {
                // Erro de login
                echo json_encode(array('sucesso' => false, 'log' => 'Usuário ou senha inválidos.'));
            }
        } catch (PDOException $e) {
            echo json_encode(array('sucesso' => false, 'log' => $e->getMessage()));
        }
    }



    // Verifica se o arquivo sessao esta sendo aberto diretamente ou atraves de outro arquivo
    public static function ckeckTipoUser()
    {
        if (in_array($_SESSION['tipo_usuario'], self::$permissao_usuario)) {
            return true;
        }
        return false;
    }

    public static function logado()
    {
        if (!self::ckeckTipoUser() || empty($_SESSION['usuario'])) {
            return false;
        }
        return true;
    }

    public static function checkUser()
    {
        if (!self::logado()) {
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

    public static function getSession()
    {
        return array(
            'nome' => $_SESSION['nome'],
            'usuario' => $_SESSION['usuario'],
            'email' => $_SESSION['email'],
            'id_usuario' => $_SESSION['id_usuario'],
            'tipo_usuario' => $_SESSION['tipo_usuario']
        );
    }
}
