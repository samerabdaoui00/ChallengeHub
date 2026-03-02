<?php
session_start();
require_once("Userclasss.php");

if(!isset($_SESSION['user_id'])){
    header("Location: connect.html");
    exit();
}

$user = new User("", "", "");

$message = "";

if(isset($_POST['update'])){
    if($user->update($_POST)){
        $message = "Profil mis à jour ✅";
        $_SESSION['user_name'] = $_POST['name'];
        $_SESSION['user_email'] = $_POST['email'];
    } else {
        $message = "Erreur lors de la mise à jour ❌";
    }
}

if(isset($_POST['delete'])){
    $user->delete();
    exit();
}

if(isset($_POST['logout'])){
    $user->logout();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>

<h2>Bonjour <?php echo $_SESSION['user_name']; ?></h2>

<p style="color:green;"><?php echo $message; ?></p>

<h3>Modifier mon profil</h3>
<form method="post">
    Nom : <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" required><br><br>
    Email : <input type="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" required><br><br>
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