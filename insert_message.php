<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

// Fetch the logged-in user ID
$user_id = $_SESSION['user_id'];

// Handle form submission for sending messages
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];

    // Insert new message into the Message table
    $insertQuery = "INSERT INTO Message (user_id, message) VALUES (:user_id, :message)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $insertStmt->bindValue(':message', $message, PDO::PARAM_STR);
    $insertStmt->execute();

    // Return a success response
    echo 'success';
} else {
    // Return an error response
    echo 'error';
}

