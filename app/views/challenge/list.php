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
        .search-bar { background: white; padding: 20px; margin: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; gap: 10px; flex-wrap: wrap; }
        .search-bar input, .search-bar select { padding: 10px; border: 1px solid 
        .search-bar button { padding: 10px 20px; background: 
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
    <div style="padding: 20px;">
        <h1>Challenges Disponibles</h1>
        <form action="index.php" method="get" class="search-bar">
            <input type="hidden" name="action" value="list_challenges">
            <input type="text" name="q" placeholder="Rechercher par mot-clé..." value="<?= e($_GET['q'] ?? '') ?>">
            <select name="cat">
                <option value="">Toutes les catégories</option>
                <option value="Design" <?= ($_GET['cat'] ?? '') == 'Design' ? 'selected' : '' ?>>Design</option>
                <option value="Développement" <?= ($_GET['cat'] ?? '') == 'Développement' ? 'selected' : '' ?>>Développement</option>
                <option value="Photographie" <?= ($_GET['cat'] ?? '') == 'Photographie' ? 'selected' : '' ?>>Photographie</option>
                <option value="Musique" <?= ($_GET['cat'] ?? '') == 'Musique' ? 'selected' : '' ?>>Musique</option>
                <option value="Autre" <?= ($_GET['cat'] ?? '') == 'Autre' ? 'selected' : '' ?>>Autre</option>
            </select>
            <button type="submit">Filtrer</button>
        </form>
        <?php if(isset($_GET['success'])): ?>
            <p style="background: 
        <?php endif; ?>
        <div class="grid">
            <?php if (empty($challenges)): ?>
                <p style="grid-column: 1/-1; text-align: center; color: 
            <?php endif; ?>
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