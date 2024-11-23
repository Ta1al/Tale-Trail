<?php
require_once '../config/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
</head>

<body>
  <h1>Login</h1>
  <form method="POST" action="/login">
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
  </form>
</body>

</html>