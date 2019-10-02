<?php
class Conexao
{
    private static $db;
    private static $error;

    public static function getInstance(){
        self::conectar();
        return self::$db;
    }
    
    private static function conectar()
    {
        if(self::$db)
            return true;

        try {
            self::$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
        } catch (PDOException $e) {
            self::$error = $e->getMessage();
            self::$db = null;
            return false;
        }
    }
}
?>