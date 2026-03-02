<?php

require_once __DIR__ . '/../config/database.php';

class Challenge {

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function getAll(){

        $sql = "SELECT * FROM challenges ORDER BY id DESC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title,$description){

        $sql = "INSERT INTO challenges(title,description) VALUES (?,?)";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([$title,$description]);
    }
}