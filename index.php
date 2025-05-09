<?php

/*
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$baseUri = ($_ENV['APP_BASE_URI'] ?? '') . '/';
$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, $baseUri) === 0) {
    $requestUri = substr($requestUri, strlen($baseUri));
}

$baseRequestUri = strpos($requestUri, "backend") !== false
    ? substr($requestUri, 0, length: strpos($requestUri, "/"))
    : $requestUri;

switch ($baseRequestUri) {
    case "":
    case '/':
        require_once __DIR__ . '/public/app.php';
        break;
    case 'backend':
        $requestUri = substr($requestUri, strlen('backend'));
        require_once __DIR__ . '/_api_/api.php';
        exit;
    case 'admin':
    case 'admin/':
        $requestUri = substr($requestUri, strlen('admin'));
        require_once __DIR__ . '/_admin_/admin.php';
        exit;
    default:
        header("HTTP/1.0 404 Not Found");
        exit("404 Not Found: " . $requestUri);
}
*/
header("Location: public/", true, 302);
exit;
?>
