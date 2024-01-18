<?php
session_start();



require_once "config.php";

$username = $name = $password ="";
$username_err=$name_err=$password_err=$register_err="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(empty(trim($_POST['username']))) {
    $username_err="username is required";
  }else{
    $username=trim($_POST['username']);
  }

  if(empty(trim($_POST["password"]))){
    $password_err="password is required";
  }else{
    $password=trim($_POST['password']);
  }
  
  if(empty(trim($_POST["name"]))){
   $name_err="name is required";
  }else{
    $name=trim($_POST['name']);
  }

  if(empty($username_err) && empty($password_err)&& empty($name_err)){
    $sql="SELECT id,username,name,password FROM users WHERE username=?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"s",$param_username);
    $param_username=$username;

    if(mysqli_stmt_execute($stmt))
    {
      mysqli_stmt_store_result($stmt);
      if(mysqli_stmt_num_rows($stmt)==1)
      {
        mysqli_stmt_bind_result($stmt,$id,$username,$name,$hashed_password);
        if(mysqli_stmt_fetch($stmt))
        {
          if(password_verify($password,$hashed_password))
          {
            session_start();
            $_SESSION["username"]=$username;
            $_SESSION["name"]=$name;
            $_SESSION["id"]=$id;
            $_SESSION["loggedin"]=true;

            header("location:welcome.php");

          }else{
            $password_err="passsword is incorrect";
            echo $password_err;
          }
        }
      }
      else{
        $register_err="you have not yet registered plese register!";
      }
    }
  }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP LOGIN SYSTEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-right-to-bracket"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="#">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container mt-3">
        <h2>Login Form</h2>
        <hr>
        <form class="col g-2 mt-3" action="" method="POST">
          <div class="col-md-5">
            <label for="username" class="form-label">username</label>
            <input type="text" class="form-control is-valid" id="username"  name="username" value="<?php echo $username;?>">
            <div class="valid-feedback">
                <span class="error"><?php echo $username_err;?></span>
            </div>
          </div><br>
          <div class="col-md-5">
              <label for="name" class="form-label">name</label>
              <input type="text" class="form-control is-valid" id="name"  name="name" value="<?php echo $name;?>">
              <div class="valid-feedback">
                <span class="error"><?php echo $name_err;?></span>
              </div>
          </div><br>
          <div class="col-md-5">
            <label for="password" class="form-label">Password</label>
            <div class="input-group has-validation">
              <input type="password" class="form-control is-invalid" id="password" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" name="password" value="<?php echo $password;?>" >
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
                  <span class="error"><?php echo $password_err;?></span>
              </div>
            </div>
          </div><br>
          <div class="col-12">
            <button class="btn btn-primary" type="submit">Login</button>
          </div>
        </form><br>
        <?php
          echo "<b>$register_err</b>";
        ?>
    </div>
    <script src="https://kit.fontawesome.com/ef7a3fcd6b.js" crossorigin="anonymous"></script>
</body>
</html>