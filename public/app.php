
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Candiez Café</title>
    <scripts src="node_modules/jquery/dist/jquery.min.js"></scripts>
    <link
      href="node_modules/bootstrap/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
   <!-- 1. Load jQuery first, WITHOUT defer -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" defer></script>
   <script src="view_scripts/api.js" defer></script>
   <script src="view_scripts/public_script.js" defer></script> 
  </head>
  <body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand text-white" href="#">&nbsp;Candiez Café</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white a-tag" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white a-tag" href="#menu">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white a-tag" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white a-tag" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 flex-grow-1" id="root">
      
    </div>

    <!-- Footer (Sticks to bottom) -->
    <footer class="bg-dark text-center text-white py-3 mt-auto">
      <p>© 2025 Candiez Café. All rights reserved.</p>
    </footer>
  </body>
</html>
