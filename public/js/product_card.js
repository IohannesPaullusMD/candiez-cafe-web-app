function htmlEncode(str) {
  if (typeof str !== "string") return str; // Check if the input is a string
  return str
    .replace(/&/g, "&amp;") // Must be done first
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;") // Optional, but good practice
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
}

function ProductCard(product) {
  // 1. Convert the object to a JSON string
  // 2. HTML encode the JSON string for the attribute
  const encodedProductData = htmlEncode(JSON.stringify(product));

  // 3. Use a data-* attribute and set the encoded string
  return `
    <div class="product-card" data-product="${encodedProductData}" style="border: 1px solid #ccc; padding: 10px; margin: 10px; cursor: pointer;">
        ${
          // <img>
          product["image"] && product["image_type"]
            ? `<img src="data:image/${product["image_type"]};base64,${
                product["image"]
              }" alt="${htmlEncode(product["name"] || "Product Image")}">` // Added alt text
            : ""
        }
        <h4>${
          // prod name
          htmlEncode(product["name"] || "Unnamed Product")
        }</h4> 
        <p>${htmlEncode(product["description"] || "")}</p>
        <p>Price: ${htmlEncode(
          product["price"] ? "$" + product["price"] : "N/A"
        )}</p> 
        
    </div>
  `;
}

document.addEventListener("DOMContentLoaded", () => {
  const productCards = document.querySelectorAll(".product-card");
  productCards.forEach((card) => {
    card.addEventListener("click", () => {
      const encodedProductData = card.getAttribute("data-product"); // Get the encoded string

      // No need to decode HTML entities here, JSON.parse handles the string
      try {
        const productData = JSON.parse(encodedProductData); // Parse the JSON string back into an object
        console.log("Product Data:", productData);
        // Now you can use the productData object
        alert(`You clicked on: ${productData.name}`);
      } catch (e) {
        console.error("Error parsing product data:", e);
      }
    });
  });
});
