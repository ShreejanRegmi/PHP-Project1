<?php
	session_start();//start of each user's session
	require 'pdo/pdo.php';//importing code for pdo
	if(isset($_SESSION['sessionID'])){ //if user is logged in
		$usergetstmt=$pdo->prepare("SELECT user_type FROM tbl_users WHERE user_id=:usid"); //quering user type column of tbl_users
		$credentials=[
			'usid'=>$_SESSION['sessionID']  //required variable for query is set
		];
		$usergetstmt->execute($credentials); //the query is executed with the variable 
		$userdata=$usergetstmt->fetch();//data from query is set to userdata variable
			if($userdata['user_type']!='admin'){ //if user is not admin
				header("Location:index.php?msg=You cannot register while being logged in");	//redirect user to homepage with mesage in URL
			}
		}
	require 'functions/functions.php'; //importing functions from functions file
	if(isset($_POST['register'])){ //if register user form is submitted
		registerUser(); //calls function registerUser from functions page
	}
?>

<?php
	if(isset($_SESSION['sessionID']) && booleanAdmin()==true){ //checks if session is set and the user is admin
	require 'admin/adminPanel.php'; //include admin panel
}
	require 'header.php'; //imports header
?>

<section></section>
<main>
	<?php
		if(isset($_GET['text'])){ //checks if text variable set in URL
			echo '<h5>'.$_GET['text'].'<h5>'; //echoes the text in URL to the page
		}
	?>
<h2>Register User</h2>
<form action="registeruser.php" method="POST"> <!-- form is submitted using POST method -->
	<label for="firstname">Firstname :</label> <input type="text" name="firstname" id="firstname" placeholder="eg: Dave"
	value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname']; } ?>" required/> <!-- input field for user's firstname with default value -->
	<label for="lastname">Lastname :</label> <input type="text" name="lastname" id="lastname" placeholder="eg: Smith" value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname']; } ?>" /><!-- input field for user's lastname with default value -->
	<label for="email">E-mail :</label><input type="text" name="email" id="email" placeholder="user@example.com"
	value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>" required/> <!-- input field for user's email with default value -->
	<label for="username">Username : </label><input type="text" name="username" id="username" placeholder="davesmith" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>" required><!-- input field for user's chosen username with default value -->
	<label for="password">Password :</label><input type="password" name="password" id="password" placeholder="******" value="<?php if(isset($_POST['password'])){ echo $_POST['password']; } ?>" required> <!-- input field for user's password -->
	<label for="confirmpassword">Confirm password :</label><input type="password" name="confirmpassword" id="confirmpassword" placeholder="******" value="<?php if(isset($_POST['confirmpassword'])){ echo $_POST['confirmpassword']; } ?>" required><!-- input field for confirmation of password -->
	<input type="submit" name="register" value="Register" /> <!-- submit button for form -->
</form>
</main>
<?php
	require 'aside.php';//importing sidebar for featured product
	require 'footer.php';//importing footer
?>