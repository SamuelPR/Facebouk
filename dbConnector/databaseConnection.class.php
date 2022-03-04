<?php
//TODO: Comment here too(I'm sensing a TODO pattern..)
require './dbConnector/configuration.inc.php';

class DatabaseConnection
{
    private static $instance;

    private function __construct()
    {
        try {
            self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("Impossible de se connecter à la base de données.");
        }
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            new self();
        }

        return self::$instance;
    }
}
