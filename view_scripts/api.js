function getProductCategories(callback) {
  fetch("../backend/products?categories")
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}

function getProducts(
  categoryId,
  includeNotAvailable,
  includeArchived,
  callback
) {
  let uri = `../backend/products?category_id=${categoryId}`;

  if (includeNotAvailable) {
    uri += "&include_not_available";
  }

  if (includeArchived) {
    uri += "&include_archived";
  }

  fetch(uri)
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => console.error("Error: ", error));
}

function addProduct(
  categoryId,
  name,
  price,
  description,
  image,
  isAvailable,
  callback
) {
  fetch("../backend/products/", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
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
