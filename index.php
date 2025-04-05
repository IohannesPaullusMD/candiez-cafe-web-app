<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$base_uri = ($_ENV['APP_BASE_URI'] ?? '') . '/';
$request_uri = $_SERVER['REQUEST_URI'];

if (strpos($request_uri, $base_uri) === 0) {
    $request_uri = substr($request_uri, strlen($base_uri));
}

$baseRequestUri = substr($request_uri, 0, strpos($request_uri, "/"));

switch ($baseRequestUri) {
    case "":
    case '/':
        require_once __DIR__ . '/public/app.php';
        break;
    case 'backend':
        $request_uri = substr($request_uri, strlen('backend'));
        require_once __DIR__ . '/_api_/api.php';
        exit;
    case 'admin':
        $request_uri = substr($request_uri, strlen('admin'));
        require_once __DIR__ . '/_admin_/admin.php';
        exit;
    default:
        header("HTTP/1.0 404 Not Found");
        exit("404 Not Found: " . $request_uri);
}

?>
