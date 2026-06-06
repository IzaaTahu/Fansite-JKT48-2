<?php
// config/db_config.php

class Database {
    private $host;
    private $port;
    private $username;
    private $db_name;
    private $password;

    public function __construct() {
        // Jika ada env DB_HOST (di Render), pakai itu. Jika tidak (di localhost), pakai default kanan.
        $this->host     = getenv('DB_HOST') ?: "localhost";
        $this->port     = getenv('DB_PORT') ?: "3306";
        $this->username = getenv('DB_USERNAME') ?: "root";
        $this->db_name  = getenv('DB_DATABASE') ?: "fansite1";
        $this->password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : "";
    }

    public function getConnection(): PDO {
        try {
            // Kita tambahkan parameter port di DSN karena cloud database (Aiven) biasanya tidak pakai port default 3306
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
            
            $connect = new PDO(
                $dsn,
                $this->username,
                $this->password
            );
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $connect;
        } catch (PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }
    }
}