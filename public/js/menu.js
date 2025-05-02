function viewMenu() {
  const root = document.getElementById("root");
  root.innerHTML = "";

  getProductCategories((categories) => {
    const productsDiv = document.createElement("div");
    const categoryNavBar = document.createElement("span");

    productsDiv.id = "products-div";
    categoryNavBar.id = "category-nav-bar";

    categories.forEach((category) => {
      categoryNavBar.innerHTML += `
        <button 
          class="category-button" 
          onclick="loadProducts(${category["id"]})">
            ${category["name"]}
        </button>
      `;
    });

    root.appendChild(categoryNavBar);
    root.innerHTML += "<hr>";
    root.appendChild(productsDiv);
    loadProducts(categories[0]["id"]);
  });
}

function loadProducts(categoryId) {
  const root = document.getElementById("products-div");
  // root.style.display = "flex";
  // root.style.flexWrap = "wrap";
  // root.style.gap = "1rem"; // Add gap between cards
  // root.style.justifyContent = "center"; // Center the cards
  // root.style.padding = "1rem"; // Add padding around the cards
  // root.style.backgroundColor = "#f8f9fa"; // Light background color for better visibility
  // root.style.borderRadius = "0.5rem"; // Rounded corners for the card container
  // root.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.1)"; // Subtle shadow for depth

  root.style = `
    display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; padding: 1rem; background-color: #f8f9fa; border-radius: 0.5rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    `;

  root.innerHTML = "";
  getProducts(categoryId, false, false, (products) => {
    products.forEach((product) => {
      root.appendChild(createProductCard(product));
    });
  });
}
