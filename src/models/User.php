<?php

namespace App\Models;

use PDO;

class User
{
  private $db;

  public function __construct()
  {
    $this->db = \Database::getInstance(); // Using singleton
  }

  public function create($username, $email, $password)
  {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    return $stmt->execute([
      ':username' => $username,
      ':email' => $email,
      ':password' => $hashedPassword,
    ]);
  }

  public function authenticate($username, $password)
  {
    $stmt = $this->db->prepare("SELECT password FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user && password_verify($password, $user['password']);
  }
}
