<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class ProfileController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
        }
    }

    public function show() {
        $user = User::findById($_SESSION['user_id']);
        $this->view('profile/show', ['user' => $user]);
    }

    public function edit() {
        $user = User::findById($_SESSION['user_id']);
        $this->view('profile/edit', ['user' => $user]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            if ($user->update($_POST)) {
                $_SESSION['user_name'] = $_POST['name'];
                $_SESSION['user_email'] = $_POST['email'];
                $this->redirect('profile&success=1');
            } else {
                $user = User::findById($_SESSION['user_id']);
                $this->view('profile/edit', ['user' => $user, 'error' => 'Erreur lors de la mise à jour ou mot de passe incorrect.']);
            }
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
            if (User::delete($_SESSION['user_id'])) {
                User::logout();
                $this->redirect('login&deleted=1');
            }
        } else {
            $this->view('profile/delete');
        }
    }
}
