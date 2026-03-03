<h2>Supprimer mon compte</h2>

<div style="background-color: #fdf2f2; border: 1px solid #f8d7da; padding: 20px; border-radius: 8px; color: #721c24;">
    <p><strong>Attention !</strong> Cette action est irréversible. Toutes vos données seront définitivement supprimées.</p>
    
    <form action="index.php?action=delete_profile" method="post" style="margin-top: 20px;">
        <button type="submit" name="confirm_delete" class="btn btn-danger">Oui, supprimer mon compte définitivement</button>
        <a href="index.php?action=profile" class="btn" style="background: #95a5a6; color: white;">Non, garder mon compte</a>
    </form>
</div>
