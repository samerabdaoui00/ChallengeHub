<?php
define('USER',   "root");
define('PASSWD', "");
define('SERVER', "localhost");
define('BASE',   "web");

function connect_bd() {
    $dsn = "mysql:host=" . SERVER . ";dbname=" . BASE . ";charset=utf8";
    try {
        $connexion = new PDO($dsn, USER, PASSWD);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        return $connexion;
    } catch (PDOException $e) {
        die("Erreur connexion : " . $e->getMessage());
    }
}
?>
