function viewHome() {
  const root = document.getElementById("root");

  root.innerHTML = `
    <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 text-center text-lg-left">
          <h1 class="text-dark">Welcome to Candiez Café</h1>
          <p class="text-muted">
            Enjoy our delicious treats and beverages in a cozy atmosphere or
            order online for pickup.
          </p>
          <a href="#menu" onclick="redirect(e)" class="btn btn-dark">View Menu</a>
        </div>
        <div class="col-lg-6 col-md-12 mt-4 mt-lg-0">
          <div
            class="bg-white d-flex align-items-center justify-content-center border rounded p-5"
          >
            <img id="home-img" src="" alt="home-image">
          </div>
        </div>
      </div>
  `;

  /*
  <img src=`data:image/${product['image_type']};base64,${product['image']}`>
  */
}
