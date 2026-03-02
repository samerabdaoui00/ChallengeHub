<?php
require_once("Userclasss.php");

// Vérifie si le formulaire a été envoyé
if(isset($_POST["name"], $_POST["email"], $_POST["password"])) {

    // Crée l’objet User avec les données du formulaire
    $user = new User($_POST["name"], $_POST["email"], $_POST["password"]);

    // Appelle la fonction register()
    if($user->register()) {
        echo "<h3>Inscription réussie ✅</h3>";
        echo "<a href='connect.html'>Se connecter</a>";
    } else {
        echo "Erreur lors de l'inscription ❌";
    }
} else {
    echo "Remplissez tous les champs du formulaire.";
}
?>