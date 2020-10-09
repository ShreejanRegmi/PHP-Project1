<?php
session_start();//start of each user's session
require 'functions/functions.php';//importing of functions
require 'pdo/pdo.php'; //importing pdo
require 'header.php'; //importing header
 
if(!isset($_SESSION['sessionID'])){ //if session is not set
	header('Location:loginpage.php'); //redirect to login page
}

if(isset($_POST['submit'])){ //if form is submitted
	$pid=$_POST['h-pid']; //setting the value
	$selectprpstmt=$pdo->prepare("INSERT INTO tbl_cart(user_id, product_id, shipped_address, quantity) VALUES (:user_id, :pid, :shipped_address, :quantity)"); //inserting data into selected columns in tbl_cart
	$credentials=[
		'user_id'=>$_SESSION['sessionID'], //user id is set from session id
		'pid'=>$_POST['h-pid'], //product id inserted from form data
		'shipped_address'=>$_POST['shipped_address'], //shipping address inserted from form data
		'quantity'=>$_POST['h-quantity'] //quantity inserted from form data
	];
	if($selectprpstmt->execute($credentials)){ //if above query executes successfully
		header("Location:productpage.php?id=$pid&msg=added successfully to cart"); //user is headed to product's page
	}
	else{
		echo '<h5>Unsuccessful to add to cart</h5>';//if not executed, error message is shown
	}	
}

?>
<main style="margin-bottom: 14%">
	<form action="" method="POST">
		<label>Enter shipping address:</label>
		<!-- hidden input for quantity -->
		<input type="hidden" name="h-quantity" value="<?php if(isset($_POST['quantity'])) echo $_POST['quantity']; ?>">
		<!-- hidden input for product id -->
		<input type="hidden" name="h-pid" value="<?php if(isset($_POST['pid'])) echo $_POST['pid']; ?>">
		<!--  input for shipping address -->
		<input type="text" name="shipped_address" required />
		<!-- submit button of the form -->
		<input type="submit" name="submit" value="Submit" />
	</form>
</main>

<?php
require 'footer.php';
?>