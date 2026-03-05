<?php


require_once 'db.php';  

function addComment($submission_id, $user_id, $content) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO comments (submission_id, user_id, content)
        VALUES (?, ?, ?)
    ");
    return $stmt->execute([$submission_id, $user_id, $content]);
}

function getCommentsBySubmission($submission_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            c.id, c.content, c.created_at,
            u.name AS user_name
        FROM comments c
        JOIN users u ON c.user_id = u.id
        WHERE c.submission_id = ?
        ORDER BY c.created_at ASC
    ");
    $stmt->execute([$submission_id]);
    return $stmt->fetchAll();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}