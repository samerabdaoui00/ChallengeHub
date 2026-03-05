<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ChallengeHub</title>
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
            <a href="#" class="ch-icon-btn">🧭</a>
            <a href="#" class="ch-icon-btn">🔳</a>
            <a href="#" class="ch-icon-btn">👤</a>
            <a href="index.php?action=logout" class="ch-icon-btn">🚪</a>
        </div>
    </header>

    <main class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="p-4 bg-white border rounded-4 shadow-sm">
                    <h2 class="fw-bold mb-4">Connexion</h2>
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form action="index.php?action=login" method="post">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control ch-form-control" required autocomplete="email">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Mot de passe</label>
                            <input type="password" name="password" class="form-control ch-form-control" required autocomplete="current-password">
                        </div>
                        <button type="submit" class="btn ch-btn-charcoal w-100 py-3">Se connecter</button>
                    </form>
                    <div class="mt-4 text-center">
                        <p class="text-muted">Pas encore membre ? <a href="index.php?action=register" class="text-primary text-decoration-none fw-bold">S'inscrire</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>