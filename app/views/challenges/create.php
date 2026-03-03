<h2>Créer un challenge</h2>

<form action="index.php?action=store_challenge" method="post">
    <div style="margin-bottom: 15px;">
        <label>Titre :</label><br>
        <input type="text" name="title" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>Description :</label><br>
        <textarea name="description" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; height: 100px;"></textarea>
    </div>
    <div style="margin-bottom: 15px;">
        <label>Catégorie :</label><br>
        <input type="text" name="category" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <button type="submit" class="btn btn-primary">Créer le challenge</button>
    <a href="index.php?action=challenges" class="btn" style="background: #95a5a6; color: white;">Annuler</a>
</form>