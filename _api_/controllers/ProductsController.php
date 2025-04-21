<?php
require_once __DIR__ . '/../models/Products.php';
require_once __DIR__ .'/ControllerBootstrap.php';

// Initialize products model
$products = new Products();

if ($requestMethod === 'GET') {
    $response = [];
    if (isset($data['categories'])) {
        $response = $products->getProductCategories();
    } else {
        // Validate and sanitize input parameters
        $includeNotAvailable = isset($data['include_not_available']);
        $includeIsArchived = isset($data['include_archived']);
        $productCategoryId = isset($data['category_id']) ? 
            filter_var($data['category_id'], FILTER_VALIDATE_INT) : 1;

        if ($productCategoryId === false) {
            sendJsonResponse(['message' => 'Invalid product category ID'], 400);
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
    sendJsonResponse(['message' => 'Unauthorized'], 401);
}

// the codes below will only be executed for authenticated users

try {
    switch ($requestMethod) {
        case 'POST':
            // Create and validate product
            $product = ProductType::createFromData($data);
            // ?name=abc&description=abc&price=12.34&categoryId=1&isAvailable=false
            $validationErrors = $product->validate();
            if (!empty($validationErrors)) {
                sendJsonResponse(['message' => $validationErrors], 400);
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
                sendJsonResponse(['message' => 'Invalid product ID'], 400);
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
                sendJsonResponse(['message' => 'Invalid product ID'], 400);
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
    sendJsonResponse(['message' => 'An unexpected error occurred'], 500);
}

?>