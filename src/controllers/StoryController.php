<?php

namespace App\Controllers;

use App\Models\Story;
class StoryController
{
  // Function to create a new story
  public function createStory()
  {
    if (!isset($_SESSION['username'])) {
      echo "You must be logged in to create a story.";
      return;
    }

    $storyData = json_decode(file_get_contents('php://input'), true);

    $storyModel = new Story();
    $title = $storyData['title'];
    $startingScene = $storyData['startingScene'];
    $choices = $storyData['choices'];
    $username = $_SESSION['username'];

    if ($storyModel->create($title, $startingScene, $choices, $username)) {
      echo "Story created successfully.";
      header("Location: /story/view");
    } else {
      echo "Failed to create story.";
    }
  }

  // Function to get a story by ID
  public function getStory($storyId)
  {
    $storyModel = new Story();
    $story = $storyModel->getById($storyId);
    return $story;
  }

  // Function to update a story by ID
  public function updateStory($storyId, $storyData)
  {
    if (!isset($_SESSION['username'])) {
      echo "You must be logged in to update a story.";
      return;
    }

    $storyModel = new Story();
    $story = $storyModel->getById($storyId);
    $username = $_SESSION['username'];

    if ($story['username'] !== $username) {
      echo "You do not have permission to update this story.";
      return;
    }

    $title = $storyData['title'];
    $startingScene = $storyData['starting_scene'];
    $choices = $storyData['choices'];

    if ($storyModel->update($storyId, $title, $startingScene, $choices, $username)) {
      echo "Story updated successfully.";
    } else {
      echo "Failed to update story.";
    }
  }

  // Function to delete a story by ID
  public function deleteStory($storyId)
  {
    if (!isset($_SESSION['username'])) {
      echo "You must be logged in to delete a story.";
      return;
    }

    $storyModel = new Story();
    $story = $storyModel->getById($storyId);
    $username = $_SESSION['username'];

    if ($story['username'] !== $username) {
      echo "You do not have permission to delete this story.";
      return;
    }

    if ($storyModel->delete($storyId)) {
      echo "Story deleted successfully.";
    } else {
      echo "Failed to delete story.";
    }
  }

  // Function to list all stories
  public function listStories()
  {
    $storyModel = new Story();
    $stories = $storyModel->getAll();
    return $stories;
  }
}