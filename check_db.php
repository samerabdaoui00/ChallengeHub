<?php
require_once(__DIR__ . "/config/configuration.php");
$conn = connect_bd();
if ($conn) {
    echo "Connection Successful\n";
    $stmt = $conn->query("SELECT id, name, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Users found: " . count($users) . "\n";
    print_r($users);
} else {
    echo "Connection Failed\n";
}
?>
