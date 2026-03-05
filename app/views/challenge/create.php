<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lancer un Nouveau Défi - ChallengeHub</title>
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
            <div class="col-md-9">
                <div class="d-flex align-items-center mb-5">
                    <div class="bg-charcoal text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background-color: #333;">
                        <span class="fs-4">➕</span>
                    </div>
                    <h1 class="fw-bold mb-0">Lancer un Nouveau Défi</h1>
                </div>

                <div class="p-5 bg-white border rounded-5 shadow-sm">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 py-3 px-4 mb-4"><?= $error ?></div>
                    <?php endif; ?>

                    <form action="index.php?action=create_challenge" method="post">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Titre du Défi</label>
                                    <input type="text" name="title" class="form-control ch-form-control py-3" placeholder="Donnez un nom inspirant à votre défi" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Catégorie</label>
                                    <select name="cat" class="form-select ch-form-control py-3" required>
                                        <option value="Design">Design</option>
                                        <option value="Développement">Développement</option>
                                        <option value="Photographie">Photographie</option>
                                        <option value="Musique">Musique</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Description Détaillée</label>
                                    <textarea name="description" class="form-control ch-form-control" rows="6" placeholder="Expliquez les règles et l'objectif du défi..." required></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Date Limite (Deadline)</label>
                                    <input type="date" name="deadline" class="form-control ch-form-control py-3" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">URL de l'Image d'Illustration (Optionnel)</label>
                                    <div class="d-flex gap-2">
                                        <input type="url" name="image" class="form-control ch-form-control py-3" placeholder="https://...">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3">📁</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-5 text-center">
                                <button type="submit" class="btn ch-btn-charcoal px-5 py-3 fs-5">Publier le Défi</button>
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