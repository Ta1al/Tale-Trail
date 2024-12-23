<?php

namespace App\Controllers;

use App\Models\Story;
class StoryController
{
  // Function to create a new story
  public function createStory($storyData)
  {
    session_start();
    if (!isset($_SESSION['username'])) {
      echo "You must be logged in to create a story.";
      return;
    }

    $storyModel = new Story();
    $title = $storyData['title'];
    $startingScene = $storyData['starting_scene'];
    $choices = $storyData['choices'];
    $username = $_SESSION['username'];

    if ($storyModel->create($title, $startingScene, $choices, $username)) {
      echo "Story created successfully.";
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
    // Logic to update the story data in the database
  }

  // Function to delete a story by ID
  public function deleteStory($storyId)
  {
    // Logic to delete the story data from the database
  }

  // Function to list all stories
  public function listStories()
  {
    $storyModel = new Story();
    $stories = $storyModel->getAll();
    return $stories;
  }
}