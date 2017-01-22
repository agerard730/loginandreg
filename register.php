<?php
	ob_start();
	session_start();
	if( isset($_SESSION['users'])!="" ){
		header("Location: home.php");
	}
	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-signup']) ) {
		
		$first_name = trim($_POST['first_name']);
		$first_name = strip_tags($first_name);
		$first_name = htmlspecialchars($first_name);
		
		$last_name = trim($_POST['last_name']);
		$last_name = strip_tags($last_name);
		$last_name = htmlspecialchars($last_name);
		
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$password = trim($_POST['password']);
		$password = strip_tags($password);
		$password = htmlspecialchars($password);

		$cpassword = trim($_POST['cpassword']);
		$cpassword = strip_tags($cpassword);
		$cpassword = htmlspecialchars($cpassword);

		
		if (empty($first_name)) {
			$error = true;
			$first_nameError = "Please enter your first name.";
		} else if (strlen($first_name) < 3) {
			$error = true;
			$first_nameError = "Name must have at least 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$first_name)) {
			$error = true;
			$first_nameError = "Name must contain alphabets and space.";
		}
		
		if (empty($last_name)) {
			$error = true;
			$last_nameError = "Please enter your last name.";
		} else if (strlen($last_name) < 3) {
			$error = true;
			$last_nameError = "Name must have at least 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$last_name)) {
			$error = true;
			$last_nameError = "Name must contain alphabets and space.";
		}
		
		
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			
			$query = "SELECT email FROM users WHERE email='$email'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "Provided Email is already in use.";
			
			}
		}
		
		if (empty($password)){
			$error = true;
			$passwordError = "Please enter password.";
		} else if(strlen($password) < 6) {
			$error = true;
			$passwordError = "Password must have at least 6 characters.";
		}
		
		if($password != $cpassword) {
			$error = true;
			$cpasswordError = "Passwords don't match";
		}
		
		$password = hash('sha1', $password);
		
				
		if( !$error ) {
			
			$query = "INSERT INTO users(first_name,last_name,email,password) VALUES('$first_name','$last_name','$email','$password')";
			$res = mysql_query($query);
				
			if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($first_name);
				unset($last_name);
				unset($email);
				unset($password);
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
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
            	<h2 class="">Sign up</h2>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="first_name" class="form-control" placeholder="Enter First Name" maxlength="50" value="<?php echo $first_name ?>" />
                </div>
                <span class="text-danger"><?php echo $first_nameError; ?></span>
            </div>
            
			<div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" maxlength="50" value="<?php echo $last_name ?>" />
                </div>
                <span class="text-danger"><?php echo $last_nameError; ?></span>
            </div>
			
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="password" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passwordError; ?></span>
            </div>
            
			<div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="cpassword" class="form-control" placeholder="Confirm Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $cpasswordError; ?></span>
            </div>
			
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="index.php">Have an account? Log in here</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>