<?php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - ChallengeHub</title>
    <style>
        .container { max-width: 1000px; margin: 40px auto; display: grid; grid-template-columns: 1fr 2fr; gap: 30px; padding: 0 20px; }
        .sidebar { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); height: fit-content; }
        .main-content { display: flex; flex-direction: column; gap: 30px; }
        .section { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h1, h2, h3 { margin-top: 0; color: 
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; font-size: 0.9em; color: 
        .form-group input { width: 100%; padding: 12px; border: 1px solid 
        .btn { padding: 12px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; transition: opacity 0.2s; }
        .btn-primary { background: 
        .btn-danger { background: 
        .btn-secondary { background: 
        .activity-item { display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid 
        .activity-item:last-child { border-bottom: none; }
        .activity-item:hover { background: 
        .activity-info h4 { margin: 0 0 5px 0; color: 
        .activity-info p { margin: 0; font-size: 0.85em; color: 
        .badge { background: 
    </style>
</head>
<body style="background: 
    <nav style="background: white; padding: 15px 40px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
        <a href="index.php" style="font-weight: bold; color: 
        <div>
            <a href="index.php?action=list_challenges" style="margin-right: 20px; text-decoration: none; color: 
            <a href="index.php?action=ranking" style="margin-right: 20px; text-decoration: none; color: 
            <a href="index.php?action=logout" style="color: 
        </div>
    </nav>
    <div class="container">
        <div class="sidebar">
            <h2>Mon Compte</h2>
            <?php if(!empty($message)): ?>
                <div style="padding: 10px; border-radius: 6px; background: 
                    <?= $message ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" name="name" value="<?= e($_SESSION['user_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= e($_SESSION['user_email']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe actuel (requis)</label>
                    <input type="password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label>Nouveau mot de passe (optionnel)</label>
                    <input type="password" name="password" placeholder="Laissez vide pour conserver">
                </div>
                <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
            </form>
            <hr style="margin: 30px 0; border: 0; border-top: 1px solid 
            <form method="post" onsubmit="return confirm('Attention: Cette action est irréversible. Supprimer votre compte ?');">
                <button type="submit" name="delete" class="btn btn-danger">Supprimer le compte</button>
            </form>
        </div>
        <div class="main-content">
            <div class="section">
                <h3>Mes Challenges Créés (<?= count($myChallenges) ?>)</h3>
                <?php if(empty($myChallenges)): ?>
                    <p style="color: 
                <?php else: ?>
                    <?php foreach($myChallenges as $c): ?>
                        <div class="activity-item">
                            <div class="activity-info">
                                <h4><?= e($c->getTitle()) ?></h4>
                                <p>Catégorie: <?= e($c->getCategory()) ?> | Expire le: <?= e($c->getDeadline()) ?></p>
                            </div>
                            <a href="index.php?action=show_challenge&id=<?= $c->getId() ?>" class="badge" style="text-decoration: none;">Voir</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="section">
                <h3>Mes Participations (<?= count($myParticipations) ?>)</h3>
                <?php if(empty($myParticipations)): ?>
                    <p style="color: 
                <?php else: ?>
                    <?php foreach($myParticipations as $p): ?>
                        <div class="activity-item">
                            <div class="activity-info">
                                <h4>Contribution 
                                <p><?= e(mb_strimwidth($p->getDescription(), 0, 80, "...")) ?></p>
                            </div>
                            <a href="index.php?action=show_challenge&id=<?= $p->getChallengeId() ?>" class="badge" style="text-decoration: none;">Voir le Challenge</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>