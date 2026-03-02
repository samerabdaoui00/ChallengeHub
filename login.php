<?php
require_once("Userclasss.php");

if(isset($_POST["email"], $_POST["password"])) {

    $user = new User("", "", ""); // on ne l'utilise pas pour register ici

    if($user->login($_POST["email"], $_POST["password"])) {
        echo "<h3>Connexion réussie ✅</h3>";
        echo "Bienvenue " . $_SESSION['user_name'];
    } else {
        echo "Email ou mot de passe incorrect ❌";
    }

} else {
    echo "Veuillez remplir tous les champs.";
}
?>