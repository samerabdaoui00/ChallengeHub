<?php
// This is the single entry point for the whole app (front controller pattern)
// Every page goes through here — the "action" parameter in the URL decides what to do
// Example: index.php?action=list_challenges

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . "/config/configuration.php");
require_once(__DIR__ . "/app/models/User.class.php");

// read the action from the URL, default to showing challenges if nothing is specified
$action = isset($_GET['action']) ? $_GET['action'] : 'list_challenges';

switch ($action) {

    // --- Auth ---

    case 'register':
        // create a new account
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = new User($_POST['name'], $_POST['email'], $_POST['password']);
                if ($user->register()) {
                    header("Location: index.php?action=login&success=1");
                    exit();
                } else {
                    $error = "Registration failed. Please try again.";
                    require_once(__DIR__ . "/app/views/auth/register.php");
                }
            } catch (Exception $e) {
                // catches "email already taken" from User::register()
                $error = $e->getMessage();
                require_once(__DIR__ . "/app/views/auth/register.php");
            }
        } else {
            require_once(__DIR__ . "/app/views/auth/register.php");
        }
        break;

    case 'login':
        // log in with email and password
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User("", "", "");
            if ($user->login($_POST['email'], $_POST['password'])) {
                header("Location: index.php?action=profile");
                exit();
            } else {
                $error = "Wrong email or password.";
                require_once(__DIR__ . "/app/views/auth/login.php");
            }
        } else {
            require_once(__DIR__ . "/app/views/auth/login.php");
        }
        break;

    case 'logout':
        // destroy session and redirect to login
        $user = new User("", "", "");
        $user->logout();
        break;

    // --- Profile ---

    case 'profile':
        require_once(__DIR__ . "/app/controllers/ProfileController.class.php");
        (new ProfileController())->index();
        break;

    // --- Challenges ---

    case 'list_challenges':
        require_once(__DIR__ . "/app/controllers/ChallengeController.class.php");
        (new ChallengeController())->list();
        break;

    case 'create_challenge':
        require_once(__DIR__ . "/app/controllers/ChallengeController.class.php");
        (new ChallengeController())->create();
        break;

    case 'show_challenge':
        require_once(__DIR__ . "/app/controllers/ChallengeController.class.php");
        (new ChallengeController())->show($_GET['id'] ?? 0);
        break;

    case 'edit_challenge':
        require_once(__DIR__ . "/app/controllers/ChallengeController.class.php");
        (new ChallengeController())->edit($_GET['id'] ?? 0);
        break;

    case 'delete_challenge':
        require_once(__DIR__ . "/app/controllers/ChallengeController.class.php");
        (new ChallengeController())->delete($_GET['id'] ?? 0);
        break;

    // --- Participations ---

    case 'submit_participation':
        require_once(__DIR__ . "/app/controllers/ParticipationController.class.php");
        (new ParticipationController())->create($_GET['challenge_id'] ?? 0);
        break;

    case 'edit_participation':
        require_once(__DIR__ . "/app/controllers/ParticipationController.class.php");
        (new ParticipationController())->edit($_GET['id'] ?? 0);
        break;

    case 'delete_participation':
        require_once(__DIR__ . "/app/controllers/ParticipationController.class.php");
        (new ParticipationController())->delete($_GET['id'] ?? 0);
        break;

    // --- Comments ---

    case 'add_comment':
        require_once(__DIR__ . "/app/controllers/CommentController.class.php");
        (new CommentController())->create();
        break;

    case 'delete_comment':
        require_once(__DIR__ . "/app/controllers/CommentController.class.php");
        (new CommentController())->delete($_GET['id'] ?? 0);
        break;

    // --- Votes ---

    case 'vote_submission':
        // toggle vote on a participation
        require_once(__DIR__ . "/app/controllers/VoteController.class.php");
        (new VoteController())->vote();
        break;

    // --- Ranking ---

    case 'ranking':
        // shows top 10 most voted participations
        require_once(__DIR__ . "/app/controllers/RankingController.class.php");
        (new RankingController())->index();
        break;

    // --- Unknown action ---

    default:
        header("Location: index.php?action=list_challenges");
        break;
}
