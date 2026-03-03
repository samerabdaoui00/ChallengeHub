<h2>Edit Challenge</h2>

<form method="POST" action="/challengehub/public/index.php?url=challenge/update">
    <input type="hidden" name="id" value="<?= $challenge['id'] ?>">

    <input type="text" name="title" value="<?= htmlspecialchars($challenge['title']) ?>" required>
    
    <textarea name="description" required><?= htmlspecialchars($challenge['description']) ?></textarea>

    <button type="submit" class="btn">Update Challenge</button>
</form>