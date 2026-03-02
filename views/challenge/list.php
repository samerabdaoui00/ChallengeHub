<h2>Challenges</h2>

<?php
if(isset($challenges) && !empty($challenges)){
    
    foreach($challenges as $challenge){
?>

<div style="border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius:8px;">

    <h3>
        <?php echo htmlspecialchars($challenge['title'] ?? 'Untitled Challenge'); ?>
    </h3>

    <p>
        <?php echo htmlspecialchars($challenge['description'] ?? 'No description'); ?>
    </p>

    <br>

    <!-- Button to submit work -->
    <a href="index.php?page=submissions&challenge_id=<?php echo $challenge['id']; ?>"
       style="background:#ff8fab;color:white;padding:10px 14px;border-radius:6px;text-decoration:none;margin-right:10px;">
       Submit your work
    </a>

</div>

<?php
    }

}else{
    echo "<p>No challenges available.</p>";
}
?>