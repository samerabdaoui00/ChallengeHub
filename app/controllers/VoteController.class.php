<?php
require_once(__DIR__ . "/../models/Vote.class.php");

// Handles voting on a participation
// It works as a toggle: if already voted → remove the vote, otherwise → add it
class VoteController
{
    // Redirect to login if not connected (you need to be logged in to vote)
    private function checkLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
    }

    // Called when a user clicks the vote button on a submission
    public function vote(): void
    {
        $this->checkLogin();

        $submission_id = $_GET['submission_id'] ?? 0;
        $user_id       = $_SESSION['user_id'];

        if ($submission_id > 0) {
            $vote = new Vote($submission_id, $user_id);

            // toggle logic: already voted = remove it, not voted = add it
            if (Vote::hasVoted($submission_id, $user_id)) {
                $vote->delete();
            } else {
                $vote->create();
            }
        }

        // send the user back to whatever page they came from
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "index.php"));
        exit();
    }
}
