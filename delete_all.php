<?php
include 'db.php';

// Construct the delete query
$query = "DELETE FROM Message";

// Use prepared statement to avoid SQL injection
$stmt = $pdo->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Deletion successful
    echo "All messages deleted successfully.";
    echo "<audio id='sound' src='sound.mp3' autoplay></audio>";
} else {
    // Error occurred during deletion
    echo "Failed to delete all messages.";
}

// Redirect back to the index page
header("Location: /wow_chat/");
exit(); // Make sure to exit after the redirect
?>
