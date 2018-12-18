<?php 
error_reporting(E_ALL^E_WARNING^E_NOTICE);

session_start();

// Verifica se o arquivo sessao esta sendo aberto diretamente ou atraves de outro arquivo
function acessandoDiretamente() {  
    if(strpos($_SERVER['PHP_SELF'],'sessao.php') !== FALSE) return true; // qualquer pessoa não logada

    $url = @$_SERVER[REQUEST_URI];
    if ((strpos($url, 'area_professor') !== FALSE) && @$_SESSION[administrador] != 1 ) // não professor acessando área do professor
    {
        return true;
    } 
    elseif ((strpos($url, 'area_aluno') !== FALSE) && @$_SESSION[administrador] == 1 ) // professor acessando área do aluno
    {
        return true;
    }
    return false;
}

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

function usuarioDeslogado() {
    return empty(@$_SESSION['usuario']); 
}

function acessoNegado() {
    $url_raiz = urlRaiz("../../");
    header('location:'.$url_raiz);
}


// URL raiz do site, construida a partir da analise do URL do arquivo SESSAO.PHP

if (
    acessandoDiretamente() ||
    usuarioDeslogado()
) {
    acessoNegado();    
}
?>