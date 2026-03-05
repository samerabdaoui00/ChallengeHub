<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - ChallengeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .ch-profile-icon {
            font-size: 5rem;
            color: var(--ch-charcoal);
            opacity: 0.2;
        }
        .ch-stat-card {
            border: 1px solid var(--ch-border);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
        }
        .ch-action-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--ch-border);
            text-decoration: none;
            color: var(--ch-charcoal);
            transition: background 0.2s;
        }
        .ch-action-item:hover {
            background-color: var(--ch-grey-light);
            color: var(--ch-azure);
        }
        .ch-action-item:last-child {
            border-bottom: none;
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
                <div class="ch-sidebar text-center text-md-start">
                    <div class="ch-profile-icon mb-4">👤</div>
                    <h2 class="fw-bold mb-1">User: <?= e($_SESSION['user_name']) ?></h2>
                    <p class="text-muted mb-4">Membre depuis: <?= date('M Y') ?></p>
                    
                    <?php if(!empty($message)): ?>
                        <div class="alert alert-info border-0 shadow-sm small mb-4"><?= $message ?></div>
                    <?php endif; ?>
                    
                    <div class="bg-white border rounded-4 shadow-sm overflow-hidden mb-4">
                        <a href="#" class="ch-action-item">
                            <span class="me-3">👤</span> Modifier le Profil
                        </a>
                        <a href="#" class="ch-action-item">
                            <span class="me-3">🔑</span> Changer le Mot de Passe
                        </a>
                        <a href="#" class="ch-action-item">
                            <span class="me-3">📁</span> Gérer mes Participations
                        </a>
                    </div>

                    <form method="post" onsubmit="return confirm('Attention: Cette action est irréversible. Supprimer votre compte ?');">
                        <button type="submit" name="delete" class="btn btn-link text-danger text-decoration-none small p-0 fw-bold">Supprimer le compte</button>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row g-4 mb-5">
                    <div class="col-6 col-md-6">
                        <div class="ch-stat-card bg-white shadow-sm">
                            <div class="display-6 fw-bold text-charcoal"><?= count($myChallenges) ?></div>
                            <div class="text-muted small fw-bold text-uppercase">Défis Créés</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="ch-stat-card bg-white shadow-sm">
                            <div class="display-6 fw-bold text-charcoal"><?= count($myParticipations) ?></div>
                            <div class="text-muted small fw-bold text-uppercase">Participations</div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="fw-bold mb-4">Paramètres du Profil</h3>
                    <div class="p-4 bg-white border rounded-4 shadow-sm">
                        <form method="post">
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Nom complet</label>
                                    <input type="text" name="name" class="form-control ch-form-control" value="<?= e($_SESSION['user_name']) ?>" required autocomplete="name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control ch-form-control" value="<?= e($_SESSION['user_email']) ?>" required autocomplete="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Mot de passe actuel (requis)</label>
                                    <input type="password" name="current_password" class="form-control ch-form-control" required autocomplete="current-password">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label small fw-bold">Nouveau mot de passe (optionnel)</label>
                                    <input type="password" name="password" class="form-control ch-form-control" placeholder="Laissez vide pour conserver" autocomplete="new-password">
                                </div>
                            </div>
                            <button type="submit" name="update" class="btn ch-btn-charcoal px-5">Mettre à jour</button>
                        </form>
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="fw-bold mb-4">Mes Dernières Activités</h3>
                    <div class="bg-white border rounded-4 shadow-sm overflow-hidden">
                        <?php if(empty($myChallenges) && empty($myParticipations)): ?>
                            <div class="p-4 text-center text-muted">Aucune activité récente.</div>
                        <?php endif; ?>
                        
                        <?php foreach($myChallenges as $c): ?>
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <div class="bg-light rounded px-3 py-2 me-3">🏆</div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold"><?= e($c->getTitle()) ?></h6>
                                    <p class="mb-0 text-muted small">Challenge créé le <?= e($c->getDeadline()) ?></p>
                                </div>
                                <a href="index.php?action=show_challenge&id=<?= $c->getId() ?>" class="btn btn-outline-dark btn-sm rounded-pill px-3">Voir</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>