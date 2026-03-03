<?php
class Controller {

    protected function view($path, $data = []) {
        extract($data);

        $viewFile = __DIR__ . "/../app/views/" . $path . ".php";
        
        if (file_exists($viewFile)) {
            require_once __DIR__ . "/../app/views/layouts/header.php";
            require_once $viewFile;
            require_once __DIR__ . "/../app/views/layouts/footer.php";
        } else {
            die("View $path not found at $viewFile");
        }
    }

    protected function redirect($action) {
        header("Location: index.php?action=" . $action);
        exit();
    }
}