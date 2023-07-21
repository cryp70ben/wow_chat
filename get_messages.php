<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

// Retrieve conversation ID from the query string
if (isset($_GET['conversation_id'])) {
    $conversation_id = $_GET['conversation_id'];

    // Fetch messages for the given conversation ID
    $messagesQuery = "SELECT m.message, u.username FROM Message AS m
                      INNER JOIN User AS u ON m.user_id = u.user_id
                      WHERE m.conversation_id = :conversation_id";
    $messagesStmt = $pdo->prepare($messagesQuery);
    $messagesStmt->bindValue(':conversation_id', $conversation_id, PDO::PARAM_INT);
    $messagesStmt->execute();
    $messages = $messagesStmt->fetchAll();

    // Display the messages
    if (!empty($messages)) {
        foreach ($messages as $message) {
            echo "<div class='message'>";
            echo "<strong>" . $message['username'] . ":</strong> " . $message['message'];
            echo "</div>";
        }
    } else {
        echo "<p>No messages found for this conversation.</p>";
    }
} else {
    echo "<p>Invalid conversation ID.</p>";
}
?>

