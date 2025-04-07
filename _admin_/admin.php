<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Candiez Café Admin</title>
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../view_scripts/admin_script.js" defer></script> 
  </head>
  <body class="bg-light d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand text-white" href="#">Candiez Café Admin</a>
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
            <a class="nav-link text-white" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#menu">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#orders">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#settings">Settings</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 flex-grow-1" id="root">
      <!-- Content will be injected here by JavaScript -->
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
      &copy; 2023 Candiez Café Admin. All rights reserved.
    </footer>

  </body>
