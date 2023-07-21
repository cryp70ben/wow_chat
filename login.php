<?php
// Establish database connection (replace with your own credentials)
include 'db.php';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password match
    $query = "SELECT * FROM User WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        header('Location: index.php');
        exit();
    } else {
        echo "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
         body {
          font-family: Arial, sans-serif;
          background-color: #f2f2f2;
          margin: 0;
          padding: 0;
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 100vh;
      }

      .login-container {
          background-color: #fff;
          border-radius: 10px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          padding: 40px;
          width: 400px;
      }

      h1 {
          display: flex;
          align-items: center;
          font-size: 32px;
          color: #333;
      }

      h1::before {
          content: "";
          display: inline-block;
          width: 50px;
          height: 50px;
          background-image: url("logo_new.png");
          background-size: cover;
          margin-right: 10px;
          border-radius: 50%;
      }

      form {
          margin-top: 30px;
      }

      label {
          display: block;
          font-size: 16px;
          color: #333;
          margin-bottom: 5px;
      }

      input[type="text"],
      input[type="password"] {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
          font-size: 16px;
          margin-bottom: 20px;
      }

      button {
          background-color: #007bff;
          color: #fff;
          border: none;
          border-radius: 5px;
          padding: 10px 20px;
          font-size: 16px;
          cursor: pointer;
          transition: background-color 0.3s;
      }

      button:hover {
          background-color: #0056b3;
      }

      p {
          margin-top: 20px;
          font-size: 14px;
      }

      a {
          color: #007bff;
          text-decoration: none;
          transition: color 0.3s;
      }

      a:hover {
          color: #0056b3;
      }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>

        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br />
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
