<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Submission.php';

class SubmissionController extends Controller {

    public function index(){

        $challenge_id = $_GET['challenge_id'];

        $model = new Submission();
        $submissions = $model->getByChallenge($challenge_id);

        $this->view('submission/list',[
            'submissions' => $submissions,
            'challenge_id' => $challenge_id
        ]);
    }

    public function create(){

        $challenge_id = $_GET['challenge_id'];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $name = $_POST['name'];
            $work = $_POST['work'];

            $model = new Submission();
            $model->create($challenge_id,$name,$work);

            header("Location: index.php?page=submissions&challenge_id=".$challenge_id);
            exit;
        }

        $this->view('submission/create',[
            'challenge_id'=>$challenge_id
        ]);
    }

    public function vote(){

        $submission_id = $_GET['id'];
        $challenge_id = $_GET['challenge_id'];

        $model = new Submission();
        $model->vote($submission_id);

        header("Location: index.php?page=submissions&challenge_id=".$challenge_id);
    }
}