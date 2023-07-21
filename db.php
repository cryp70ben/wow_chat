<?php
// Set the default timezone to Australia/Sydney
date_default_timezone_set('Australia/NSW');

$host = 'localhost';
$db = 'new_8';
$user = 'root';
$password = '';

// Create a PDO instance and connect to the database
try {
    // Set the character encoding to utf8mb4
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4', // Set the character encoding to utf8mb4
    ];

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password, $options);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
    // Set the character encoding to utf8mb4 for smileys
    $pdo->exec('SET NAMES utf8mb4');
?>