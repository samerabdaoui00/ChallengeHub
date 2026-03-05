<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($challenge->getTitle()) ?> - ChallengeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .ch-hero {
            height: 400px;
            background-size: cover;
            background-position: center;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .ch-hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            padding: 3rem 2rem 2rem;
            color: white;
        }
        .ch-participation-img {
            border-radius: 12px;
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 1rem;
        }
        .ch-vote-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--ch-charcoal);
            transition: color 0.2s;
        }
        .ch-vote-btn.active {
            color: #dc3545;
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

    <main class="container py-4">
        <div class="ch-hero" style="background-image: url('<?= $challenge->getImage() ? e($challenge->getImage()) : 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=1200' ?>')">
            <div class="ch-hero-overlay">
                <span class="badge bg-light text-dark mb-2 px-3 py-2"><?= e($challenge->getCategory()) ?></span>
                <h1 class="display-5 fw-bold"><?= e($challenge->getTitle()) ?></h1>
                <p class="mb-0 opacity-75">Par Utilisateur #<?= $challenge->getUserId() ?> | Expire le: <?= e($challenge->getDeadline()) ?></p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-8">
                <h3 class="fw-bold mb-3">Description</h3>
                <p class="text-secondary fs-5" style="line-height: 1.8;"><?= e($challenge->getDescription()) ?></p>
            </div>
            <div class="col-md-4 text-end align-self-center">
                <a href="index.php?action=submit_participation&challenge_id=<?= $challenge->getId() ?>" class="btn ch-btn-charcoal px-5 py-3 fs-5 w-100">PARTICIPER À CE DÉFI</a>
            </div>
        </div>

        <section>
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <h2 class="fw-bold">Participations <span class="text-primary border-bottom border-primary border-3 pb-1">Récentes</span></h2>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php if (empty($participations)): ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">Soyez le premier à participer !</p>
                    </div>
                <?php endif; ?>
                <?php foreach ($participations as $p): ?>
                    <div class="col">
                        <div class="p-3 bg-white border rounded-4 shadow-sm h-100">
                            <?php if ($p->getImage()): ?>
                                <img src="<?= e($p->getImage()) ?>" class="ch-participation-img" alt="Participation">
                            <?php else: ?>
                                <div class="ch-participation-img bg-light d-flex align-items-center justify-content-center">
                                    <span class="text-muted">No Image</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold small text-charcoal">@user_<?= $p->getUserId() ?></span>
                                <?php 
                                    require_once(__DIR__ . "/../../models/Vote.php");
                                    $voteCount = Vote::countBySubmission($p->getId());
                                    $hasVoted = isset($_SESSION['user_id']) ? Vote::hasVoted($p->getId(), $_SESSION['user_id']) : false;
                                ?>
                                <div class="d-flex align-items-center">
                                    <a href="index.php?action=vote_submission&submission_id=<?= $p->getId() ?>" class="ch-vote-btn <?= $hasVoted ? 'active' : '' ?>">
                                        <?= $hasVoted ? '❤️' : '♡' ?>
                                    </a>
                                    <span class="ms-1 fw-bold"><?= $voteCount ?></span>
                                </div>
                            </div>
                            <p class="text-muted small mb-0"><?= e(mb_strimwidth($p->getDescription(), 0, 100, "...")) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>