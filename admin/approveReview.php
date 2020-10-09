<?php
session_start();//session is started for each user
require '../pdo/pdo.php';//importing pdo
require '../functions/functions.php';//importing functions from functions file
require 'generateForm.php';//importing FormGenerator class
if(!isset($_SESSION['sessionID'])){//if session is not set
	header("Location:../loginpage.php");//header to login page
}

if(isset($_SESSION['sessionID'])){//if session is set
	checkAdmin();//admin privilege is checked
}

$selectprpstmt=$pdo->prepare("UPDATE tbl_reviews SET review_status='approved' WHERE review_id=:id");//update query to approve review for each review id
if($selectprpstmt->execute($_GET)){//if query is executed successfully
	header('Location:listReview.php?text=Review approved successfully');//redirected to reviews list
}
else{
	header('Location:listReview.php?text= Review not approved');//if not, redirect to review list with error message
}
?>