<?php
require_once __DIR__ . '/../models/Products.php';

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
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
    if (strpos($contentType, 'application/json') !== false) {
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);
        if ($jsonData) {
            $data = array_merge($data, $jsonData);
        }
    }
}

// Initialize products model
$products = new Products();

// Helper function to send JSON response
function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

try {
    switch ($request_method) {
        case 'GET':
            $response = [];
            if (isset($_GET['categories'])) {
                $response = $products->getProductCategories();
            } else {
                // Validate and sanitize input parameters
                $includeNotAvailable = isset($_GET['includeNotAvailable']) ? 
                    filter_var($_GET['includeNotAvailable'], FILTER_VALIDATE_BOOLEAN) : false;
                $includeIsArchived = isset($_GET['includeIsArchived']) ? 
                    filter_var($_GET['includeIsArchived'], FILTER_VALIDATE_BOOLEAN) : false;
                $productCategoryId = isset($_GET['productCategoryId']) ? 
                    filter_var($_GET['productCategoryId'], FILTER_VALIDATE_INT) : 1;
    
                if ($productCategoryId === false) {
                    sendJsonResponse(['error' => 'Invalid product category ID'], 400);
                }
                
                $response = $products->getProducts(
                    $includeNotAvailable, 
                    $includeIsArchived,
                    $productCategoryId
                );
            }

            sendJsonResponse($response);
            break;
            
        case 'POST':
            // Create and validate product
            $product = ProductType::createFromData($data);
            // ?name=abc&description=abc&price=12.34&categoryId=1&isAvailable=false
            $validationErrors = $product->validate();
            if (!empty($validationErrors)) {
                sendJsonResponse(['errors' => $validationErrors], 400);
            }
            
            if ($products->addProduct($product)) {
                sendJsonResponse(['message' => 'Product added successfully'], 201);
            } else {
                sendJsonResponse(['message' => 'Failed to add product'], 500);
            }            
            break;
            
        case 'PUT':
            $productId = filter_var($data['id'] ?? ProductType::NO_ID_PROVIDED, FILTER_VALIDATE_INT);
            
            if ($productId <= 0) {
                sendJsonResponse(['error' => 'Invalid product ID'], 400);
            }
            
            // Create and validate product
            $product = ProductType::createFromData($data);
            
            $validationErrors = $product->validate();
            if (!empty($validationErrors)) {
                sendJsonResponse(['errors' => $validationErrors], 400);
            }
            
            if ($products->updateProduct($product)) {
                sendJsonResponse(['message' => 'Product updated successfully']);
            } else {
                sendJsonResponse(['message' => 'Failed to update product'], 500);
            }
            break;
            
        case 'DELETE':
            $productId = filter_var($data['id'] ?? 0, FILTER_VALIDATE_INT);
            
            if ($productId <= 0) {
                sendJsonResponse(['error' => 'Invalid product ID'], 400);
            }
            
            $isArchive = filter_var($data['isArchive'] ?? false, FILTER_VALIDATE_BOOLEAN);
            
            if ($isArchive) {
                if ($products->archiveProduct($productId)) {
                    sendJsonResponse(['message' => 'Product archived successfully']);
                } else {
                    sendJsonResponse(['message' => 'Failed to archive product'], 500);
                }
            } else {
                if ($products->deleteProduct($productId)) {
                    sendJsonResponse(['message' => 'Product deleted successfully']);
                } else {
                    sendJsonResponse(['message' => 'Failed to delete product'], 500);
                }
            }
            break;
            
        default:
            sendJsonResponse(['message' => 'Method Not Allowed'], 405);
            break;
    }
} catch (Exception $e) {
    error_log("Error in api.php: " . $e->getMessage());
    sendJsonResponse(['error' => 'An unexpected error occurred'], 500);
}

?>