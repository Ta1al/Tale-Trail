<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="/css/login.css">
</head>

<body>
  <div class="container">
    <h1>Login</h1>
    <form method="POST" action="/login">
      <label>Username:</label>
      <input type="text" name="username" required><br>
      <label>Password:</label>
      <input type="password" name="password" required><br>
      <button type="submit" class="button">Login</button>
    </form>
    <p>Don't have an account? Register <a href="/register">here</a>.</p>
  </div>
</body>

</html>