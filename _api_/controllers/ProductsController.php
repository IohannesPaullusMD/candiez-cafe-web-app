<?php
require_once __DIR__ . '/../models/Products.php';
require_once __DIR__ .'/ControllerBootstrap.php';

// Initialize products model
$products = new Products();

if ($requestMethod === 'GET') {
    $response = [];
    if ($data['get_categories'] ?? false) {
        $response = $products->getProductCategories();
    } else {
        // Validate and sanitize input parameters
        $includeNotAvailable = $data['include_not_available'] ?? false;
        $includeIsArchived = $data['include_archived'] ?? false;
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
    // sendJsonResponse(['message' => 'Unauthorized'], 401);
}

// the codes below will only be executed for authenticated users

try {
    switch ($requestMethod) {
        case 'POST':
            if(!($data['add_product'] ?? false)) {
                sendJsonResponse(['message'=> 'Bad Request'], 400);
            }

            // Create and validate product
            $product = ProductType::createFromData($data);
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
            $productId = $data['product_id'] ?? -1;

            if ($productId <= 0) {
                sendJsonResponse(['message' => 'Invalid product ID'], 400);
            }

            if ($data['update_product'] ?? false) {
                $productId = filter_var($data['product_id'] ?? ProductType::NO_ID_PROVIDED, FILTER_VALIDATE_INT);
                
                
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
            } else if ($data['update_archive_status'] ?? false) {
                $productId = filter_var($data['product_id'] ?? ProductType::NO_ID_PROVIDED, FILTER_VALIDATE_INT);
                $archiveStatus = filter_var($data['is_archive'], FILTER_VALIDATE_BOOLEAN);

                if ($products->setProductArchiveStatus($productId, $archiveStatus)) {
                    sendJsonResponse(['message' => 'Product archive status updated successfully']);
                } else {
                    sendJsonResponse(['message' => 'Failed to update product archive status'], 500);
                }
            } else {
                sendJsonResponse(['message'=> 'Bad Request'], 400);
            }

            break;
            
        case 'DELETE':
            if ($data['delete_product'] ?? false) {
                $productId = filter_var($data['product_id'] ?? ProductType::NO_ID_PROVIDED, FILTER_VALIDATE_INT);
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