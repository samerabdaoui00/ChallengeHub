<h2>Connexion</h2>

<form action="index.php?action=login" method="post">
    <div style="margin-bottom: 15px;">
        <label>Email :</label><br>
        <input type="email" name="email" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>Mot de passe :</label><br>
        <input type="password" name="password" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>

<p style="margin-top: 20px;">
    Pas encore de compte ? <a href="index.php?action=register">S'inscrire</a>
</p>