<?php
require_once __DIR__ . "/core/Database.php";
require_once __DIR__ . "/core/Controller.php";
require_once __DIR__ . "/core/router.php";

$router = new Router();
$router->route();
