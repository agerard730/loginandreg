<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	
	if( !isset($_SESSION['users']) ) {
		header("Location: index.php");
		exit;
	}
	
	$res= mysql_query("SELECT * FROM users WHERE id=".$_SESSION['users']);
	$usersRow= mysql_fetch_array($res);
	
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome <?php echo $usersRow['first_name']; ?> </title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
            <li><a href="section2.php">Section 2</a></li>
            <li  class="active"><a href="section3.php">Section 3</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $usersRow['first_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav> 

	<div id="wrapper">

	<div class="container">
    
    	<div class="page-header">
    	<h2>Welcome</h2>
    	</div>
        
        <div class="row">
        <div class="col-lg-12">
        <h3> 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
		Donec mattis, enim sit amet mattis malesuada, magna enim tempus justo, 
			eu auctor ligula turpis id ligula. 
		Quisque dictum venenatis augue pulvinar fringilla. 
		Nulla ultrices non arcu eu egestas. 
		Aliquam iaculis, turpis eget bibendum accumsan, tortor enim luctus lacus, 
			vel ultricies nulla lacus et arcu. 
		Nam hendrerit quam eu lacinia auctor. 
		Vestibulum et libero vehicula, porta risus eget, consequat mauris. 
		Nulla sed ex sodales, sollicitudin urna non, bibendum diam. 
		Sed sed volutpat urna. Ut facilisis nulla turpis, in ultricies magna scelerisque et. 
		</h3>
        </div>
        </div>
    
    </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?> 