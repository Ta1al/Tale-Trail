<?php
if (!isset($_SESSION['username'])) {
  echo "You must be logged in to create a story. <br>";
  echo "<a href='/login'>Login</a>";
  return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Story Tree Creator</title>
  <link rel="stylesheet" href="/css/create.css">
</head>

<body>
  <h1>Story Tree Creator</h1>

  <form id="storyForm">
    <div>
      <label for="storyTitle">Story Title:</label>
      <input type="text" id="storyTitle" name="title" required>
    </div>

    <div>
      <h2>Starting Scene</h2>
      <label for="startingScene">Scene Description:</label>
      <textarea id="startingScene" name="starting_scene" rows="4" required></textarea>
      <button type="button" id="addChoiceButton">Add Choice</button>
    </div>

    <div id="choicesContainer">
    </div>
    <br>
    <button type="submit">Create Story</button>
  </form>

  <div id="preview"></div>

  <script src="/js/story/create.js"></script>
</body>

</html>