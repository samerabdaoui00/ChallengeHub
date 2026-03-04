<?php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier ma participation - ChallengeHub</title>
    <style>
        .form-container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid 
        .btn { background: 
    </style>
</head>
<body style="background: 
    <nav style="padding: 15px;">
        <a href="index.php?action=show_challenge&id=<?= $participation->getChallengeId() ?>">← Annuler</a>
    </nav>
    <div class="form-container">
        <h2>Modifier ma participation</h2>
        <?php if(isset($error)): ?>
            <p style="color: red;"><?= e($error) ?></p>
        <?php endif; ?>
        <form action="index.php?action=edit_participation&id=<?= $participation->getId() ?>" method="post">
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" required><?= e($participation->getDescription()) ?></textarea>
            </div>
            <div class="form-group">
                <label>Lien de l'image</label>
                <input type="url" name="image" value="<?= e($participation->getImage()) ?>">
            </div>
            <button type="submit" class="btn">Mettre à jour ma participation</button>
        </form>
    </div>
</body>
</html>