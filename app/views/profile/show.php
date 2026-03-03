<?php
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>
<h2>Bienvenue, <?php echo htmlspecialchars($user_name); ?> !</h2>
<div style="margin-top: 20px;">
    <p><strong>Email :</strong> <?php echo htmlspecialchars($user_email); ?></p>
    
    <div style="margin-top: 30px;">
        <a href="index.php?action=edit_profile" class="btn btn-primary">Modifier mon profil</a>
        <a href="index.php?action=delete_profile" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')">Supprimer mon compte</a>
    </div>
</div>
