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

    function typeText(element, text, callback) {
      let index = 0;
      function type() {
        if (index < text.length) {
          element.textContent += text.charAt(index);
          index++;
          setTimeout(type, 50);
        } else if (callback) {
          callback();
        }
      }
      type();
    }

    function renderScene(sceneDescription, choices) {
      const sceneDiv = document.getElementById('scene');
      const choicesDiv = document.getElementById('choices');

      sceneDiv.textContent = '';
      choicesDiv.innerHTML = '';

      typeText(sceneDiv, sceneDescription, () => {
        choices.forEach(choice => {
          const button = document.createElement('button');
          button.textContent = choice.choice;
          button.classList.add('fade-in');
          button.addEventListener('click', () => {
            renderScene(choice.outcome, choice.subChoices || []);
          });
          choicesDiv.appendChild(button);
        });

        if (choices.length === 0) {
          const restartButton = document.createElement('button');
          restartButton.textContent = 'Start Again';
          restartButton.classList.add('restart-button', 'fade-in');
          restartButton.addEventListener('click', () => {
            renderScene(startingScene, choicesData);
          });
          choicesDiv.appendChild(restartButton);
        }
      });
    }

    // Initialize the story
    renderScene(startingScene, choicesData);
  </script>
</body>

</html>