<?php
if (!isset($_SESSION['username'])) {
  echo "You must be logged in to view stories. <br>";
  echo "<a href='/login'>Login</a>";
  return;
}

require_once '../config/init.php';
require_once '../vendor/autoload.php';
use App\Controllers\StoryController;

$storyController = new StoryController();
$stories = $storyController->listStories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Stories</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f9f9f9;
    }

    h1 {
      color: #333;
      text-align: center;
    }

    .story {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 15px;
      background-color: #fff;
    }

    .story h2 {
      margin: 0;
      color: #007bff;
    }

    .story p {
      margin: 5px 0;
    }

    a {
      color: #007bff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <h1>Available Stories</h1>

  <?php if (count($stories) > 0): ?>
    <?php foreach ($stories as $story): ?>
      <div class="story">
        <h2><?= htmlspecialchars($story['title']); ?></h2>
        <p><strong>Starting Scene:</strong> <?= htmlspecialchars($story['starting_scene']); ?></p>
        <p><a href="/stories/<?= $story['id']; ?>">View Story</a></p>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No stories available. <a href="/create">Create a new story</a>.</p>
  <?php endif; ?>
</body>

</html>