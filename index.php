<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$base_uri = $_ENV['APP_BASE_URI'] ?? '';
$request_uri = $_SERVER['REQUEST_URI'];

if (strpos($request_uri, $base_uri) === 0) {
    $request_uri = substr($request_uri, strlen($base_uri));
}

switch ($request_uri) {
    case '/':
    case '/home':
        require_once 'views/app.php';
        break;
    default:
        echo "404 Not Found: " . $request_uri;
        break;
}

?>
