<?php 
session_start();

// Verifica se o arquivo sessao esta sendo aberto diretamente ou atraves de outro arquivo

function urlRaiz($volta) {
    $result = $_SERVER['REQUEST_SCHEME']."://";
    $result.= $_SERVER['SERVER_NAME'];
    $pastas = explode("/",$_SERVER['SCRIPT_NAME']);
    $volta_exp = explode("../",$volta);
    for ($i = 1 ; $i < count($volta_exp) ; $i++) {
        array_pop($pastas);
    }
    $result .= implode("/",$pastas);
    return $result;
}

function home() {
    $url_raiz = urlRaiz("../../");
    header('location:'.$url_raiz);
}
function logoff(){
    $_SESSION['usuario'] = '';
    home();
}

// URL raiz do site, construida a partir da analise do URL do arquivo SESSAO.PHP

echo logoff();
?>