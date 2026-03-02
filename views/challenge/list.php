<h2>All Challenges</h2>

<a href="/challengehub/public/index.php?url=challenge/create" class="btn">
Create New Challenge
</a>

<?php foreach($challenges as $challenge): ?>

<div class="card">

<h3><?php echo $challenge['title']; ?></h3>

<p><?php echo $challenge['description']; ?></p>

<p>Votes: <?php echo $challenge['votes']; ?></p>

<form method="POST" action="/challengehub/public/index.php?url=challenge/vote">
    <input type="hidden" name="challenge_id" value="<?= $challenge['id'] ?>">
    <button class="vote-btn">🌸 Vote</button>
</form>

</div>
<a href="/challengehub/public/index.php?url=challenge/edit&id=<?= $challenge['id'] ?>" class="btn">✏️ Edit</a>

<!-- Delete button -->
<form method="POST" action="/challengehub/public/index.php?url=challenge/destroy" style="display:inline-block;">
    <input type="hidden" name="id" value="<?= $challenge['id'] ?>">
    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">🗑 Delete</button>
</form>

</div>

<?php endforeach; ?>
