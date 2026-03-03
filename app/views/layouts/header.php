<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChallengeHub</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f7f6; }
        nav { background-color: #2c3e50; padding: 1rem; display: flex; justify-content: space-between; align-items: center; color: white; }
        nav a { color: white; text-decoration: none; margin: 0 10px; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 1000px; margin: 2rem auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block; cursor: pointer; border: none; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-danger { background-color: #e74c3c; color: white; }
    </style>
</head>
<body>
<nav>
    <div class="logo"><strong>ChallengeHub</strong></div>
    <div class="menu">
        <a href="index.php?action=challenges">Challenges</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?action=profile">Mon Profil</a>
            <a href="index.php?action=logout">Déconnexion</a>
        <?php else: ?>
            <a href="index.php?action=login">Connexion</a>
            <a href="index.php?action=register">Inscription</a>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
<?php if (isset($error)): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>
<?php if (isset($_GET['success'])): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        Opération réussie !
    </div>
<?php endif; ?>
