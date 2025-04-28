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
    loadProducts(categories[1]["id"]);
  });
}

function loadProducts(categoryId) {
  const root = document.getElementById("products-div");
  root.innerHTML = "";
  getProducts(categoryId, false, false, (products) => {
    products.forEach((product) => {
      root.innerHTML += `
      <p>
        ${product["id"]}: ${product["name"]}, 
        ${product["category_id"]}, Php ${product["price"]}
      </p>`;
    });
  });
}
