<?php

session_start();

    $connection = mysqli_connect('localhost','root','','<DB_NAME');
    $timezone = date_default_timezone_set("Asia/Kolkata");
    $username = "";
    $email    = "";
    $errors = array(); 

    if (isset($_POST['reg_user'])) {
        
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password_1 = mysqli_real_escape_string($connection, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($connection, $_POST['password_2']);
      
        
        if (empty($username)) { array_push($errors, "Username is required"); }
        if(!preg_match("/^[A-Z,a-z]/",$username)){array_push($errors,"Invalid username");}
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password_1)) { array_push($errors, "Password is required"); }
        if ($password_1 != $password_2) {
          array_push($errors, "The two passwords do not match");
        }
      
       
        $user_check_query = "SELECT * FROM loginsignup WHERE username='$username' OR email='$email' LIMIT 1";
        $result = mysqli_query($connection, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        
        if ($user) { // if user exists
          if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
          }
      
          if ($user['email'] === $email) {
            array_push($errors, "email already exists");
          }
        }
      
      
        if (count($errors) == 0) {
            $password = md5($password_1);
            $query = "INSERT INTO loginsignup(id,username, email, password) 
                      VALUES('','$username', '$email', '$password')";
            mysqli_query($connection, $query);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.html');
        }
      }?>


      <html>
<head>

  <title>Register- Apple</title>
  <link rel="stylesheet" type="text/css" href="css/regLogin.css">
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
</head>
<body>
  

  <div id="uph">
       
       <img src="apple.png" width=30 height=30 style="padding:10px;" href="index.html"/>
       
       </div>

       <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="contact.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>
