function typeText(element, text, callback) {
  let index = 0;
  text = text.replace(/(&#039;)/g, "'");
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
