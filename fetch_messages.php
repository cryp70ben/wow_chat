<?php
include 'db.php';

// Retrieve messages from the database
$messagesQuery = "SELECT * FROM Message";
$messagesStmt = $pdo->query($messagesQuery);
$messages = $messagesStmt->fetchAll(PDO::FETCH_ASSOC);

// Return the messages as JSON
echo json_encode($messages);
?>
