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

if ($data['to_login'] === true) {
    $user = new AdminUser($data['username'], $data['password']);
    if (AdminUser::login($user)) {
        sendJsonResponse(['message' => 'Login successful'], 200);
    } else {
        sendJsonResponse(['message' => 'Invalid username or password'], 401);
    }
} else if ($data['to_login'] === false) {
    AdminUser::logout();
    sendJsonResponse(['message' => 'Logout successful'], 200);
} else {
    sendJsonResponse(['message' => 'Method not allowed'], 405);
}

?>
