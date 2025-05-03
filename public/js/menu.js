function viewMenu() {
  const root = document.getElementById("root");
  root.innerHTML = "";

  getProductCategories((categories) => {
    const productsDiv = document.createElement("div");
    const categoryNavBar = createCategoryNavBar(categories);

    productsDiv.id = "products-div";
    categoryNavBar.id = "category-nav-bar";

    // categories.forEach((category) => {
    //   // categoryNavBar.innerHTML += `
    //   //   <button
    //   //     class="category-button btn btn-outline-dark"
    //   //     onclick="loadProducts(${category["id"]})">
    //   //       ${category["name"]}
    //   //   </button>
    //   // `;
    //   categoryNavBar.appendChild(createCategoryButton(category));
    // });

    root.appendChild(categoryNavBar);
    root.appendChild(productsDiv);
    loadProducts(categories[0]["id"]);
  });
}

function loadProducts(categoryId) {
  const root = document.getElementById("products-div");
  root.style = `
    display: flex; 
    flex-wrap: wrap; 
    gap: 1rem; 
    justify-content: justify-center; 
    padding: 1rem; 
    background-color: #f8f9fa; 
    border-radius: 0.5rem; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
  `;
  root.innerHTML = "";
  getProducts(categoryId, false, false, (products) => {
    products.forEach((product) => {
      root.appendChild(createProductCard(product));
    });
  });
}
