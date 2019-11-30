<?php
session_start();

$connection = mysqli_connect('localhost','root','','<DB_NAME>');
$timezone = date_default_timezone_set("Asia/Kolkata");
$username = "";
$email    = "";
$errors = array(); 

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM loginsignup WHERE username='$username' AND password='$password'";
        $results = mysqli_query($connection, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['success'] = "You are now logged in";
          header('location: index.html');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }
  
  ?>

   
<!DOCTYPE html>
<html>
<head>
  <title>Login- Apple</title>
  <style>
        #uph {
            display: block;
            background-color: #000000;
            width: 100%;
            position: sticky;
            top: 0px;
            left: 0px;
            z-index: 1;
        }

        #uph img {
            display: block;
            margin: auto;
        }
    </style>
  <link rel="stylesheet" type="text/css" href="css/regLogin.css">
</head>
<body>

<div id="uph">
       
       <img src="apple.png" width=30 height=30 style="padding:10px;" href="index.html"/>
       
       </div>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="contact.php">Sign up</a>
  	</p>
  </form>
</body>
</html>
