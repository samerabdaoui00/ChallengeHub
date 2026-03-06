<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Inscription</title></head>
<body>

<h2>Inscription</h2>

<?php if (isset($erreur)) echo "<p>$erreur</p>"; ?>

<form action="index.php?action=register" method="post">
    Nom : <input type="text" name="name" required><br>
    Email : <input type="email" name="email" required><br>
    Mot de passe : <input type="password" name="password" required><br>
    <input type="submit" value="S'inscrire">
</form>

<a href="index.php?action=login">Deja un compte ? Se connecter</a>

</body>
</html>
