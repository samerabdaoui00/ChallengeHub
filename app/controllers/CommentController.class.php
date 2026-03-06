<?php
require_once(__DIR__ . "/../models/Comment.class.php");

// Handles adding and deleting comments on participations
class CommentController
{
    // Redirect to login if not connected
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

    // Saves a new comment submitted from the form
    // We also need challenge_id to redirect back to the right challenge page after posting
    public function create(): void
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submission_id = $_POST['submission_id'] ?? 0;
            $challenge_id  = $_POST['challenge_id']  ?? 0;
            $content       = $_POST['content']        ?? '';

            // only save if we have a valid submission and non-empty content
            if ($submission_id > 0 && !empty($content)) {
                $comment = new Comment($submission_id, $_SESSION['user_id'], $content);
                $comment->create();
            }

            // go back to the challenge page where the comment was posted
            header("Location: index.php?action=show_challenge&id=$challenge_id");
            exit();
        }
    }

    // Deletes a comment — only the person who wrote it can delete it
    public function delete(int $id): void
    {
        $this->checkLogin();

        $comment = Comment::getById($id);

        // check ownership before deleting
        if ($comment && $comment->getUserId() === $_SESSION['user_id']) {
            $comment->delete();
        }

        // go back to wherever the user came from (the referer header)
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "index.php"));
        exit();
    }
}
