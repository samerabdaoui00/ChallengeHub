<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Profil</title></head>
<body>

<h2>Bonjour <?php echo $_SESSION['user_name']; ?></h2>

<?php if (isset($success)) echo "<p>$success</p>"; ?>
<?php if (isset($erreur))  echo "<p>$erreur</p>"; ?>

<h3>Modifier le profil</h3>
<form action="index.php?action=profil" method="post">
    Nom : <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" required><br>
    Email : <input type="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" required><br>
    Mot de passe actuel : <input type="password" name="current_password" required><br>
    Nouveau mot de passe : <input type="password" name="new_password"><br>
    <input type="submit" name="update" value="Modifier">
</form>

<h3>Supprimer le compte</h3>
<form action="index.php?action=profil" method="post" onsubmit="return confirm('Etes-vous sur ?');">
    <input type="submit" name="delete" value="Supprimer mon compte">
</form>

<h3>Deconnexion</h3>
<a href="index.php?action=logout"><button>Se deconnecter</button></a>

</body>
</html>
