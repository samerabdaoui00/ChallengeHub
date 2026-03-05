<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier ma Participation - ChallengeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-5">
                    <div class="bg-charcoal text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background-color: #333;">
                        <span class="fs-4">✏️</span>
                    </div>
                    <h1 class="fw-bold mb-0">Modifier ma Participation</h1>
                </div>

                <div class="p-5 bg-white border rounded-5 shadow-sm">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 py-3 px-4 mb-4"><?= $error ?></div>
                    <?php endif; ?>

                    <form action="index.php?action=edit_participation&id=<?= $participation->getId() ?>" method="post">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Description / Explication</label>
                                    <textarea name="description" class="form-control ch-form-control" rows="8" required><?= e($participation->getDescription()) ?></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">URL de l'Image</label>
                                    <input type="url" name="image" class="form-control ch-form-control py-3" value="<?= e($participation->getImage()) ?>" required>
                                </div>
                            </div>

                            <div class="col-12 mt-4 text-center">
                                <button type="submit" class="btn ch-btn-charcoal px-5 py-3 fs-5">Sauvegarder les Modifications</button>
                                <div class="mt-3">
                                    <a href="index.php?action=show_challenge&id=<?= $participation->getChallengeId() ?>" class="text-muted text-decoration-none small">Annuler</a>
                                </div>
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