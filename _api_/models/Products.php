<?php
require_once __DIR__ . '/ProductType.php';
require_once __DIR__ .'/DatabaseConnection.php';

class Products {
    private mysqli $dbConn;
    
    public function __construct() {
        $this->dbConn = DatabaseConnection::createConnection();
    }
    
    public function __destruct() {
        // Ensure database connection is closed when object is destroyed
        if ($this->dbConn) {
            mysqli_close($this->dbConn);
        }
    }

    public function getProductCategories(): array {
        $sql = "SELECT id, name FROM product_categories ORDER BY id ASC";
        $stmt = mysqli_prepare($this->dbConn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $categories = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categories[] = [
                    'id' => (int)$row['id'],
                    'name' => $row['name'],
                ];
            }
        }
        
        mysqli_stmt_close($stmt);
        return $categories;
    }

    public function getProducts(
        bool $includeNotAvailable = false,
        bool $includeIsArchived = false,
        int $productCategoryId = 1
    ): array {
        // Use prepared statement to prevent SQL injection
        $sql = "SELECT * FROM products WHERE category_id = ? ";
        
        if (!$includeNotAvailable) {
            $sql .= "AND is_available = 1 ";
        }

        if (!$includeIsArchived) {
            $sql .= "AND (is_archived = 0 OR is_archived IS NULL) ";
        }
        
        $sql .= "ORDER BY id ASC";
        $stmt = mysqli_prepare($this->dbConn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $productCategoryId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $products = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product = new ProductType(
                    (int)$row['id'],
                    $row['name'],
                    $row['description'],
                    (float)$row['price'],
                    (int)$row['category_id'],
                    (bool)$row['is_available'],
                    $row['image'] ?? '',
                );
                $products[] = $product->toArray();
            }
        }
        error_log("SQL: " . $sql);
        
        mysqli_stmt_close($stmt);
        return $products;
    }

    public function addProduct(ProductType $product): bool {
        try {
            // Begin transaction
            mysqli_begin_transaction($this->dbConn);
            
            $name = $product->getName();
            $description = $product->getDescription();
            $price = $product->getPrice();
            $categoryId = $product->getCategoryId();
            $isAvailable = $product->isAvailable() ? 1 : 0;
            $image = $product->getImage();
            
            $sql = "INSERT INTO products (name, description, price, category_id, is_available, image) 
                   VALUES (?, ?, ?, ?, ?, ?)";
                   
            $stmt = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                'ssdiss',
                $name,
                $description,
                $price,
                $categoryId,
                $isAvailable,
                $image
            );
            
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            // Commit if successful
            if ($result) {
                mysqli_commit($this->dbConn);
                return true;
            }
            
            // Rollback if failed
            mysqli_rollback($this->dbConn);
            return false;
        } catch (Exception $e) {
            mysqli_rollback($this->dbConn);
            error_log("Error adding product: " . $e->getMessage());
            return false;
        }
    }

    public function updateProduct(ProductType $product): bool {
        try {
            // Begin transaction
            mysqli_begin_transaction($this->dbConn);
            
            $id = $product->getId();
            $name = $product->getName();
            $description = $product->getDescription();
            $price = $product->getPrice();
            $categoryId = $product->getCategoryId();
            $isAvailable = $product->isAvailable() ? 1 : 0;
            $image = $product->getImage();
            
            $sql = "UPDATE products SET name=?, description=?, price=?, 
                    category_id=?, is_available=?, image=? WHERE id=?";
                   
            $stmt = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                'ssdissi',
                $name,
                $description,
                $price,
                $categoryId,
                $isAvailable,
                $image,
                $id
            );
            
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            // Commit if successful
            if ($result) {
                mysqli_commit($this->dbConn);
                return true;
            }
            
            // Rollback if failed
            mysqli_rollback($this->dbConn);
            return false;
        } catch (Exception $e) {
            mysqli_rollback($this->dbConn);
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    public function setProductArchiveStatus(int $id, bool $state): bool {
        if ($id <= 0) {
            return false;
        }
        
        try {
            $sql = "UPDATE products SET is_archived=? WHERE id=?";
            $stmt = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($stmt, 'ii', $state, $id);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($result) {
                mysqli_commit($this->dbConn);
                return true;
            }
            
            // Rollback if failed
            mysqli_rollback($this->dbConn);
            return false;
        } catch (Exception $e) {
            error_log("Error archiving product: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteProduct(int $id): bool {
        if ($id <= 0) {
            return false;
        }
        
        try {
            $sql = "DELETE FROM products WHERE id=?";
            $stmt = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        } catch (Exception $e) {
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }

    // public function getProductById(int $id): ?ProductType {
    //     if ($id <= 0) {
    //         return null;
    //     }
        
    //     $sql = "SELECT * FROM products WHERE id = ? AND (is_archived = 0 OR is_archived IS NULL)";
    //     $stmt = mysqli_prepare($this->dbConn, $sql);
    //     mysqli_stmt_bind_param($stmt, 'i', $id);
    //     mysqli_stmt_execute($stmt);
    //     $result = mysqli_stmt_get_result($stmt);
        
    //     if ($result && mysqli_num_rows($result) > 0) {
    //         $row = mysqli_fetch_assoc($result);
    //         return new ProductType(
    //             (int)$row['id'],
    //             $row['name'],
    //             $row['description'],
    //             (float)$row['price'],
    //             (int)$row['category_id'],
    //             (bool)$row['is_available'],
    //             $row['image'] ?? ''
    //         );
    //     }
        
    //     mysqli_stmt_close($stmt);
    //     return null;
    // }

}
?>
