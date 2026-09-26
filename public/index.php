<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/PhotoController.php';
require_once __DIR__ . '/../controllers/CommentController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
$router = new Router();

$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/photos', [PhotoController::class, 'index']);
$router->get('/photo/{id}', [PhotoController::class, 'show']);

$router->get('/upload', [PhotoController::class, 'create']);
$router->post('/upload', [PhotoController::class, 'store']);

$router->post('/photo/{id}/delete', [PhotoController::class, 'delete']);
$router->post('/photo/{id}/comments', [CommentController::class, 'store']);

$basePath = '/Photo-sharing-application/public';
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (str_starts_with($requestUri, $basePath)) {
    $requestUri = substr($requestUri, strlen($basePath));
}

if ($requestUri === '' || $requestUri === false) {
    $requestUri = '/';
}

$router->dispatch(
    $requestUri,
    $_SERVER['REQUEST_METHOD']
);