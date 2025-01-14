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
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h1 {
      color: #333;
    }

    .scene {
      margin-bottom: 20px;
    }

    .choices {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-items: center;
    }

    button {
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #0056b3;
    }

    .restart-button {
      background-color: #dc3545;
    }

    .restart-button:hover {
      background-color: #c82333;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .fade-in {
      animation: fadeIn 1s ease-in-out;
    }
  </style>
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