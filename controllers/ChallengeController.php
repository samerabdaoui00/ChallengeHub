<?php
require_once '../core/Controller.php';
require_once '../models/challenge.php';

class ChallengeController extends Controller {

    // Show all challenges
    public function index() {
        $challengeModel = new Challenge();
        $challenges = $challengeModel->getAll();
        $this->view('challenge/list', ['challenges' => $challenges]);
    }

    // Show create challenge form
    public function create() {
        $this->view('challenge/create');
    }

    // Handle form submission
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $category = trim($_POST['category'] ?? '');

            if($title && $description && $category){
                $challengeModel = new Challenge();
                $challengeModel->create($title, $description, $category);
                header('Location: index.php?page=challenges');
                exit;
            } else {
                $error = "All fields are required.";
                $this->view('challenge/create', ['error' => $error]);
            }
        }
    }
}