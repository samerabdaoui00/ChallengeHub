<?php

require_once __DIR__ . '/../config/database.php';

class Submission {

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function getByChallenge($challenge_id){

        $sql = "SELECT * FROM submissions WHERE challenge_id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$challenge_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($challenge_id,$name,$work){

        $sql = "INSERT INTO submissions(challenge_id,name,work,votes) VALUES (?,?,?,0)";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([$challenge_id,$name,$work]);
    }

    public function vote($submission_id){

        $sql = "UPDATE submissions SET votes=votes+1 WHERE id=?";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([$submission_id]);
    }
}