<?php
require_once __DIR__ . '/../core/Database.php';

class Challenge {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM challenges ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title, $description) {
        $sql = "INSERT INTO challenges (title, description, votes) VALUES (?, ?, 0)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title, $description]);
    }
    public function find($id){

        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM challenges WHERE id=?");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }


    public function vote($challenge_id) {
        $stmt = $this->db->prepare("UPDATE challenges SET votes = votes + 1 WHERE id = ?");
        $stmt->execute([$challenge_id]);
    }
    // Update a challenge by ID
public function update($id, $title, $description) {
    $stmt = $this->db->prepare("UPDATE challenges SET title = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $description, $id]);
}

// Delete a challenge by ID
public function delete($id) {
    $stmt = $this->db->prepare("DELETE FROM challenges WHERE id = ?");
    $stmt->execute([$id]);
}
// Get one challenge by ID
public function getById($id) {
    $stmt = $this->db->prepare("SELECT * FROM challenges WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
