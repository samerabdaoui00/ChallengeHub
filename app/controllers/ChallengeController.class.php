<?php
require_once(__DIR__ . "/../models/Challenge.class.php");
require_once(__DIR__ . "/../models/Participation.class.php");

// This controller handles all actions related to challenges:
// listing, creating, viewing, editing and deleting
class ChallengeController
{
    // Reusable check — if the user is not logged in, redirect to login
    // We call this at the start of any action that requires authentication
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

    // Shows the list of all challenges
    // If the user typed a search query or picked a category, we filter the results
    public function list(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $keyword  = $_GET['q']   ?? ''; // search keyword from URL
        $category = $_GET['cat'] ?? ''; // category filter from URL

        // if any filter is set, use search() — otherwise just get everything
        if (!empty($keyword) || !empty($category)) {
            $challenges = Challenge::search($keyword, $category);
        } else {
            $challenges = Challenge::getAll();
        }

        require_once(__DIR__ . "/../views/challenge/list.php");
    }

    // Handles the challenge creation form (GET = show form, POST = save it)
    public function create(): void
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $challenge = new Challenge(
                $_SESSION['user_id'],
                $_POST['title'],
                $_POST['description'],
                $_POST['category'],
                $_POST['deadline'],
                $_POST['image'] ?? null
            );

            if ($challenge->create()) {
                header("Location: index.php?action=list_challenges&success=created");
                exit();
            } else {
                $error = "Error while creating the challenge.";
                require_once(__DIR__ . "/../views/challenge/create.php");
            }
        } else {
            // just show the empty form
            require_once(__DIR__ . "/../views/challenge/create.php");
        }
    }

    // Shows the detail page of one challenge + all its participations
    public function show(int $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $challenge = Challenge::getById($id);

        // if the challenge doesn't exist, go back to the list
        if (!$challenge) {
            header("Location: index.php?action=list_challenges");
            exit();
        }

        $participations = Participation::getByChallenge($id);

        require_once(__DIR__ . "/../views/challenge/show.php");
    }

    // Lets the creator edit their challenge
    // Important: we check that the logged-in user is the actual owner before allowing this
    public function edit(int $id): void
    {
        $this->checkLogin();

        $challenge = Challenge::getById($id);

        // block if challenge doesn't exist OR if it belongs to someone else
        if (!$challenge || $challenge->getUserId() !== $_SESSION['user_id']) {
            header("Location: index.php?action=list_challenges");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'category'    => $_POST['category'],
                'deadline'    => $_POST['deadline'],
                // keep the old image if no new one was submitted
                'image'       => $_POST['image'] ?? $challenge->getImage()
            ];

            if ($challenge->update($data)) {
                header("Location: index.php?action=show_challenge&id=$id&success=updated");
                exit();
            } else {
                $error = "Error while updating.";
                require_once(__DIR__ . "/../views/challenge/edit.php");
            }
        } else {
            require_once(__DIR__ . "/../views/challenge/edit.php");
        }
    }

    // Deletes a challenge — only the owner can do this
    public function delete(int $id): void
    {
        $this->checkLogin();

        $challenge = Challenge::getById($id);

        // make sure the challenge exists and belongs to the current user
        if ($challenge && $challenge->getUserId() === $_SESSION['user_id']) {
            $challenge->delete();
        }

        header("Location: index.php?action=list_challenges&success=deleted");
        exit();
    }
}
