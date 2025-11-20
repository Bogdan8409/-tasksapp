<?php
require_once '../config/db.php';
require_once '../app/Core/Controller.php';
require_once '../app/Controllers/TaskController.php';

$controller = new TaskController();

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (preg_match('/^\/edit\/(\d+)$/', $requestUri, $matches) && $requestMethod === 'GET') {
    $controller->edit($matches[1]);
} elseif ($requestUri === '/edit' && $requestMethod === 'POST') {
    $controller->update();
} else {
    // Handle other routes or show a 404 page
    http_response_code(404);
    echo '404 Not Found';
}
?>