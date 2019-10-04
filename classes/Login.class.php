<?php

/**
 * classe para corrigir gambiarra dos outros
 */
class Login
{
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

    public static function logout(){
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
