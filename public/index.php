<?php
require_once '../config/init.php';
require_once '../vendor/autoload.php';
use App\Controllers\UserController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$userController = new UserController();
switch ($method) {
  case 'GET':
    switch ($uri) {
      case '/':
        require_once '../src/views/home.php';
        break;

      case '/register':
        require_once '../src/views/auth/register.php';
        break;

      case '/login':
        if (isset($_SESSION['user_id'])) {
          header("Location: /");
          exit;
        }
        require_once '../src/views/auth/login.php';
        break;

      case '/logout':
        $userController->logout();
        break;
      default:
        http_response_code(404);
        echo "Page not found.";
        break;
    }

    break;
  case 'POST':
    if ($uri === '/register')
      $userController->register();

    if ($uri === '/login')
      $userController->login();
    break;
  default:
    echo "Method not allowed.";
    break;
}