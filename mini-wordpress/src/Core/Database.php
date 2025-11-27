<?php

use PDO;
use PDOException;

class Database{

    private static ?Database $instance = null;
    private ?PDO $connection = null;

    private function __construct(){
        $this->connect();
    }

    public static function getInstance(): Database{
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect(): void{
        try{
            $host = getenv('DB_HOST') ?: 'db';
            $port = getenv('DB_PORT') ?: '5432';
            $dbname = getenv('DB_NAME') ?: 'mini_wordpress';
            $user = getenv('DB_USER') ?: 'wordpress_user';
            $password = getenv('DB_PASSWORD') ?: 'WPkilo1@';

            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->connection = new PDO($dsn, $user, $password, $options);
        }catch(PDOException $e){
            die ("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO{
        return $this->connection;
    }

    /**
     * Empêche le clonage de l'instance (protection du Singleton)
     */
    private function __clone() {}

    /**
     * Empêche la désérialisation (protection du Singleton)
     */
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
}