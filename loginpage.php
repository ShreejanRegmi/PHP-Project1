<?php
session_start();//start of session of logged in user
if(isset($_SESSION['sessionID'])){ //if session is already set
	header("Location:index.php"); //redirect to homepage
}
require 'pdo/pdo.php'; //importing pdo variable from pdo file
require 'functions/functions.php'; //importing functions from functions file

if(isset($_POST['login'])){ //if login form is submitted
	login(); //calls function from functions page
}
?>

<head>
	<title>Ed's Electronics|Login</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="electronics.css"/>
	</head>
	<header>
			<h1>Ed's Electronics</h1>
			<ul>
				<li><a href="index.php">Home</a></li> <!-- link to homepage -->
				<li><a href="loginpage.php">Login</a> <!-- link to loginpage -->
					<ul>
						<li><a href="registeruser.php">Register</a></li> <!--dropdown link to register user page -->
					</ul>
				</li>
			</ul>
			<address>
				<p>We are open 9-5, 7 days a week. Call us on
					<strong>01604 11111</strong>
				</p>
			</address>
		</header>
	<div class="login"> 
	<?php
		if (isset($_GET['msg'])) {//if variable msg is set with data in the url
			echo '<article>'.$_GET['msg'].'<article>'; //Displaying of the message in the page
		}
	?>
	<form action="loginpage.php" method="POST"> <!-- form for login -->
		<!-- input field for username with placeholder -->
		<label for="username"><b>Username</b></label><br><input type="text" name="username" id="username" placeholder="eg: smith"><br><br>
		<!-- input field for password with placeholder -->
		<label for="password"><b>Password</b></label><br><input type="password" name="password" id="password" placeholder="*****"><br><br>
		<!-- submit button for form -->
		<input type="submit" name="login" value="Login">
	</form>
	<!-- link to register user -->
	<p>Not a user? Click here to <a href="registeruser.php" style="text-decoration: none; color: blue;"><b>REGISTER</b></a></p>
	</div>