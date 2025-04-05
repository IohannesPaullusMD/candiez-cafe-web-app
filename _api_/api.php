<?php
$request_uri = strtok($request_uri, '?');
// echo 'this was executed';

switch ($request_uri) {
    case '/products':
    case '/products/':
        require_once __DIR__ . '/controllers/ProductsController.php';
        break;
    case '/user':
        // require_once __DIR__ . '/controllers/UserController.php';
        break;
    default:
    echo $request_uri;
        header("HTTP/1.0 404 Not Found");
        exit("404 Not Found: " . $request_uri);
}
?>
