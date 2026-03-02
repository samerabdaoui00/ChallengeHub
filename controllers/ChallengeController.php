<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Challenge.php';

class ChallengeController extends Controller {

    // Display all challenges
    public function index() {
        $challenge = new Challenge();
        $challenges = $challenge->getAll();

        $this->view('challenge/list', ['challenges' => $challenges]);
    }

    // Show create challenge form
    public function create() {
        $this->view('challenge/create');
    }

    // Save new challenge to database
    public function store() {
        if(isset($_POST['title']) && isset($_POST['description'])) {
            $challenge = new Challenge();
            $challenge->create($_POST['title'], $_POST['description']);
        }
        header("Location: index.php?url=challenge/index");
    }

    // Add a vote to a challenge
    public function vote() {
        if(isset($_POST['challenge_id'])) {
            $challenge = new Challenge();
            $challenge->vote($_POST['challenge_id']);
        }
        header("Location: index.php?url=challenge/index");
    }
    // Show edit form
public function edit() {
    if(!isset($_GET['id'])) { header("Location: index.php?url=challenge/index"); exit; }

    $challenge = new Challenge();
    $ch = $challenge->getAll(); // We'll fetch single challenge below
    // better to have getById function in model
    $ch = $challenge->getById($_GET['id']); 

    $this->view('challenge/edit', ['challenge' => $ch]);
}

// Handle update form submission
public function update() {
    if(isset($_POST['id'], $_POST['title'], $_POST['description'])) {
        $challenge = new Challenge();
        $challenge->update($_POST['id'], $_POST['title'], $_POST['description']);
    }
    header("Location: index.php?url=challenge/index");
}

// Handle delete
public function destroy() {
    if(isset($_POST['id'])) {
        $challenge = new Challenge();
        $challenge->delete($_POST['id']);
    }
    header("Location: index.php?url=challenge/index");
}
}