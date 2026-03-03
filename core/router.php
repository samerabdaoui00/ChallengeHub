<?php
class Router {
    public function route() {
        $action = $_GET['action'] ?? 'login';

        switch ($action) {
            case 'login':
            case 'register':
            case 'logout':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                if ($action === 'login') $controller->login();
                if ($action === 'register') $controller->register();
                if ($action === 'logout') $controller->logout();
                break;

            case 'profile':
            case 'edit_profile':
            case 'update_profile':
            case 'delete_profile':
                require_once __DIR__ . '/../app/controllers/ProfileController.php';
                $controller = new ProfileController();
                if ($action === 'profile') $controller->show();
                if ($action === 'edit_profile') $controller->edit();
                if ($action === 'update_profile') $controller->update();
                if ($action === 'delete_profile') $controller->delete();
                break;

            case 'challenges':
            case 'create_challenge':
            case 'store_challenge':
                require_once __DIR__ . '/../app/controllers/ChallengeController.php';
                $controller = new ChallengeController();
                if ($action === 'challenges') $controller->index();
                if ($action === 'create_challenge') $controller->create();
                if ($action === 'store_challenge') $controller->store();
                break;

            default:
                header("Location: index.php?action=login");
                break;
        }
    }
}