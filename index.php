<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$base_uri = $_ENV['APP_BASE_URI'] ?? '';
$request_uri = $_SERVER['REQUEST_URI'];
$router = '';

if (strpos($request_uri, $base_uri) === 0) {
    $request_uri = substr($request_uri, strlen($base_uri));
}

switch ($request_uri) {
    case '':
    case '/':
        $router = '/public/app.php';
        break;
    case '/backend':
        $router = '/_api_/api.php';
        break;
    case '/admin':
        $router = '/_admin_/admin.php';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        echo "404 Not Found: " . $request_uri;
        exit;
}

require_once __DIR__ . $router;

?>
