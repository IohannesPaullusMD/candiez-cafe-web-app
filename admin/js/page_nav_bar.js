function createPageNavBar() {
  const nav = document.createElement("nav");
  nav.className = "navbar navbar-expand-lg navbar-dark bg-dark";
  nav.innerHTML = `
    <a class="navbar-brand text-white ms-3 a-tag" href="#products">&nbsp;Candiez Café</a>
      <button
        class="navbar-toggler me-3"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse flex-lg-row-reverse mx-3" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white a-tag" href="#products">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white a-tag" href="#archive">Archive</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white a-tag" href="#logout">Logout</a>
          </li>
        </ul>
      </div>
  `;
  return nav;
}
