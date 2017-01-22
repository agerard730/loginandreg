<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	
	if ( isset($_SESSION['users'])!="" ) {
		header("Location: home.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	
		
		
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$password = trim($_POST['password']);
		$password = strip_tags($password);
		$password = htmlspecialchars($password);
		
		
		if(empty($email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter a valid email address.";
		}
		
		if(empty($password)){
			$error = true;
			$passwordError = "Please enter your password.";
		}
		
		
		if (!$error) {
			
			$password = hash('sha1', $password); 
		
			$res=mysql_query("SELECT id, first_name, last_name, password FROM users WHERE email='$email'");
			$row=mysql_fetch_array($res);
			$count = mysql_num_rows($res);
			
			if( $count == 1 && $row['password']==$password ) {
				$_SESSION['users'] = $row['id'];
				header("Location: home.php");
			} else {
				$errMSG = "Email or Password may be incorrect. Please try again.";
			}
				
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

	<div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
    	<div class="col-md-12">
        
        	<div class="form-group">
            	<h2 class="">Log in</h2>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-danger">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="password" class="form-control" placeholder="Your Password" value="<?php echo $password; ?>" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passwordError; ?></span>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-login">Log In</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="register.php">No account yet? Sign up here</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>