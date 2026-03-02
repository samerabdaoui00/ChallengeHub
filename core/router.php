<?php

class Router {

    public function route(){

        $url = $_GET['url'] ?? 'challenge/index';

        $parts = explode('/', $url);

        $controllerName = ucfirst($parts[0]).'Controller';
        $method = $parts[1] ?? 'index';

        require_once "../controllers/".$controllerName.".php";

        $controller = new $controllerName();

        $controller->$method();
    }

}