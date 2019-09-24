<?php
@include_once(dirname(__FILE__) . "/../lab-config.php");

try {
    $banco = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
    $dbh = $banco;
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    //exit;
}

function labRootPath()
{
    $old = getcwd();
    $path = pathinfo(__FILE__);
    chdir(__DIR__);
    $real = realpath("../");
    chdir($old);
    return $real;
}

// Define uma constante para facilitar a cricacao de includes
define('LAB_ROOT', labRootPath());
// Inclui as classes para manipulacao de dados
include(LAB_ROOT . "/classes/LabJogo.class.php");

// Deixa uma instancia da classe jogo preparada para o usuario
$lab = new LabJogo();
?>