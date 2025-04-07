
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Candiez Café</title>
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <script src="script.js" defer></script> 
  </head>
  <body class="bg-light d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand text-white" href="#">Candiez Café</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white" href="#home" onclick="redirect(e)">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#menu">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 flex-grow-1" id="root">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 text-center text-lg-left">
          <h1 class="text-dark">Welcome to Candiez Café</h1>
          <p class="text-muted">
            Enjoy our delicious treats and beverages in a cozy atmosphere or
            order online for pickup.
          </p>
          <a href="#menu" class="btn btn-dark">View Menu</a>
        </div>
        <div class="col-lg-6 col-md-12 mt-4 mt-lg-0">
          <div
            class="bg-white d-flex align-items-center justify-content-center border rounded p-5"
          >
            <span class="text-muted">Image Placeholder</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer (Sticks to bottom) -->
    <footer class="bg-dark text-center text-white py-3 mt-auto">
      <p>© 2025 Candiez Café. All rights reserved.</p>
    </footer>
  </body>
</html>
