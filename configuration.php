
<?php
//Je me connecte directement avec mysqli
/*
define('serveur','localhost');
define('utilisateur','root');
define('motdepasse','');
define('base','web');

// Connexion à la base de données MySQL
$conn = mysqli_connect(serveur,utilisateur,motdepasse,base);
if($conn===false){
die("ERREUR : Impossible de se connecter. ".mysqli_connect_error());}*/

define('USER', "root");
define('PASSWD', "");
define('SERVER', "localhost");
define('BASE', "web");
//Je crée une fonction qui retourne un objet PDO, capable d’utiliser des requêtes préparées sécurisées
function connect_bd() {
    //je me connecte à MySQL sur SERVER, à la base BASE, avec encodage utf8
    $dsn = "mysql:host=".SERVER.";dbname=".BASE.";charset=utf8";
    try {
        //cree objet représente la connexion à la base
        $connexion = new PDO($dsn, USER, PASSWD);
        return $connexion;
    } catch (PDOException $e) {
        die("Erreur connexion : " . $e->getMessage());
    }
}
?>