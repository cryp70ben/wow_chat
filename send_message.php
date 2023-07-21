<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $message = $_POST['message'];

    $timestamp = date('Y-m-d H:i:s'); // Current timestamp

    $insertQuery = "INSERT INTO Message (user_id, message, timestamp) VALUES (:user_id, :message, :timestamp)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $insertStmt->bindValue(':message', $message, PDO::PARAM_STR);
    $insertStmt->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
    $insertStmt->execute();
}
?>

