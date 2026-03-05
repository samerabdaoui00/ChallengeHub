<?php
session_start();
require_once 'db.php';
require_once 'functions.php';  


$submission_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($submission_id <= 0) {
    die("Participation introuvable");
}

$comments = getCommentsBySubmission($submission_id);

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    if (!isLoggedIn()) {
        $errors[] = "Vous devez être connecté pour commenter.";
    } else {
        $content = trim($_POST['content']);
        if (empty($content)) {
            $errors[] = "Le commentaire ne peut pas être vide.";
        } elseif (strlen($content) > 1000) {
            $errors[] = "Le commentaire est trop long (max 1000 caractères).";
        } else {
            // Sécurité XSS : on échappe les balises dangereuses
            $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
            
            if (addComment($submission_id, $_SESSION['user_id'], $content)) {
                $success = true;
                // Option : recharger les commentaires
                $comments = getCommentsBySubmission($submission_id);
            } else {
                $errors[] = "Erreur lors de l'ajout du commentaire.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail Participation - ChallengeHub</title>
    <style>
        .comment {
            background: #f8f9fa;
            padding: 12px 16px;
            margin: 12px 0;
            border-radius: 8px;
            border-left: 4px solid #6366f1;
        }
        .comment-header {
            display: flex;
            justify-content: space-between;
            font-size: 0.9em;
            color: #6b7280;
            margin-bottom: 6px;
        }
        .comment-form textarea {
            width: 100%;
            min-height: 80px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }
        .btn-comment {
            background: #6366f1;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-comment:hover { background: #4f46e5; }
    </style>
</head>
<body>

<h2>Commentaires sur cette participation</h2>

<?php if (!empty($errors)): ?>
    <div style="color: red; margin: 15px 0;">
        <?= implode('<br>', $errors) ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="color: green; margin: 15px 0;">
        Commentaire ajouté avec succès !
    </div>
<?php endif; ?>

<?php if (empty($comments)): ?>
    <p>Aucun commentaire pour le moment. Soyez le premier !</p>
<?php else: ?>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <div class="comment-header">
                <strong><?= htmlspecialchars($comment['user_name']) ?></strong>
                <span><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></span>
            </div>
            <div><?= nl2br(htmlspecialchars($comment['content'])) ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isLoggedIn()): ?>
    <h3>Laisser un commentaire</h3>
    <form method="POST" class="comment-form">
        <textarea name="content" placeholder="Votre commentaire..." required></textarea>
        <button type="submit" class="btn-comment">Publier</button>
    </form>
<?php else: ?>
    <p style="margin: 20px 0;">
        <a href="login.php" style="color: #6366f1;">Connectez-vous</a> pour laisser un commentaire.
    </p>
<?php endif; ?>

</body>
</html>