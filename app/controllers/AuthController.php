<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = new User();
            if ($user->login($email, $password)) {
                $this->redirect('profile');
            } else {
                $this->view('auth/login', ['error' => 'Identifiants incorrects.']);
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($name && $email && $password) {
                $user = new User($name, $email, $password);
                if ($user->register()) {
                    $this->redirect('login&success=1');
                } else {
                    $this->view('auth/register', ['error' => "Erreur d'inscription."]);
                }
            } else {
                $this->view('auth/register', ['error' => 'Tous les champs sont obligatoires.']);
            }
        } else {
            $this->view('auth/register');
        }
    }

    public function logout() {
        User::logout();
        $this->redirect('login');
    }
}
