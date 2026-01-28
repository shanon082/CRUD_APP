<?php
class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        $host = "localhost";
        $username = "root";
        $dbName = "CRUD_APP";
        $password = "";
        
        try {
            $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}



?>