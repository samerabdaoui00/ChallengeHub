<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Soumettre une participation - ChallengeHub</title>
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
        <a href="index.php?action=show_challenge&id=<?= $challenge_id ?>">← Annuler</a>
    </nav>
    <div class="form-container">
        <h2>Votre participation pour : <?= e($challenge->getTitle()) ?></h2>
        <?php if(isset($error)): ?>
            <p style="color: red;"><?= e($error) ?></p>
        <?php endif; ?>
        <form action="index.php?action=submit_participation&challenge_id=<?= $challenge_id ?>" method="post">
            <div class="form-group">
                <label>Description / Présentation</label>
                <textarea name="description" rows="5" required placeholder="Expliquez votre travail..."></textarea>
            </div>
            <div class="form-group">
                <label>Lien de l'image (Ex: Un lien vers votre design ou capture)</label>
                <input type="url" name="image" placeholder="https:
            </div>
            <button type="submit" class="btn">Envoyer ma participation</button>
        </form>
    </div>
</body>
</html>