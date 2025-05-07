<?php
session_start();

require_once __DIR__.'/controllers/ControllerBootstrap.php';
require_once __DIR__.'../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

// $requestUri = strtok($_SERVER['REQUEST_URI'] ?? '?', '?');


switch ($data['path'] ?? '') {
    case 'products':
    // case '/products/':
        require_once __DIR__ . '/controllers/ProductsController.php';
        break;
    case 'users':
        require_once __DIR__ . '/controllers/AdminUserController.php';
        break;
    default:
    echo $requestUri;
        header("HTTP/1.0 404 Not Found");
        exit("404 Not Found: " . $requestUri);
}



?>
