function htmlEncode(str) {
  if (typeof str !== "string") return str; // Check if the input is a string
  return str
    .replace(/&/g, "&amp;") // Must be done first
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;") // Optional, but good practice
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
}

function createProductCard(product) {
  // 1. Convert the object to a JSON string
  // 2. HTML encode the JSON string for the attribute
  const encodedProductData = htmlEncode(JSON.stringify(product));

  // 3. Use a data-* attribute and set the encoded string

  const productCard = document.createElement("div");
  productCard.className = "product-card card";
  productCard.setAttribute("data-product", encodedProductData); // Set the encoded string as a data attribute
  productCard.style.width = "18rem";

  const productImage = document.createElement("img");
  productImage.className = "card-img-top bd-placeholder-img";
  productImage.style.width = "100%"; // Set the width to 100% of the card
  productImage.style.aspectRatio = "1 / 1"; // Maintain a square aspect ratio
  productImage.style.objectFit = "cover"; // Cover the entire area of the card
  productImage.style.borderBottom = "2px solid #ddd"; // Optional: Add a border for better separation
  productCard.appendChild(productImage);

  if (product["image"] && product["image_type"]) {
    productImage.src = `data:image/${product["image_type"]};base64,${product["image"]}`;
    productImage.alt = htmlEncode(product["name"] || "Product Image");
  } else {
    productImage.src =
      "https://operaparallele.org/wp-content/uploads/2023/09/Placeholder_Image.png";
    productImage.alt = "Placeholder Image";
  }

  const productCardBody = document.createElement("div");
  productCardBody.className = "card-body";
  productCard.appendChild(productCardBody);

  const productName = document.createElement("h4");
  productName.className = "card-title";
  productName.innerHTML = htmlEncode(product["name"] || "Unnamed Product");
  productCardBody.appendChild(productName);

  const productDescription = document.createElement("p");
  productDescription.className = "card-text";
  productDescription.innerHTML = htmlEncode(product["description"] || "");
  productCardBody.appendChild(productDescription);

  return productCard;
}
