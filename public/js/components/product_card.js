function ProductCard(product) {
  return `
    <div class="product-card" prod-data=${product}>
        ${
          product["image"] && product["image_type"]
            ? `<img src=data:image/${product["image_type"]};base64,${product["image"]}>`
            : ""
        }

        
    </div>
  `;
}
