<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Challenge.php';

class ChallengeController extends Controller {

    public function index() {
        $challengeModel = new Challenge();
        $challenges = $challengeModel->getAll();
        $this->view('challenges/list', ['challenges' => $challenges]);
    }

    public function create() {
        $this->view('challenges/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $category = trim($_POST['category'] ?? '');

            if ($title && $description && $category) {
                $challengeModel = new Challenge();
                $challengeModel->create($title, $description, $category);
                $this->redirect('challenges');
            } else {
                $this->view('challenges/create', ['error' => "Tous les champs sont obligatoires."]);
            }
        }
    }
}