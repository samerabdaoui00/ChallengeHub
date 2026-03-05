<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement - ChallengeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .ch-rank-card {
            border: 1px solid var(--ch-border);
            border-radius: 12px;
            transition: transform 0.2s;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        .ch-rank-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--ch-charcoal);
            opacity: 0.1;
            width: 80px;
            text-align: center;
        }
        .ch-entry-img {
            width: 100px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-white">
    <header class="ch-header d-flex justify-content-between align-items-center">
        <a href="index.php" class="ch-logo">ChallengeHub</a>
        <div class="flex-grow-1 d-flex justify-content-center">
            <input type="text" class="ch-search-bar w-100 mx-4" placeholder="Rechercher...">
        </div>
        <div class="d-flex align-items-center">
            <a href="index.php?action=list_challenges" class="ch-icon-btn">🧭</a>
            <a href="index.php?action=create_challenge" class="ch-icon-btn">🔳</a>
            <a href="index.php?action=profile" class="ch-icon-btn">👤</a>
            <a href="index.php?action=logout" class="ch-icon-btn">🚪</a>
        </div>
    </header>

    <main class="container py-5">
        <div class="mb-5 text-center">
            <h1 class="display-4 fw-bold">Top <span class="text-primary border-bottom border-primary border-4">Créations</span></h1>
            <p class="text-muted fs-5 mt-3">Les contributions les plus votées de la communauté.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="list-group list-group-flush shadow-sm border rounded-4 bg-white overflow-hidden">
                    <?php if (empty($rankings)): ?>
                        <div class="list-group-item p-5 text-center text-muted fs-5">Aucune donnée disponible pour le moment.</div>
                    <?php endif; ?>
                    
                    <?php foreach ($rankings as $index => $r): 
                        $p = $r['participation'];
                    ?>
                        <div class="list-group-item p-4 d-flex align-items-center border-bottom">
                            <div class="ch-rank-number"><?= $index + 1 ?></div>
                            
                            <div class="me-4 flex-shrink-0">
                                <?php if ($p->getImage()): ?>
                                    <img src="<?= e($p->getImage()) ?>" class="ch-entry-img" alt="Entry">
                                <?php else: ?>
                                    <div class="ch-entry-img bg-light"></div>
                                <?php endif; ?>
                            </div>

                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1"><?= e(mb_strimwidth($p->getDescription(), 0, 50, "...")) ?></h5>
                                <p class="mb-0 text-muted small">
                                    Défi: <span class="fw-bold text-dark"><?= e($r['challenge_title']) ?></span> | 
                                    Créé le <?= e($p->getCreatedAt()) ?>
                                </p>
                            </div>

                            <div class="text-center ms-4">
                                <div class="fs-3 fw-bold text-azure"><?= $r['vote_count'] ?></div>
                                <div class="text-muted small fw-bold text-uppercase">Votes</div>
                            </div>
                            
                            <div class="ms-4">
                                <a href="index.php?action=show_challenge&id=<?= $p->getChallengeId() ?>" class="btn btn-outline-dark rounded-pill px-4">Voir</a>
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