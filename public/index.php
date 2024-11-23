<?php
require_once '../config/init.php';
require_once '../vendor/autoload.php';
use App\Controllers\UserController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/register' && $method === 'POST') {
  $controller = new UserController();
  $controller->register();
} elseif ($uri === '/login' && $method === 'POST') {
  $controller = new UserController();
  $controller->login();
} else {
  echo "404 - Page not found.";
}
