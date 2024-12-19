<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
  private $db;

  public function __construct()
  {
    $this->db = \Database::getInstance(); // Using singleton
  }

  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_SESSION['username'])) {
        header('Location: /');
        // TODO: Tell the user they are already logged in
        exit;
      }
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $password_confirm = $_POST['password_confirm'];

      if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        echo "Please fill in all fields.";
        exit;
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
      }

      if ($password !== $password_confirm) {
        echo "Passwords do not match.";
        exit;
      }

      $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
      $stmt->execute([':username' => $username]);
      if ($stmt->rowCount() > 0) {
        echo "Username already taken.";
        exit;
      }

      $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
      $stmt->execute([':email' => $email]);
      if ($stmt->rowCount() > 0) {
        echo "This email is already registered. Click <a href='login.php'>here</a> to login.";
        exit;
      }

      // Register the user
      $user = new User();
      if ($user->create($username, $email, $password)) {
        echo "Registration successful.";
        header('Location: /login');
        exit;
      } else {
        echo "Registration failed.";
      }
    } else {
      echo "Invalid request method.";
    }
  }

  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_SESSION['username'])) {
        header('Location: /');
        // TODO: Tell the user they are already logged in
        exit;
      }
      $username = trim($_POST['username'] ?? '');
      $password = $_POST['password'] ?? '';

      // Validate inputs
      if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        return;
      }

      // Authenticate the user
      $user = new User();
      if ($user->authenticate($username, $password)) {
        session_start();
        $_SESSION['username'] = $username;
        header('Location: /');
        exit;
      } else {
        echo "Invalid username or password.";
      }
    } else {
      echo "Invalid request method.";
    }
  }

  public function logout()
  {
    session_start();
    session_unset();
    session_destroy();
    header('Location: /login');
  }
}
