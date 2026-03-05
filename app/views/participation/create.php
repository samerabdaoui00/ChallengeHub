<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soumettre Votre Création - ChallengeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .ch-summary-card {
            border: 1px solid var(--ch-border);
            border-radius: 20px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            position: sticky;
            top: 2rem;
        }
        .ch-summary-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
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
        <div class="row g-5">
            <div class="col-md-4">
                <div class="ch-summary-card">
                    <?php if ($challenge->getImage()): ?>
                        <img src="<?= e($challenge->getImage()) ?>" class="ch-summary-img" alt="Challenge">
                    <?php else: ?>
                        <div class="ch-summary-img bg-light"></div>
                    <?php endif; ?>
                    <div class="p-4">
                        <span class="ch-badge-azure"><?= e($challenge->getCategory()) ?></span>
                        <h4 class="fw-bold mb-0">DÉFI: <?= e($challenge->getTitle()) ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="d-flex align-items-center mb-5">
                    <div class="bg-charcoal text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background-color: #333;">
                        <span class="fs-4">✏️</span>
                    </div>
                    <h1 class="fw-bold mb-0">Soumettre Votre Création</h1>
                </div>

                <div class="p-5 bg-white border rounded-5 shadow-sm">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 py-3 px-4 mb-4"><?= $error ?></div>
                    <?php endif; ?>

                    <form action="index.php?action=submit_participation&challenge_id=<?= $challenge->getId() ?>" method="post">
                        <div class="row g-4">

                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Description / Explication</label>
                                    <textarea name="description" class="form-control ch-form-control" rows="8" placeholder="Expliquez votre processus créatif..." required></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Téléverser Votre Création (URL de l'Image)</label>
                                    <div class="border-2 border-dashed rounded-4 p-5 text-center bg-light mb-2" style="border-style: dashed !important;">
                                        <span class="fs-1 d-block mb-2">📸</span>
                                        <input type="url" name="image" class="form-control ch-form-control py-2 text-center" placeholder="https://image-url.com/votre-creation.jpg" required>
                                        <p class="text-muted small mt-2">Veuillez fournir un lien direct vers votre image.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn ch-btn-charcoal px-5 py-3 fs-5">Envoyer ma Soumission</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>