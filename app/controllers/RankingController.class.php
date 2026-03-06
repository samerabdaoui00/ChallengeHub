<?php
require_once(__DIR__ . "/../models/Participation.class.php");
require_once(__DIR__ . "/../models/Challenge.class.php");
require_once(__DIR__ . "/../models/User.class.php");

// Shows the ranking page: top 10 most-voted participations
class RankingController
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // get the top 10 participations sorted by vote count (done in the model)
        $rankings = Participation::getRanking(10);

        // add the challenge title to each result so the view can display it
        foreach ($rankings as &$r) {
            $challenge = Challenge::getById($r['participation']->getChallengeId());
            // use "N/A" as fallback in case the challenge was deleted
            $r['challenge_title'] = $challenge ? $challenge->getTitle() : "N/A";
        }

        require_once(__DIR__ . "/../views/ranking/index.php");
    }
}
?>
