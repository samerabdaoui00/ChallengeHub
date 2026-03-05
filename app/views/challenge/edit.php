<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier Challenge - ChallengeHub</title>
    <style>
        .form-container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid 
        .btn { background: 
    </style>
</head>
<body style="background: 
    <nav style="padding: 15px;">
        <a href="index.php?action=show_challenge&id=<?= $challenge->getId() ?>">← Annuler</a>
    </nav>
    <div class="form-container">
        <h2>Modifier le Challenge</h2>
        <?php if(isset($error)): ?>
            <p style="color: red;"><?= e($error) ?></p>
        <?php endif; ?>
        <form action="index.php?action=edit_challenge&id=<?= $challenge->getId() ?>" method="post">
            <div class="form-group">
                <label>Titre</label>
                <input type="text" name="title" value="<?= e($challenge->getTitle()) ?>" required>
            </div>
            <div class="form-group">
                <label>Catégorie</label>
                <select name="category" required>
                    <option value="Design" <?= $challenge->getCategory() == 'Design' ? 'selected' : '' ?>>Design</option>
                    <option value="Développement" <?= $challenge->getCategory() == 'Développement' ? 'selected' : '' ?>>Développement</option>
                    <option value="Photographie" <?= $challenge->getCategory() == 'Photographie' ? 'selected' : '' ?>>Photographie</option>
                    <option value="Musique" <?= $challenge->getCategory() == 'Musique' ? 'selected' : '' ?>>Musique</option>
                    <option value="Autre" <?= $challenge->getCategory() == 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" required><?= e($challenge->getDescription()) ?></textarea>
            </div>
            <div class="form-group">
                <label>URL de l'image</label>
                <input type="url" name="image" value="<?= e($challenge->getImage()) ?>">
            </div>
            <div class="form-group">
                <label>Date limite</label>
                <input type="date" name="deadline" value="<?= e($challenge->getDeadline()) ?>" required>
            </div>
            <button type="submit" class="btn">Mettre à jour</button>
        </form>
    </div>
</body>
</html>