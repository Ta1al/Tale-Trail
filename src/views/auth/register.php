<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="/css/register.css">
</head>

<body>
  <div class="container">
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
      <button type="submit" class="button">Register</button>
    </form>
    <p>Already have an account? <a href="/login">Login</a></p>
    <script src="./js/validation.js"></script>
  </div>
</body>

</html>