<?php

require_once __DIR__ . "/../../core/Database.php";

class Vote {

    private $conn;

    public function __construct(){

        $db = new Database();
        $this->conn = $db->connect();

    }

    public function vote($submission_id){

        $sql = "INSERT INTO votes(submission_id,user_id)
                VALUES(?,1)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$submission_id]);

    }

}