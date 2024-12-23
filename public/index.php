<?php
require_once '../config/init.php';
require_once '../vendor/autoload.php';

use FastRoute\RouteCollector;
use App\Controllers\UserController;
use App\Controllers\StoryController;
// Set up the FastRoute dispatcher
$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
  // Define routes
  $r->addRoute('GET', '/', function () {
    require_once '../src/views/home.php';
  });
  $r->addRoute('GET', '/register', function () {
    if (isset($_SESSION['username'])) {
      header("Location: /");
      // TODO: Tell the user they are already logged in
      exit;
    }
    require_once '../src/views/auth/register.php';
  });
  $r->addRoute('GET', '/login', function () {
    if (isset($_SESSION['username'])) {
      header("Location: /");
      // TODO: Tell the user they are already logged in
      exit;
    }
    require_once '../src/views/auth/login.php';
  });
  $r->addRoute('GET', '/story/create', function () {
    require_once '../src/views/story/create.php';
  });

  $r->addRoute('GET', '/logout', [UserController::class, 'logout']);
  $r->addRoute('POST', '/register', [UserController::class, 'register']);
  $r->addRoute('POST', '/login', [UserController::class, 'login']);
  $r->addRoute('POST', '/story/create', [StoryController::class, 'createStory']);
});

// Parse the incoming request
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Dispatch the route
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    http_response_code(404);
    require_once '../src/views/errors/404.php';
    break;

  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    http_response_code(405);
    echo "405 - Method not allowed.";
    break;

  case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars = $routeInfo[2];

    if (is_callable($handler)) {
      // If the handler is a closure (for views)
      call_user_func_array($handler, $vars);
    } elseif (is_array($handler)) {
      // If the handler is a controller and method
      [$controller, $method] = $handler;
      (new $controller())->$method($vars);
    }
    break;
}
