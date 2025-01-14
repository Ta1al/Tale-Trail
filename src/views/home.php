<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Tale Trail</title>
  <link rel="stylesheet" href="/css/home.css">
</head>

<body>
  <div class="container">
    <h1>Welcome to Tale Trail</h1>
    <p>Your adventure starts here.</p>
    <div class="links">
      <?php
      // if the user is logged in, display a welcome message and relevant links
      if (isset($_SESSION['username'])) {
        echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';
        echo '<a href="/story/view" class="button">View Stories</a>';
        echo '<a href="/story/create" class="button">Create Story</a>';
        echo '<a href="/logout" class="button">Logout</a>';
      } else {
        echo '<a href="/login" class="button">Login</a>';
        echo '<a href="/register" class="button">Register</a>';
      }
      ?>
    </div>
  </div>
</body>

</html>