<?php
require_once '../config/init.php';
require_once '../vendor/autoload.php';

// Fetch the story ID from the URL
$storyId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($storyId <= 0) {
  header("Location: /story/view");
  exit;
}

use App\Controllers\StoryController;

$storyController = new StoryController();
$story = $storyController->getStory($storyId);

if (!$story) {
  header("Location: /story/view");
  exit;
}

$title = htmlspecialchars($story['title']);
$startingScene = htmlspecialchars($story['starting_scene']);
$choices = json_decode($story['choices'], true); // Decode JSON into PHP array

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Play Story: <?php echo $title; ?></title>
  <link rel="stylesheet" href="/css/play.css">
</head>

<body>
  <button onclick="window.location.href='/'" style="position: absolute;top:1%;left:1%;">Home</button>
  <div class="container">
    <h1><?php echo $title; ?></h1>
    <div id="game">
      <div class="scene" id="scene"></div>
      <div class="choices" id="choices"></div>
    </div>
  </div>

  <script>
    const startingScene = <?php echo json_encode($startingScene); ?>;
    const choicesData = <?php echo json_encode($choices); ?>;
  </script>
  <script src="/js/story/play.js"></script>
</body>

</html>