<?php
session_start();
$requestUri = strtok($requestUri, '?');

switch ($requestUri) {
    case '/products':
    // case '/products/':
        require_once __DIR__ . '/controllers/ProductsController.php';
        break;
    case '/user':
        // require_once __DIR__ . '/controllers/UserController.php';
        break;
    default:
    echo $requestUri;
        header("HTTP/1.0 404 Not Found");
        exit("404 Not Found: " . $requestUri);
}
?>
