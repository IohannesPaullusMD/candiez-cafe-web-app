<?php
/**
 * Helper function to send JSON responses <br>
 * exits the script after sending the response
 */
function sendJsonResponse($data = ['message' => 'empty response'], $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
$data = []; // Default to GET data

switch ($requestMethod) {
    case 'GET':
        $data = $_GET;
        break;
    case 'PUT':
    case 'DELETE':
        parse_str(file_get_contents('php://input'), $data);
        break;
    case 'POST':
        $data = $_POST;
        $contentType = isset($_SERVER['CONTENT_TYPE']) ?? '';
        if (strpos($contentType, 'application/json') !== false) {
            $json = file_get_contents('php://input');
            $jsonData = json_decode($json, true);
            if ($jsonData) {
                $data = array_merge($data, $jsonData);
            }
        }
        break;
    default:
        header("HTTP/1.1 405 Method Not Allowed");
        header("Allow: GET, POST, PUT, DELETE");
        exit("Error: Method Not Allowed");
}

?>
