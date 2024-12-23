<?php

namespace App\Models;

use PDO;

class Story
{
  private $db;

  public function __construct()
  {
    $this->db = \Database::getInstance(); // Using singleton
  }

  public function create($title, $startingScene, $choices, $username)
  {
    $stmt = $this->db->prepare("INSERT INTO stories (title, starting_scene, choices, username) VALUES (:title, :starting_scene, :choices, :username)");
    return $stmt->execute([
      ':title' => $title,
      ':starting_scene' => $startingScene,
      ':choices' => json_encode($choices),
      ':username' => $username,
    ]);
  }

  public function getById($storyId)
  {
    $stmt = $this->db->prepare("SELECT * FROM stories WHERE id = :id");
    $stmt->execute([':id' => $storyId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function update($storyId, $title, $startingScene, $choices, $username)
  {
    $stmt = $this->db->prepare("UPDATE stories SET title = :title, starting_scene = :starting_scene, choices = :choices, username = :username WHERE id = :id");
    return $stmt->execute([
      ':id' => $storyId,
      ':title' => $title,
      ':starting_scene' => $startingScene,
      ':choices' => json_encode($choices),
      ':username' => $username,
    ]);
  }

  public function delete($storyId)
  {
    $stmt = $this->db->prepare("DELETE FROM stories WHERE id = :id");
    return $stmt->execute([':id' => $storyId]);
  }

  public function getAll()
  {
    $stmt = $this->db->query("SELECT * FROM stories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>