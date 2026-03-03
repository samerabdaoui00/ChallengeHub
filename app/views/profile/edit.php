<h2>Modifier mon profil</h2>

<form action="index.php?action=update_profile" method="post">
    <div style="margin-bottom: 15px;">
        <label>Nom :</label><br>
        <input type="text" name="name" value="<?php echo e($user['name']); ?>" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>Email :</label><br>
        <input type="email" name="email" value="<?php echo e($user['email']); ?>" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>Nouveau mot de passe (laisser vide pour ne pas changer) :</label><br>
        <input type="password" name="password" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <hr>
    <div style="margin-bottom: 15px;">
        <label>Confirmez avec votre mot de passe actuel :</label><br>
        <input type="password" name="current_password" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <button type="submit" class="btn btn-primary" name="update">Sauvegarder les modifications</button>
    <a href="index.php?action=profile" class="btn" style="background: #95a5a6; color: white;">Annuler</a>
</form>
