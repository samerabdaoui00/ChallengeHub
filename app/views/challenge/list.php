<?php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Challenges - ChallengeHub</title>
    <style>
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; padding: 20px; }
        .card { border: 1px solid 
        .card:hover { transform: translateY(-5px); }
        .card img { width: 100%; height: 180px; object-fit: cover; }
        .card-content { padding: 15px; }
        .category { color: 
        .btn { display: inline-block; padding: 8px 15px; background: 
        .deadline { color: 
    </style>
</head>
<body style="background: 
    <nav style="background: white; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <a href="index.php?action=list_challenges">Challenges</a> | 
        <a href="index.php?action=profile">Mon Profil</a> | 
        <a href="index.php?action=create_challenge">Créer un Challenge</a> |
        <a href="index.php?action=logout">Déconnexion</a>
    </nav>
    <div style="padding: 20px;">
        <h1>Challenges Disponibles</h1>
        <?php if(isset($_GET['success'])): ?>
            <p style="background: 
        <?php endif; ?>
        <div class="grid">
            <?php foreach ($challenges as $c): ?>
                <div class="card">
                    <?php if ($c->getImage()): ?>
                        <img src="<?= e($c->getImage()) ?>" alt="<?= e($c->getTitle()) ?>">
                    <?php else: ?>
                        <div style="width: 100%; height: 180px; background: 
                    <?php endif; ?>
                    <div class="card-content">
                        <span class="category"><?= e($c->getCategory()) ?></span>
                        <h3 style="margin: 10px 0;"><?= e($c->getTitle()) ?></h3>
                        <p class="deadline">⌛ Expire le: <?= e($c->getDeadline()) ?></p>
                        <a href="index.php?action=show_challenge&id=<?= $c->getId() ?>" class="btn">Participer / Détails</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>