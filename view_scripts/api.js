function getProductCategories(callback) {
  fetch("../_api_/api.php?path=products&get_categories=true")
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}

function getProducts(
  categoryId,
  includeNotAvailable = false,
  includeArchived = false,
  callback
) {
  const uri = `../_api_/api.php?path=products&category_id=${categoryId}&include_not_available=${includeNotAvailable}&include_archived=${includeArchived}`;

  fetch(uri)
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}

function addProduct(
  categoryId,
  name,
  description,
  image,
  isAvailable,
  callback
) {
  fetch("../_api_/api.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      path: "products",
      add_product: true,
      category_id: categoryId,
      name: name,
      description: description,
      image: image,
      is_available: isAvailable,
    }),
  })
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}

function updateProductDetails(
  productId,
  categoryId,
  name,
  price,
  description,
  image,
  isAvailable,
  callback
) {
  fetch("backend/products", {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      update_product: true,
      product_id: productId,
      category_id: categoryId,
      name: name,
      price: price,
      description: description,
      image: image,
      is_available: isAvailable,
    }),
  })
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}

function setProductArchiveStatus(productId, state, callback) {
  fetch(`backend/products`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      update_archive_status: true,
      product_id: productId,
      is_archive: state,
    }),
  })
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}

function setAdminUserStatus(toLogin, username, password, callback) {
  fetch("../_api_/api.php", {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      path: "users",
      to_login: toLogin,
      username: username,
      password: password,
    }),
  })
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}

function deleteProduct(productId, callback) {
  fetch("backend/products", {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      delete_product: true,
      product_id: productId,
    }),
  })
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}
