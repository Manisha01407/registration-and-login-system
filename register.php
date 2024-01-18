<?php
require_once "config.php";

$username = $name = $password = $email = $conpassword = "";
$username_err=$name_err=$password_err=$email_err=$conpassword_err="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

  if(empty(trim($_POST["username"]))){
    $username_err="username is required";  
  }
  else{
    $sql="SELECT id FROM users WHERE username=?";
    $stmt=mysqli_prepare($conn,$sql);
    if($stmt){
      mysqli_stmt_bind_param($stmt,"s",$param_username);
      $param_username=trim($_POST["username"]);

      if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt)==1){
          $username_err="this username is already taken";
          
        }else{
          $username=$_POST["username"];
          if(!preg_match("/^[a-zA-Z0-9#@]*$/", $username)){
            $username_err = "Only letters and special characters(#,@,$,_) are allowed";
      
          }
        }
      }else{
        echo"somthing wrong";
      }
    }
  
  mysqli_stmt_close($stmt);
  }

  if(empty(trim($_POST["name"]))){
    $name_err="name is required"; 
    
  }
  else{
      $name=$_POST["name"];
      if (!preg_match("/^[a-zA-Z- ']*$/",$name)) {
        $name_err = "Only letters and white space allowed";
        
      }  
  }

  if (empty($_POST["email"])) {
    $email_err = "Email is required";
    
  } else {
    $email = trim($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
      
    }
  }

  if(empty(trim($_POST["password"]))){
    $password_err="password is required";  
    
  }else{
    $password=trim($_POST["password"]);
    if(!preg_match("/^[a-zA-Z- '!@#\$&_]*$/", $password)){
      $password_err = " password Only takes letters and white space and few spcial character('!@#$&_) are  allowed";
     
    }
  }

  if(empty(trim($_POST["confpass"]))){
    $conpassword_err="you need to conform password";
    
  }else{
    if(trim($_POST["password"]) !== trim($_POST["confpass"])){
      $conpassword_err = "password and confirm password should match"; 
      
    }
    $conpassword=trim($_POST["confpass"]);
  }

  if(empty($username_err) && empty($name_err) && empty($email_err) && empty($password_err)  && empty($conpassword_err)){
    $sql="INSERT INTO users (username,name,email,password) VALUES (?,?,?,?)";
    $stmt=mysqli_prepare($conn,$sql);
    if($stmt){
      mysqli_stmt_bind_param($stmt,"ssss",$param_username,$param_name,$param_email,$param_password);

      $param_username=$username;
      $param_name=$name;
      $param_email=$email;
      $param_password=password_hash($password,PASSWORD_DEFAULT);

      if(mysqli_stmt_execute($stmt)){
        header("location: login.php");
      }else{
        echo "something went wrong";
      }
    }
    mysqli_stmt_close($stmt);
  }
  mysqli_close($conn);
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
        <a class="navbar-brand" href="#"><i class="fa-solid fa-file-invoice"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="#">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container mt-3">
        <h2>Registration Form</h2>
        <hr>
        <form class="col g-2" action=""  method="post">
          <div class="col-md-6">
            <label for="user" class="form-label">Username</label>
            <input type="text" class="form-control is-invalid" id="user" name="username" value="<?php echo $username;?>">
            <div id="validationServer03Feedback" class="invalid-feedback">
                <span class="error"><?php echo $username_err;?></span>
            </div>
          </div>
          <br>
          <div class="col-md-6">
            <label for="nam" class="form-label">Name</label>
            <input type="text" class="form-control is-invalid"  id="nam" name="name" value="<?php echo $name;?>">
            <div id="validationServer03Feedback" class="invalid-feedback">
                <span class="error"><?php echo $name_err;?></span>
            </div>
          </div>
          <br>

          <div class="col-md-6">
            <label for="inpemail" class="form-label">Email</label>
            <div class="input-group has-validation">
              <input type="email" class="form-control is-invalid" id="inpemail"  name="email" value="<?php echo $email;?>">
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
                  <span class="error"><?php echo $email_err;?></span>
              </div>
            </div>
          </div>
          <br>

          <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <div class="input-group has-validation">
              <input type="password" class="form-control is-invalid" id="password" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" name="password" value="<?php echo $password;?>" >
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
                  <span class="error"><?php echo $password_err;?></span>
              </div>
            </div>
          </div><br>
          <div class="col-md-6">
            <label for="copass" class="form-label">Conform Password</label>
            <input type="password" class="form-control is-invalid"  id="copass" name="confpass" value="<?php echo $conpassword;?>">
            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                <span class="error"><?php echo $conpassword_err;?></span>
            </div>
          </div>
          <br>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/ef7a3fcd6b.js" crossorigin="anonymous"></script>
</body>
</html>