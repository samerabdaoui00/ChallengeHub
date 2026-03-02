<?php
class Router {

    public function route() {
        $page = $_GET['page'] ?? 'challenges';

        switch($page){
            case 'challenges':
                require_once '../controllers/ChallengeController.php';
                $controller = new ChallengeController();
                $controller->index();
                break;

            case 'create_challenge':
                require_once '../controllers/ChallengeController.php';
                $controller = new ChallengeController();
                $controller->create();
                break;

            case 'store_challenge':
                require_once '../controllers/ChallengeController.php';
                $controller = new ChallengeController();
                $controller->store();
                break;

            default:
                echo "<h2>Page not found</h2>";
                break;
        }
    }
}