<?php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
<h2>Bonjour <?php echo e($_SESSION['user_name']); ?></h2>
<p style="color:green;"><?php echo e($message); ?></p>
<h3>Modifier mon profil</h3>
<form method="post">
    Nom : <input type="text" name="name" value="<?php echo e($_SESSION['user_name']); ?>" required><br><br>
    Email : <input type="email" name="email" value="<?php echo e($_SESSION['user_email']); ?>" required><br><br>
    Mot de passe actuel : <input type="password" name="current_password" required><br><br>
    Nouveau mot de passe : <input type="password" name="password"><br><br>
    <input type="submit" name="update" value="Modifier">
</form>
<h3>Supprimer mon compte</h3>
<form method="post" onsubmit="return confirm('Êtes-vous sûr ?');">
    <input type="submit" name="delete" value="Supprimer mon compte">
</form>
<h3>Se déconnecter</h3>
<form method="post">
    <input type="submit" name="logout" value="Se déconnecter">
</form>
</body>
</html>