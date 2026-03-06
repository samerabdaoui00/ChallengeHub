<?php
require_once(__DIR__ . "/../models/Participation.class.php");
require_once(__DIR__ . "/../models/Challenge.class.php");

// Handles submitting, editing and deleting participations
class ParticipationController
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

    // Shows the participation form for a challenge and handles the POST submission
    public function create(int $challenge_id): void
    {
        $this->checkLogin();

        // make sure the challenge exists before showing the form
        $challenge = Challenge::getById($challenge_id);
        if (!$challenge) {
            header("Location: index.php?action=list_challenges");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $participation = new Participation(
                $challenge_id,
                $_SESSION['user_id'],
                $_POST['description'],
                $_POST['image'] ?? null
            );

            if ($participation->create()) {
                header("Location: index.php?action=show_challenge&id=$challenge_id&success=submitted");
                exit();
            } else {
                $error = "Error while submitting.";
                require_once(__DIR__ . "/../views/participation/create.php");
            }
        } else {
            require_once(__DIR__ . "/../views/participation/create.php");
        }
    }

    // Lets a user edit their own participation
    // We verify ownership — a user can't edit someone else's submission
    public function edit(int $id): void
    {
        $this->checkLogin();

        $participation = Participation::getById($id);

        // reject if participation doesn't exist or doesn't belong to current user
        if (!$participation || $participation->getUserId() !== $_SESSION['user_id']) {
            header("Location: index.php?action=list_challenges");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'description' => $_POST['description'],
                // keep old image if no new one provided
                'image'       => $_POST['image'] ?? $participation->getImage()
            ];

            if ($participation->update($data)) {
                header("Location: index.php?action=show_challenge&id=" . $participation->getChallengeId() . "&success=updated");
                exit();
            } else {
                $error = "Error while editing.";
                require_once(__DIR__ . "/../views/participation/edit.php");
            }
        } else {
            require_once(__DIR__ . "/../views/participation/edit.php");
        }
    }

    // Deletes a participation — only the owner can do this
    // After deleting we redirect back to the challenge page
    public function delete(int $id): void
    {
        $this->checkLogin();

        $participation = Participation::getById($id);

        if ($participation && $participation->getUserId() === $_SESSION['user_id']) {
            $challenge_id = $participation->getChallengeId(); // save this before deleting
            $participation->delete();

            header("Location: index.php?action=show_challenge&id=$challenge_id&success=deleted");
            exit();
        }

        // if not found or not owner, just go back to the list
        header("Location: index.php?action=list_challenges");
        exit();
    }
}
