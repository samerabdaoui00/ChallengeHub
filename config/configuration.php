<?php
// Database connection settings
// Change these if you're running on a different environment
define('USER',   "root");
define('PASSWD', "");       // no password on localhost by default
define('SERVER', "localhost");
define('BASE',   "webb");   // database name

// Creates and returns a PDO connection to the database
// We set ERRMODE_EXCEPTION so any SQL error throws a proper PHP exception
// instead of silently failing
function connect_bd(): PDO
{
    $dsn = "mysql:host=" . SERVER . ";dbname=" . BASE . ";charset=utf8";

    try {
        $connexion = new PDO($dsn, USER, PASSWD);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connexion;
    } catch (PDOException $e) {
        die("Connection error: " . $e->getMessage());
    }
}

// Helper function to safely display strings in HTML
// Always use this in views to avoid XSS attacks (e.g. someone putting <script> in their name)
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
