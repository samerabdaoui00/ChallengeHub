<?php
require_once __DIR__ . '/../../core/Database.php';

class Challenge {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        $sql = "SELECT * FROM challenges ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($title, $description, $category) {
        $sql = "INSERT INTO challenges(title, description, category) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $description, $category]);
    }
}