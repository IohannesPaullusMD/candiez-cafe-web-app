function viewMenu() {
  const root = $("root");
  const div1 = $("<div>", {
    class: "container",
  });

  getProductCategories();
  getProducts(1);
}

function getProductCategories() {
  $.ajax({
    url: `../backend/products?categories`,
    type: "GET",
    dataType: "json",
    success: renderCategories,
    error: function (error) {
      console.error("Error fetching products details:", error);
    },
  });
}

function getProducts(category) {
  $.ajax({
    url: `../backend/products?includeNotAvailable&category=${category}`,
    type: "GET",
    dataType: "json",
    success: (products) => {
      renderProducts(products, category);
    },
    error: function (error) {
      console.error("Error fetching products details:", error);
    },
  });
}

function renderCategories(categories) {
  console.log("Categories:", categories);
}

function renderProducts(products, category) {
  console.log("Products:", products);
}
