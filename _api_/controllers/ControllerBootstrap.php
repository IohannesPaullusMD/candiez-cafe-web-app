<?php
// Ensure proper JSON response
header('Content-Type: application/json');

// Parse PUT/DELETE requests
$request_method = $_SERVER['REQUEST_METHOD'];
$data = [];

// Parse input data based on request method
if ($request_method === 'PUT' || $request_method === 'DELETE') {
    parse_str(file_get_contents('php://input'), $data);
} else if ($request_method === 'POST') {
    $data = $_POST;
    
    // Handle JSON body for POST requests
    $contentType = isset($_SERVER['CONTENT_TYPE']) ?? '';
    if (strpos($contentType, 'application/json') !== false) {
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);
        if ($jsonData) {
            $data = array_merge($data, $jsonData);
        }
    }
}

/**
 * Helper function to send JSON responses <br>
 * exits the script after sending the response
 */
function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

?>