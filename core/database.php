<?php
class Database {
    private $host = "localhost";
    private $dbname = "web"; // your DB name
    private $user = "root";  // default WAMP user
    private $pass = "";      // default WAMP password
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4",
                $this->user,
                $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}