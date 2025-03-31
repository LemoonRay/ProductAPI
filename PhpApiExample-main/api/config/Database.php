<?php

class Database {
    private static $instance = null;
    private $databaseConnection;
    private $host;
    private $databaseName;
    private $userName;
    private $password;

    private function __construct() {
        $this->host = "localhost";
        $this->databaseName = "PRODUCT";
        $this->userName = "root";
        $this->password = "";

        try {
            $this->databaseConnection = new PDO(
                "mysql:host={$this->host};dbname={$this->databaseName};charset=utf8mb4",
                $this->userName,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $exception) {
            error_log("Database Connection Error: " . $exception->getMessage());
            die("Database connection failed. Contact administrator.");
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->databaseConnection;
    }
}
