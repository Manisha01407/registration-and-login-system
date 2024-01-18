<?php

session_start();
if(!isset($_SESSION['loggedin'])|| $_SESSION['loggedin']!==true){
    header('location:login.php');
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-address-card"></i></a> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href=".welcome.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
          <span class="navbar-text">
            <a class="navbar-brand" href="#"><i class="fa-regular fa-user"></i></a>
          </span>
          <span class="navbar-text">
            <a href="#" class="nav-link"><?php echo "Welcome ".$_SESSION['name'] ?></a> 
          </span>
        </div>
      </div>
    </nav>
    <div class="container mt-3">
        <h1>welcome to home page!</h1><br>
    </div>
    <script src="https://kit.fontawesome.com/ef7a3fcd6b.js" crossorigin="anonymous"></script>
</body>
</html>