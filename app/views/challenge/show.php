<?php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= e($challenge->getTitle()) ?> - ChallengeHub</title>
    <style>
        .container { max-width: 800px; margin: 20px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .meta { color: 
        .badge { background: 
        .participation-item { border-bottom: 1px solid 
    </style>
</head>
<body style="background: 
    <nav style="padding: 15px;">
        <a href="index.php?action=list_challenges">← Retour aux challenges</a>
    </nav>
    <div class="container">
        <span class="badge"><?= e($challenge->getCategory()) ?></span>
        <h1 style="margin-top: 10px;"><?= e($challenge->getTitle()) ?></h1>
        <div class="meta">
            Par l'utilisateur ID: <?= $challenge->getUserId() ?> | 
            <span style="color: 
        </div>
        <?php if ($challenge->getImage()): ?>
            <img src="<?= e($challenge->getImage()) ?>" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
        <?php endif; ?>
        <h3>Description</h3>
        <p style="line-height: 1.6; color: 
        <hr style="margin: 40px 0; opacity: 0.2;">
        <h2>Participations (<?= count($participations) ?>)</h2>
        <?php if (empty($participations)): ?>
            <p style="color: 
        <?php else: ?>
            <?php foreach ($participations as $p): ?>
                <div class="participation-item">
                    <strong>Soumission 
                    <p><?= nl2br(e($p->getDescription())) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div style="margin-top: 40px; border-top: 1px solid 
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $challenge->getUserId()): ?>
                <a href="index.php?action=edit_challenge&id=<?= $challenge->getId() ?>" style="color: 
                <a href="index.php?action=delete_challenge&id=<?= $challenge->getId() ?>" onclick="return confirm('Confirmer la suppression ?')" style="color: 
            <?php endif; ?>
        </div>
    </div>
</body>
</html>