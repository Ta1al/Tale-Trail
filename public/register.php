<?php
require_once '../config/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
  if ($stmt->execute([$username, $email, $password])) {
    echo "Registration successful!";
    header("Location: login.php");
    exit;
  } else {
    echo "Error: Could not register user.";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
</head>

<body>
  <h1>Register</h1>
  <form method="POST" action="">
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <label>Confirm Password:</label>
    <input type="password" name="password_confirm" required><br>
    <button type="submit">Register</button>
  </form>
</body>

</html>