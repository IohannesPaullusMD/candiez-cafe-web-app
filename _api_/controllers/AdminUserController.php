<?php
require_once __DIR__ . '/../models/AdminUser.php';
require_once __DIR__ .'/ControllerBootstrap.php';


if ($requestMethod !== 'PUT' || empty($data) || !isset($data['to_login'])) {
    sendJsonResponse(['message' => 'Invalid request',
    'q1' => $requestMethod,
    'q2' => empty($data),
    'q3' => !isset($data['to_login']),
    'q4' => $contentType,
], 401);
}

$toLogin = filter_var($data['to_login'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
if ($toLogin === null) {
    sendJsonResponse(['message' => 'Bad Request'], 400);
}

if ($data['to_login']) {
    $user = new AdminUser($data['username'], $data['password']);
    if (AdminUser::login($user)) {
        sendJsonResponse(['message' => 'Login successful'], 200);
    } else {
        sendJsonResponse(['message' => 'Invalid username or password'], 401);
    }
} else {
    AdminUser::logout();
    sendJsonResponse(['message' => 'Logout successful'], 200);
}

?>
