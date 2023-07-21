<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT u.username, m.message, m.timestamp FROM Message AS m
              INNER JOIN User AS u ON m.user_id = u.user_id
              ORDER BY m.timestamp ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the response as JSON
    header('Content-Type: application/json');
    echo json_encode($messages);
}
?>

