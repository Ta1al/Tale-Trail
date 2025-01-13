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
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f9f9f9;
    }

    h1,
    h2,
    h3,
    h4 {
      color: #333;
    }

    label {
      font-weight: bold;
    }

    .choice,
    .sub-choice {
      margin-left: 20px;
      margin-top: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      position: relative;
      animation: fadeIn 0.5s ease-in-out;
    }

    .sub-choice {
      margin-left: 40px;
    }

    .choice::before,
    .sub-choice::before {
      content: '';
      position: absolute;
      left: -20px;
      top: 20px;
      width: 20px;
      height: 2px;
      background-color: #ccc;
    }

    .sub-choice::before {
      left: -40px;
    }

    button {
      margin-top: 10px;
      padding: 5px 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #0056b3;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes fadeOut {
      from {
        opacity: 1;
      }

      to {
        opacity: 0;
      }
    }
  </style>
</head>

<body>
  <h1>Story Tree Creator</h1>

  <form id="storyForm">
    <div>
      <label for="storyTitle">Story Title:</label><br>
      <input type="text" id="storyTitle" name="title" required><br>
    </div>

    <div>
      <h2>Starting Scene</h2>
      <label for="startingScene">Scene Description:</label><br>
      <textarea id="startingScene" name="starting_scene" rows="4" cols="50" required></textarea>
      <button type="button" id="addChoiceButton">Add Choice</button>
    </div>

    <div id="choicesContainer">
    </div>
    <br>
    <button type="submit">Create Story</button>
  </form>

  <div id="preview"></div>

  <script>
    document.getElementById('addChoiceButton').addEventListener('click', function () {
      const choiceDiv = document.createElement('div');
      choiceDiv.classList.add('choice');
      choiceDiv.innerHTML = `
        <label>Choice Description:</label><br>
        <input type="text" required><br>
        <label>Outcome:</label><br>
        <textarea rows="4" cols="50" required></textarea>
        <button type="button" class="addSubChoiceButton">Add Sub-Choice</button>
        <button type="button" class="removeChoiceButton">Remove Choice</button>
        <div class="subChoicesContainer"></div>
      `;
      document.getElementById('choicesContainer').appendChild(choiceDiv);
    });

    document.getElementById('choicesContainer').addEventListener('click', function (e) {
      if (e.target.classList.contains('addSubChoiceButton')) {
        const parentChoice = e.target.closest('.choice, .sub-choice');
        const subChoicesContainer = parentChoice.querySelector('.subChoicesContainer');
        const subChoiceDiv = document.createElement('div');
        subChoiceDiv.classList.add('sub-choice');
        subChoiceDiv.innerHTML = `
          <label>Sub-Choice Description:</label><br>
          <input type="text" required><br>
          <label>Outcome:</label><br>
          <textarea rows="4" cols="50" required></textarea>
          <button type="button" class="addSubChoiceButton">Add Sub-Choice</button>
          <button type="button" class="removeChoiceButton">Remove Choice</button>
          <div class="subChoicesContainer"></div>
        `;
        subChoicesContainer.appendChild(subChoiceDiv);
        updateFoldButton(parentChoice);
      } else if (e.target.classList.contains('removeChoiceButton')) {
        const choiceToRemove = e.target.closest('.choice, .sub-choice');
        const parentChoice = choiceToRemove.closest('.choice, .sub-choice');
        choiceToRemove.style.animation = 'fadeOut 0.5s ease-in-out';
        choiceToRemove.addEventListener('animationend', () => {
          choiceToRemove.remove();
          if (parentChoice) {
            updateFoldButton(parentChoice);
          }
        });
      } else if (e.target.classList.contains('foldChoiceButton')) {
        const parentChoice = e.target.closest('.choice, .sub-choice');
        const subChoicesContainer = parentChoice.querySelector('.subChoicesContainer');
        if (subChoicesContainer.style.display === 'none') {
          subChoicesContainer.style.display = 'block';
          e.target.textContent = 'Fold';
        } else {
          const subChoiceCount = subChoicesContainer.querySelectorAll(':scope > .sub-choice').length;
          subChoicesContainer.style.display = 'none';
          e.target.textContent = `Unfold (${subChoiceCount} sub-branches)`;
        }
      }
    });

    function updateFoldButton(choiceDiv) {
      const subChoicesContainer = choiceDiv.querySelector('.subChoicesContainer');
      const foldButton = choiceDiv.querySelector('.foldChoiceButton');
      const subChoiceCount = subChoicesContainer.querySelectorAll(':scope > .sub-choice').length;
      if (subChoiceCount > 0) {
        if (!foldButton) {
          const newFoldButton = document.createElement('button');
          newFoldButton.type = 'button';
          newFoldButton.classList.add('foldChoiceButton');
          newFoldButton.textContent = 'Fold';
          choiceDiv.insertBefore(newFoldButton, choiceDiv.firstChild);
        }
      } else if (foldButton) {
        foldButton.remove();
      }
    }

    document.getElementById('storyForm').addEventListener('submit', function (e) {
      e.preventDefault(); // Prevent the default form submission

      const story = {
        title: document.getElementById('storyTitle').value,
        startingScene: document.getElementById('startingScene').value,
        choices: collectChoices(document.getElementById('choicesContainer'))
      };

      function collectChoices(container) {
        const choices = [];
        const choiceDivs = container.querySelectorAll(':scope > .choice, :scope > .sub-choice');
        choiceDivs.forEach((choiceDiv) => {
          const choice = choiceDiv.querySelector('input').value;
          const outcome = choiceDiv.querySelector('textarea').value;
          const subChoices = collectChoices(choiceDiv.querySelector('.subChoicesContainer'));
          choices.push({ choice, outcome, subChoices });
        });
        return choices;
      }

      // Create preview
      const preview = document.getElementById('preview');
      preview.innerHTML = `
        <h2>${story.title}</h2>
        <p><strong>Starting Scene:</strong> ${story.startingScene}</p>
        <h3>Choices:</h3>
        ${renderChoices(story.choices)}
      `;

      function renderChoices(choices) {
        return `
          <ul>
            ${choices.map(c => `
              <li>
                <strong>Choice:</strong> ${c.choice}<br>
                <strong>Outcome:</strong> ${c.outcome}
                ${c.subChoices.length > 0 ? renderChoices(c.subChoices) : ''}
              </li>
            `).join('')}
          </ul>
        `;
      }

      // Send the story data to the server
      fetch('/story/create', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(story)
      })
        .then(response => response.text())
        .then(data => {
          console.log('Server response:', data);
          document.body.innerHTML = `<div>${data}</div>`; // Display server response on the whole page
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  </script>
</body>

</html>