<?php

require_once "../models/Vote.php";

class VoteController {

    public function vote(){

        $submission_id = $_GET["submission"];

        $vote = new Vote();
        $vote->vote($submission_id);

        header("Location: ".$_SERVER['HTTP_REFERER']);

    }

}