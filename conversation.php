<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

// Fetch conversation ID from the URL parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}
$conversation_id = $_GET['id'];

// Fetch conversation details and messages
$conversationQuery = "SELECT c.conversation_id, u.username FROM Conversation AS c
                      INNER JOIN User_Conversation AS uc ON c.conversation_id = uc.conversation_id
                      INNER JOIN User AS u ON uc.user_id = u.user_id
                      WHERE uc.user_id = :user_id AND c.conversation_id = :conversation_id";
$conversationStmt = $pdo->prepare($conversationQuery);
$conversationStmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$conversationStmt->bindValue(':conversation_id', $conversation_id, PDO::PARAM_INT);
$conversationStmt->execute();
$conversation = $conversationStmt->fetch();

$messagesQuery = "SELECT m.message_id, m.message, m.created_at, u.username FROM Message AS m
                  INNER JOIN User AS u ON m.user_id = u.user_id
                  WHERE m.conversation_id = :conversation_id
                  ORDER BY m.created_at ASC";
$messagesStmt = $pdo->prepare($messagesQuery);
$messagesStmt->bindValue(':conversation_id', $conversation_id, PDO::PARAM_INT);
$messagesStmt->execute();
$messages = $messagesStmt->fetchAll();

// Handle form submission for sending messages
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];

    // Insert new message into the Message table
    $insertQuery = "INSERT INTO Message (conversation_id, user_id, message) VALUES (:conversation_id, :user_id, :message)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindValue(':conversation_id', $conversation_id, PDO::PARAM_INT);
    $insertStmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $insertStmt->bindValue(':message', $message, PDO::PARAM_STR);
    $insertStmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Conversation</title>
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>
<body>
    <h1>Conversation</h1>

    <?php if ($conversation) : ?>
        <h2><?php echo $conversation['username']; ?></h2>

        <ul>
            <?php foreach ($messages as $message) : ?>
                <li>
                    <strong><?php echo $message['username']; ?>:</strong>
                    <?php echo $message['message']; ?>
                    <span>(<?php echo $message['created_at']; ?>)</span>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>New Message</h2>
        <form method="POST" action="">
            <input type="hidden" name="conversation_id" value="<?php echo $conversation_id; ?>">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Send</button>
        </form>
    <?php else : ?>
        <p>Invalid conversation.</p>
    <?php endif; ?>

    <a href="index.php">Back to Conversations</a>

    <!-- Add your additional HTML or functionality here -->

    <!-- Add your JavaScript code if needed -->
</body>
</html>



