document.getElementById('addChoiceButton').addEventListener('click', function () {
  const choiceDiv = document.createElement('div');
  choiceDiv.classList.add('choice', 'fade-in');
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
    subChoiceDiv.classList.add('sub-choice', 'fade-in');
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
      subChoicesContainer.style.animation = 'fadeIn 0.5s ease-in-out';
      e.target.textContent = 'Fold';
    } else {
      const subChoiceCount = subChoicesContainer.querySelectorAll(':scope > .sub-choice').length;
      subChoicesContainer.style.animation = 'fadeOut 0.5s ease-in-out';
      subChoicesContainer.addEventListener('animationend', () => {
        subChoicesContainer.style.display = 'none';
        e.target.textContent = `Unfold (${subChoiceCount} sub-branches)`;
      }, { once: true });
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