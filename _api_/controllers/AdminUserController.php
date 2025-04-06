<?php
require_once __DIR__ . '/../models/AdminUser.php';
require_once __DIR__ .'ControllerBootstrap.php';

header('Content-Type: application/json');

$user = null;

if (empty($data)) {
    sendJsonResponse(['error' => 'Invalid request'], 400);
}

$user = new AdminUser($data['username'], $data['password']);

if ($requestMethod === 'POST') {
    if ($user->login($user)) {
        sendJsonResponse(['message' => 'Login successful'], 200);
    } else {
        sendJsonResponse(['error' => 'Invalid username or password'], 401);
    }
} elseif ($requestMethod === 'DELETE') {
    $user->logout();
    sendJsonResponse(['message' => 'Logout successful'], 200);
} else {
    sendJsonResponse(['error' => 'Method not allowed'], 405);
}

?>