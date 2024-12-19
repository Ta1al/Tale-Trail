<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>

<body>
  Hello World.
  <?php
  // if the user is logged in, display a welcome message
  if (isset($_SESSION['username'])) {
    echo 'Welcome, ' . $_SESSION['username'];
    echo '<br><a href="/logout">Logout</a>';
  } else {
    echo 'Login by clicking <a href="/login">here</a>';
  }
  ?>
</body>

</html>