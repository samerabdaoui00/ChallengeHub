<?php
require_once(__DIR__ . "/../models/Participation.php");
require_once(__DIR__ . "/../models/Challenge.php");
require_once(__DIR__ . "/../models/User.php");
class RankingController {
    public function index() {
        $rankings = Participation::getRanking(10);
        foreach ($rankings as &$r) {
            $challenge = Challenge::getById($r['participation']->getChallengeId());
            $r['challenge_title'] = $challenge ? $challenge->getTitle() : "N/A";
        }
        require_once(__DIR__ . "/../views/ranking/index.php");
    }
}
?>