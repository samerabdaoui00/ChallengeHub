<h2>Submissions</h2>

<?php foreach($submissions as $sub): ?>
<div class="card">
    <h3><?= htmlspecialchars($sub['user_name']) ?></h3>
    <p><?= htmlspecialchars($sub['work_description']) ?></p>
    <?php if(!empty($sub['work_file'])): ?>
        <img src="<?= htmlspecialchars($sub['work_file']) ?>" style="max-width:200px;">
    <?php endif; ?>
    <p>Votes: <?= $sub['votes'] ?></p>

    <form method="POST" action="/challengehub/public/index.php?url=submission/vote">
        <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
        <input type="hidden" name="challenge_id" value="<?= $challenge_id ?>">
        <button class="vote-btn">🌸 Vote</button>
    </form>
</div>
<?php endforeach; ?>