<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Candiez Café Admin</title>
    <link
      href="../node_modules/bootstrap/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="../view_scripts/api.js"></script>
  </head>
  <body class='<?php 
    if (isset($_SESSION['admin_user'])) {
      echo "bg-light d-flex flex-column min-vh-100";
    }
  ?>'>
    <div id="root"></div>
    <script src='<?php 
      echo (isset($_SESSION['admin_user']) 
        ? '../view_scripts/admin_script.js' 
        : 'login_page.js');
    ?>' defer></script>
  </body>
