<?php
include 'db.php';

if (isset($_GET['message_id'])) {
    $messageId = $_GET['message_id'];

    // Use prepared statement to avoid SQL injection
    $query = "DELETE FROM Message WHERE message_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$messageId]);

    if ($stmt->rowCount() > 0) {
        // Deletion successful
        echo "Message deleted successfully.";
    } else {
        // Error occurred during deletion
        echo "Failed to delete the message.";
    }
} else {
    // No message ID provided in the URL
    echo "Invalid request.";
}

// Redirect back to the index page
header("Location: index.php");
exit(); // Make sure to exit after the redirect
?>