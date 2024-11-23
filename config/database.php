<?php
class Database
{
  private static $instance = null;
  private $pdo;

  private function __construct()
  {
    $dsn = 'mysql:host=localhost;dbname=tale_trail';
    $username = 'root';
    $password = '';
    $this->pdo = new PDO($dsn, $username, $password);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new Database();
    }
    return self::$instance->pdo;
  }
}

$pdo = Database::getInstance();