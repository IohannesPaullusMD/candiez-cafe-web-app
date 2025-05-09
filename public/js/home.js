function viewHome() {
  console.log("home page...");
  const root = document.getElementById("root");
  root.style.justifyContent = "center";
  root.style.alignItems = "center";
  root.style.display = "flex";
  root.innerHTML = `
    <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 text-lg-left">
          <h1 class="text-dark">Welcome to Candiez Café</h1>
          <p class="text-muted">
            Enjoy our delicious treats and beverages in a cozy atmosphere or
            order online for pickup.
          </p>
          <a class="btn btn-dark a-tag" href="#menu">View Menu</a>
        </div>
        <div class="col-lg-6 col-md-12 mt-4 mt-lg-0 margin-top-lg-10">
          
          <img id="home-img" class="rounded" src="../docs/img-placeholder.jpg" width="100%" alt="home-image">
        </div>
      </div>
  `;

  /*
  <img src=`data:image/${product['image_type']};base64,${product['image']}`>
  */
}
