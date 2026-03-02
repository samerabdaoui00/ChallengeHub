<?php require '../views/layouts/header.php'; ?>

<h2>Create a Challenge</h2>

<?php if(isset($error)): ?>
    <div style="color:red; margin-bottom:15px;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?page=store_challenge">
    <label>Title</label><br>
    <input type="text" name="title" placeholder="Challenge title" required><br><br>

    <label>Description</label><br>
    <textarea name="description" placeholder="Challenge description" required></textarea><br><br>

    <label>Category</label><br>
    <input type="text" name="category" placeholder="Category" required><br><br>

    <button type="submit" style="background:#ff8fab;color:white;padding:10px 15px;border:none;border-radius:5px;cursor:pointer;">
        Create Challenge
    </button>
</form>

<?php require '../views/layouts/footer.php'; ?>