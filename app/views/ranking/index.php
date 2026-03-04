<?php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Classement - ChallengeHub</title>
    <style>
        .container { max-width: 900px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; background: 
        td { padding: 15px; border-bottom: 1px solid 
        .rank { font-weight: bold; font-size: 1.2em; color: 
        .vote-badge { background: 
        .submission-img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
        .challenge-tag { font-size: 0.8em; color: 
    </style>
</head>
<body style="background: 
    <nav style="background: white; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <a href="index.php?action=list_challenges">Challenges</a> | 
        <a href="index.php?action=ranking">Classement</a> |
        <a href="index.php?action=profile">Mon Profil</a> | 
        <a href="index.php?action=create_challenge">Créer un Challenge</a> |
        <a href="index.php?action=logout">Déconnexion</a>
    </nav>
    <div class="container">
        <h1>🏆 Top 10 Contributions</h1>
        <p style="color: 
        <table>
            <thead>
                <tr>
                    <th>Rang</th>
                    <th>Aperçu</th>
                    <th>Détails</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rankings)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: 
                    </tr>
                <?php else: ?>
                    <?php foreach ($rankings as $index => $r): ?>
                        <tr>
                            <td class="rank">
                            <td>
                                <?php if ($r['participation']->getImage()): ?>
                                    <img src="<?= e($r['participation']->getImage()) ?>" class="submission-img">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; background: 
                                <?php endif; ?>
                            </td>
                            <td>
                                <div><strong>ID Utilisateur: <?= $r['participation']->getUserId() ?></strong></div>
                                <div style="margin-top: 5px;">
                                    <span class="challenge-tag"><?= e($r['challenge_title']) ?></span>
                                </div>
                                <div style="font-size: 0.85em; color: 
                                    <?= e(mb_strimwidth($r['participation']->getDescription(), 0, 100, "...")) ?>
                                </div>
                            </td>
                            <td>
                                <span class="vote-badge">★ <?= $r['vote_count'] ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div style="margin-top: 30px; text-align: center;">
            <a href="index.php?action=list_challenges" style="color: 
        </div>
    </div>
</body>
</html>