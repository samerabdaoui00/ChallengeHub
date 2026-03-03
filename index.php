<?php
require_once(__DIR__ . "/config/configuration.php");
require_once(__DIR__ . "/app/models/User.php");
$action = isset($_GET['action']) ? $_GET['action'] : 'login';
switch ($action) {
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST['name'], $_POST['email'], $_POST['password']);
            if ($user->register()) {
                header("Location: index.php?action=login&success=1");
            } else {
                $error = "Erreur d'inscription.";
                require_once(__DIR__ . "/app/views/auth/register.php");
            }
        } else {
            require_once(__DIR__ . "/app/views/auth/register.php");
        }
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User("", "", "");
            if ($user->login($_POST['email'], $_POST['password'])) {
                header("Location: index.php?action=profile");
            } else {
                $error = "Identifiants incorrects.";
                require_once(__DIR__ . "/app/views/auth/login.php");
            }
        } else {
            require_once(__DIR__ . "/app/views/auth/login.php");
        }
        break;
    case 'profile':
        require_once(__DIR__ . "/app/controllers/ProfileController.php");
        break;
    case 'list_challenges':
        require_once(__DIR__ . "/app/controllers/ChallengeController.php");
        (new ChallengeController())->list();
        break;
    case 'create_challenge':
        require_once(__DIR__ . "/app/controllers/ChallengeController.php");
        (new ChallengeController())->create();
        break;
    case 'show_challenge':
        require_once(__DIR__ . "/app/controllers/ChallengeController.php");
        (new ChallengeController())->show($_GET['id'] ?? 0);
        break;
    case 'edit_challenge':
        require_once(__DIR__ . "/app/controllers/ChallengeController.php");
        (new ChallengeController())->edit($_GET['id'] ?? 0);
        break;
    case 'delete_challenge':
        require_once(__DIR__ . "/app/controllers/ChallengeController.php");
        (new ChallengeController())->delete($_GET['id'] ?? 0);
        break;
    case 'logout':
        $user = new User("", "", "");
        $user->logout();
        break;
    default:
        header("Location: index.php?action=list_challenges");
        break;
}