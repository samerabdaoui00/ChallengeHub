<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Connexion</title></head>
<body>

<h2>Connexion</h2>

<?php if (isset($erreur)) echo "<p>$erreur</p>"; ?>
<?php if (isset($_GET['success'])) echo "<p>Inscription reussie ! Connectez-vous.</p>"; ?>

<form action="index.php?action=login" method="post">
    Email : <input type="email" name="email" required><br>
    Mot de passe : <input type="password" name="password" required><br>
    <input type="submit" value="Se connecter">
</form>

<a href="index.php?action=register">Pas de compte ? S'inscrire</a>

</body>
</html>
