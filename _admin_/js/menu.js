function viewMenu() {
  const root = $("root");
  const div1 = $("<div>", {
    class: "container",
  });

  getProductCategories();
  getProducts(1);
}

function renderCategories(categories) {
  console.log("Categories:", categories);
}

function renderProducts(products, category) {
  console.log("Products:", products);
}
