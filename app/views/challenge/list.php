<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Challenges - ChallengeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="bg-white">
    <header class="ch-header d-flex justify-content-between align-items-center">
        <a href="index.php" class="ch-logo">ChallengeHub</a>
        <form action="index.php" method="get" class="flex-grow-1 d-flex justify-content-center">
            <input type="hidden" name="action" value="list_challenges">
            <input type="text" name="q" class="ch-search-bar w-100 mx-4" placeholder="Rechercher..." value="<?= e($_GET['q'] ?? '') ?>">
        </form>
        <div class="d-flex align-items-center">
            <a href="index.php?action=list_challenges" class="ch-icon-btn">🧭</a>
            <a href="index.php?action=create_challenge" class="ch-icon-btn">🔳</a>
            <a href="index.php?action=profile" class="ch-icon-btn">👤</a>
            <a href="index.php?action=logout" class="ch-icon-btn">🚪</a>
        </div>
    </header>

    <main class="container-fluid px-5 py-4">
        <div class="row">
            <div class="col-md-3 ch-sidebar">
                <h5 class="fw-bold mb-4">Filtrer Par Catégories</h5>
                <form action="index.php" method="get">
                    <input type="hidden" name="action" value="list_challenges">
                    <input type="hidden" name="q" value="<?= e($_GET['q'] ?? '') ?>">
                    <div class="list-group list-group-flush">
                        <button type="submit" name="cat" value="" class="list-group-item list-group-item-action border-0 px-0 <?= empty($_GET['cat']) ? 'text-primary fw-bold' : '' ?>">Tout</button>
                        <button type="submit" name="cat" value="Design" class="list-group-item list-group-item-action border-0 px-0 <?= ($_GET['cat'] ?? '') == 'Design' ? 'text-primary fw-bold' : '' ?>">Design</button>
                        <button type="submit" name="cat" value="Développement" class="list-group-item list-group-item-action border-0 px-0 <?= ($_GET['cat'] ?? '') == 'Développement' ? 'text-primary fw-bold' : '' ?>">Développement</button>
                        <button type="submit" name="cat" value="Photographie" class="list-group-item list-group-item-action border-0 px-0 <?= ($_GET['cat'] ?? '') == 'Photographie' ? 'text-primary fw-bold' : '' ?>">Photographie</button>
                        <button type="submit" name="cat" value="Musique" class="list-group-item list-group-item-action border-0 px-0 <?= ($_GET['cat'] ?? '') == 'Musique' ? 'text-primary fw-bold' : '' ?>">Musique</button>
                    </div>
                </form>
            </div>
            
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="fw-bold h2">Défis <span class="text-primary border-bottom border-primary border-3 pb-1">Nouveaux</span></h1>
                    <a href="index.php?action=create_challenge" class="btn ch-btn-charcoal px-4">LANCER UN DÉFI</a>
                </div>

                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success border-0 shadow-sm rounded-3 py-3 px-4 mb-4">
                        Action effectuée avec succès.
                    </div>
                <?php endif; ?>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php if (empty($challenges)): ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted fs-5">Aucun défi trouvé.</p>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($challenges as $c): ?>
                        <div class="col">
                            <div class="card ch-card h-100">
                                <?php if ($c->getImage()): ?>
                                    <img src="<?= e($c->getImage()) ?>" class="card-img-top" alt="<?= e($c->getTitle()) ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <span class="text-muted opacity-50 fs-1">📷</span>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body p-4">
                                    <span class="ch-badge-azure"><?= e($c->getCategory()) ?></span>
                                    <h5 class="card-title fw-bold mb-3"><?= e($c->getTitle()) ?></h5>
                                    <p class="text-muted small mb-4">⌛ Expire le: <span class="fw-bold"><?= e($c->getDeadline()) ?></span></p>
                                    <a href="index.php?action=show_challenge&id=<?= $c->getId() ?>" class="btn ch-btn-charcoal w-100">Explorer</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>