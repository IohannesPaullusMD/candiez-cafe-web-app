function viewMenu() {
  const root = document.getElementById("root");

  getProductCategories((categories) => {
    root.innerHTML = "";
    categories.forEach((category) => {
      root.innerHTML += `<p>${category["name"]}: ${category["id"]}</p>`;
    });

    root.innerHTML += "<hr>";
    getProducts(categories[1]["id"], false, false, (products) => {
      products.forEach((product) => {
        root.innerHTML += `
      <p>
        ${product["id"]}: ${product["name"]}, 
        ${categories[product["category_id"] - 1]["name"]}, Php ${
          product["price"]
        }
      </p>`;
      });
    });
  });
}
