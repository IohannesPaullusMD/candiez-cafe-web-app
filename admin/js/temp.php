<?php
// filepath: api/save_product.php
header('Content-Type: application/json');

// Database connection
require_once '../config/database.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Get form data
$name = $conn->real_escape_string($_POST['name']);
$description = $conn->real_escape_string($_POST['description']);
$category_id = (int)$_POST['category_id'];
$availability = (int)$_POST['availability'];
$product_id = $_POST['product_id'];

// Upload directory
$uploadDir = __DIR__ . '/../uploads/products/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Handle image upload
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['image']['tmp_name'];
    $name_parts = explode('.', $_FILES['image']['name']);
    $extension = end($name_parts);
    
    // Create unique filename
    $filename = uniqid() . '.' . $extension;
    $targetPath = $uploadDir . $filename;
    
    // Move the uploaded file
    if (move_uploaded_file($tmp_name, $targetPath)) {
        // Store relative path for database
        $imagePath = 'uploads/products/' . $filename;
    } else {
        die(json_encode(['success' => false, 'message' => 'Failed to move uploaded file']));
    }
}

// SQL query based on whether it's an insert or update
if ($product_id === "-1") {
    // New product - require image
    if (!$imagePath) {
        die(json_encode(['success' => false, 'message' => 'Image is required for new products']));
    }
    
    $query = "INSERT INTO products (name, description, category_id, availability, image_str) 
              VALUES ('$name', '$description', $category_id, $availability, '$imagePath')";
} else {
    // Update existing product
    $product_id = (int)$product_id;
    
    // Get existing image path if no new image uploaded
    if (!$imagePath) {
        $result = $conn->query("SELECT image_str FROM products WHERE id = $product_id");
        if ($row = $result->fetch_assoc()) {
            $imagePath = $row['image_str'];
        }
    }
    
    $query = "UPDATE products SET 
              name = '$name', 
              description = '$description', 
              category_id = $category_id, 
              availability = $availability, 
              image_str = '$imagePath' 
              WHERE id = $product_id";
}

// Execute query
if ($conn->query($query)) {
    echo json_encode(['success' => true, 'message' => 'Product saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>

<script>
    function saveProduct() {
  // Create FormData object for file upload
  const formData = new FormData();
  
  // Get form data
  const imageFile = document.getElementById("imageUpload").files[0];
  const name = document.getElementById("name").value;
  const description = document.getElementById("description").value;
  const category = document.getElementById("category").value;
  const availability = document.getElementById("availability").checked;
  const prodId = document.getElementById("prod-id").innerHTML;
  
  // Validate
  if (!imageFile && prodId === "-1") {
    alert("Please upload an image.");
    return;
  }

  if (!name || !description || category === "-1") {
    alert("Please fill in all fields.");
    return;
  }
  
  // Append all data to FormData
  formData.append('image', imageFile);
  formData.append('name', name);
  formData.append('description', description);
  formData.append('category_id', category);
  formData.append('availability', availability ? 1 : 0);
  formData.append('product_id', prodId);
  
  // Send with fetch
  fetch('../api/save_product.php', {
    method: 'POST',
    body: formData
    // Don't set Content-Type header, browser will set it automatically
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Handle success
      alert('Product saved successfully!');
      // Close modal or refresh list
      $('#productModal').modal('hide');
      loadProducts(); // Function to reload products list
    } else {
      alert('Error: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while saving the product.');
  });
}
</script>
