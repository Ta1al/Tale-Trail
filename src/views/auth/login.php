<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
</head>

<body>
  <h1>Login</h1>
  <form method="POST" action="/login">
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? Register <a href="/register">here</a>.</p>
</body>

</html>