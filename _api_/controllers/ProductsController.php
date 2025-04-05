<?php
require_once __DIR__ . '/../models/Products.php';
require_once __DIR__ .'ControllerBootstrap.php';


// Initialize products model
$products = new Products();

if ($request_method === 'GET') {
    $response = [];
    if (isset($_GET['categories'])) {
        $response = $products->getProductCategories();
    } else {
        // Validate and sanitize input parameters
        $includeNotAvailable = isset($_GET['includeNotAvailable']);
        $includeIsArchived = isset($_GET['includeArchived']);
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
} 

if (!isset($_SESSION['admin_user'])) {
    sendJsonResponse(['error' => 'Unauthorized'], 401);
}

try {
    switch ($request_method) {
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
            
            $isArchive = isset($data['archive']);
            
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
    error_log("Error in ProductsController.php: " . $e->getMessage());
    sendJsonResponse(['error' => 'An unexpected error occurred'], 500);
}

?>