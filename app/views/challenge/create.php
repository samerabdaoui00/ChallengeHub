<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Créer un Challenge - ChallengeHub</title>
    <style>
        .form-container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid 
        .btn { background: 
        .btn:hover { background: 
    </style>
</head>
<body style="background: 
    <nav style="padding: 15px;">
        <a href="index.php?action=list_challenges">← Annuler</a>
    </nav>
    <div class="form-container">
        <h2>Lancer un nouveau Challenge</h2>
        <?php if(isset($error)): ?>
            <p style="color: red;"><?= e($error) ?></p>
        <?php endif; ?>
        <form action="index.php?action=create_challenge" method="post">
            <div class="form-group">
                <label>Titre du Challenge</label>
                <input type="text" name="title" required placeholder="Ex: Meilleur Logo 2024">
            </div>
            <div class="form-group">
                <label>Catégorie</label>
                <select name="category" required>
                    <option value="Design">Design</option>
                    <option value="Développement">Développement</option>
                    <option value="Photographie">Photographie</option>
                    <option value="Musique">Musique</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" required placeholder="Détails, règles, prix..."></textarea>
            </div>
            <div class="form-group">
                <label>URL de l'image de couverture</label>
                <input type="url" name="image" placeholder="https:
            </div>
            <div class="form-group">
                <label>Date limite</label>
                <input type="date" name="deadline" required>
            </div>
            <button type="submit" class="btn">Créer le Challenge</button>
        </form>
    </div>
</body>
</html>