<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
</head>

<body>
  <h1>Register</h1>
  <form method="POST" action="/register">
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