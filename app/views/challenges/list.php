<h2>Mes défis</h2>
<div style="margin-bottom: 20px;">
    <a href="index.php?action=create_challenge" class="btn btn-primary">+ Créer un challenge</a>
</div>

<?php if (empty($challenges)): ?>
    <p>Aucun challenge trouvé.</p>
<?php else: ?>
    <?php foreach ($challenges as $challenge): ?>
        <div style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
            <h3><?php echo htmlspecialchars($challenge['title']); ?></h3>
            <p><?php echo htmlspecialchars($challenge['description']); ?></p>
            <span style="background: #eee; padding: 3px 8px; border-radius: 4px; font-size: 0.9em;">
                <?php echo htmlspecialchars($challenge['category'] ?? 'Général'); ?>
            </span>
        </div>
    <?php endforeach; ?>
<?php endif; ?>