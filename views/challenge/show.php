<h2>Submissions</h2>

<div class="grid">

<?php foreach($submissions as $s): ?>

<div class="card">

<img src="<?= $s['image'] ?>" width="200">

<p><?= $s['description'] ?></p>

<p>Votes : <?= $s['votes'] ?></p>

<a class="btn" href="?page=vote&submission=<?= $s['id'] ?>">
Vote ❤️
</a>

</div>

<?php endforeach ?>

</div>