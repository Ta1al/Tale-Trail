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
  <link rel="stylesheet" href="/css/view.css">
</head>

<body>
  <h1>Available Stories</h1>
  <div class="story-container">
    <?php foreach ($stories as $story): ?>
      <div class="story" onclick="window.location.href='/story/play?id=<?= $story['id']; ?>'">
        <h2><?= htmlspecialchars($story['title']); ?></h2>
        <p><strong>Starting Scene:</strong> <?= htmlspecialchars(substr($story['starting_scene'], 0, 100)); ?>...</p>
      </div>
    <?php endforeach; ?>

    <?php if (isset($_SESSION['username'])): ?>
      <div class="create-story" onclick="window.location.href='/story/create'">
        +
      </div>
    <?php endif; ?>
  </div>
</body>

</html>