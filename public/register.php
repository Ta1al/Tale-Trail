<?php
require_once '../config/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $password_confirm = password_hash($_POST['password_confirm'], PASSWORD_BCRYPT);

  if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
    echo "Please fill in all fields.";
    exit;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
  }

  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  if ($stmt->rowCount() > 0) {
    echo "Username already taken.";
    exit;
  }

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  if ($stmt->rowCount() > 0) {
    echo "This email is already registered. Click <a href='login.php'>here</a> to login.";
    exit;
  }

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
  <script src="./js/validation.js"></script>
</body>

</html>