<?php

require_once __DIR__."/../config/database.php";

class Submission {

    private $conn;

    public function __construct(){

        $db = new Database();
        $this->conn = $db->connect();

    }

    public function getByChallenge($challenge_id){

        $sql = "SELECT s.*, 
                (SELECT COUNT(*) FROM votes v 
                 WHERE v.submission_id=s.id) as votes
                FROM submissions s
                WHERE challenge_id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$challenge_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}