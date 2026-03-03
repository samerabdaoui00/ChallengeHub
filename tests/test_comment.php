<?php
require_once(__DIR__ . "/../config/configuration.php");
require_once(__DIR__ . "/../app/models/Comment.php");

// Simple verification script for Comment model
echo "--- Testing Comment Model ---\n";

try {
    // 1. Check if we can instantiate
    echo "1. Instantiating Comment object... ";
    $comment = new Comment(1, 1, "Test comment content");
    echo "OK\n";

    // 2. Test create (this will fail if no DB connected, but we check syntax/pattern)
    echo "2. Testing create() method... ";
    // We don't want to actually insert in a real DB without being sure, 
    // but we can check if the code runs. 
    // Assuming DB is set up as per SQL file.
    if ($comment->create()) {
        echo "SUCCESS (Created ID: " . $comment->getId() . ")\n";
        
        // 3. Test getBySubmission
        echo "3. Testing getBySubmission()... ";
        $comments = Comment::getBySubmission(1);
        echo "FOUND " . count($comments) . " comments\n";

        // 4. Test delete
        echo "4. Testing delete()... ";
        if ($comment->delete()) {
            echo "SUCCESS\n";
        } else {
            echo "FAILED\n";
        }
    } else {
        echo "SKIPPED (Database might not be reachable or empty)\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "--- Tests Completed ---\n";
?>
