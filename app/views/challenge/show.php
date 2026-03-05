<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= e($challenge->getTitle()) ?> - ChallengeHub</title>
    <style>
        .container { max-width: 900px; margin: 20px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .meta { color: 
        .badge { background: 
        .participation-item { border: 1px solid 
        .vote-section { margin-bottom: 15px; display: flex; align-items: center; gap: 15px; }
        .vote-count { font-weight: bold; font-size: 1.2em; color: 
        .vote-btn { padding: 5px 12px; border-radius: 20px; text-decoration: none; font-size: 0.9em; }
        .vote-btn.active { background: 
        .vote-btn.inactive { border: 1px solid 
        .comment-section { margin-top: 15px; border-top: 1px solid 
        .comment { font-size: 0.9em; margin-bottom: 8px; background: white; padding: 8px; border-radius: 4px; border-left: 3px solid 
        .comment-meta { font-size: 0.8em; color: 
        textarea { width: 100%; padding: 8px; border: 1px solid 
        .btn-sm { padding: 4px 10px; font-size: 0.8em; cursor: pointer; border-radius: 4px; border: none; }
        .btn-primary { background: 
    </style>
</head>
<body style="background: 
    <nav style="padding: 15px; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <a href="index.php?action=list_challenges">← Retour</a> | 
        <a href="index.php?action=submit_participation&challenge_id=<?= $challenge->getId() ?>" style="font-weight: bold; color: green; text-decoration: none;">+ Participer</a>
    </nav>
    <div class="container">
        <span class="badge"><?= e($challenge->getCategory()) ?></span>
        <h1 style="margin-top: 10px;"><?= e($challenge->getTitle()) ?></h1>
        <div class="meta">
            Par l'utilisateur ID: <?= $challenge->getUserId() ?> | 
            <span style="color: 
        </div>
        <?php if ($challenge->getImage()): ?>
            <img src="<?= e($challenge->getImage()) ?>" style="width: 100%; max-height: 350px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
        <?php endif; ?>
        <h3>Description</h3>
        <p style="line-height: 1.6; color: 
        <hr style="margin: 40px 0; border: 0; border-top: 2px solid 
        <h2>Contributions (<?= count($participations) ?>)</h2>
        <?php if (empty($participations)): ?>
            <p style="color: 
        <?php else: ?>
            <?php foreach ($participations as $p): ?>
                <div class="participation-item">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                        <div>
                            <strong>Utilisateur ID: <?= $p->getUserId() ?></strong>
                            <div class="comment-meta"><?= $p->getCreatedAt() ?></div>
                        </div>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $p->getUserId()): ?>
                            <div>
                                <a href="index.php?action=edit_participation&id=<?= $p->getId() ?>" style="color: 
                                <a href="index.php?action=delete_participation&id=<?= $p->getId() ?>" onclick="return confirm('Supprimer ?')" style="color: 
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($p->getImage()): ?>
                        <img src="<?= e($p->getImage()) ?>" style="width: 100%; max-height: 300px; object-fit: contain; background: 
                    <?php endif; ?>
                    <p style="margin-bottom: 15px; white-space: pre-wrap;"><?= e($p->getDescription()) ?></p>
                    <?php 
                        require_once(__DIR__ . "/../../models/Vote.php");
                        $voteCount = Vote::countBySubmission($p->getId());
                        $hasVoted = isset($_SESSION['user_id']) ? Vote::hasVoted($p->getId(), $_SESSION['user_id']) : false;
                    ?>
                    <div class="vote-section">
                        <span class="vote-count">★ <?= $voteCount ?></span>
                        <a href="index.php?action=vote_submission&submission_id=<?= $p->getId() ?>" class="vote-btn <?= $hasVoted ? 'active' : 'inactive' ?>">
                            <?= $hasVoted ? 'Retirer mon vote' : 'Voter' ?>
                        </a>
                    </div>
                    <div class="comment-section">
                        <?php 
                            require_once(__DIR__ . "/../../models/Comment.php");
                            $comments = Comment::getBySubmission($p->getId());
                        ?>
                        <h4 style="margin: 0 0 10px 0;">Commentaires (<?= count($comments) ?>)</h4>
                        <?php foreach ($comments as $com): ?>
                            <div class="comment">
                                <div style="display: flex; justify-content: space-between;">
                                    <span><strong>ID <?= $com->getUserId() ?></strong>: <?= e($com->getContent()) ?></span>
                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $com->getUserId()): ?>
                                        <a href="index.php?action=delete_comment&id=<?= $com->getId() ?>" style="color: red; font-size: 0.7em; text-decoration: none;">Supprimer</a>
                                    <?php endif; ?>
                                </div>
                                <div class="comment-meta"><?= $com->getCreatedAt() ?></div>
                            </div>
                        <?php endforeach; ?>
                        <form action="index.php?action=add_comment" method="post" style="margin-top: 10px;">
                            <input type="hidden" name="submission_id" value="<?= $p->getId() ?>">
                            <input type="hidden" name="challenge_id" value="<?= $challenge->getId() ?>">
                            <textarea name="content" placeholder="Ajouter un commentaire..." rows="2" required></textarea>
                            <button type="submit" class="btn-sm btn-primary">Publier</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $challenge->getUserId()): ?>
            <div style="margin-top: 40px; background: 
                <strong>Options créateur:</strong> 
                <a href="index.php?action=edit_challenge&id=<?= $challenge->getId() ?>" style="color: 
                <a href="index.php?action=delete_challenge&id=<?= $challenge->getId() ?>" onclick="return confirm('Supprimer le challenge ?')" style="color: 
            </div>
        <?php endif; ?>
    </div>
</body>
</html>