<?php
session_start();//start of each session of users
require 'pdo/pdo.php'; //importing pdo
require 'functions/functions.php'; //importing required functions
require 'header.php'; //importing header
if(!isset($_SESSION['sessionID'])){ //if session is not set
	header("Location:../loginpage.php"); //head to login page
} 
if(isset($_GET['cid'])){ //if cart id is set in URL
	$selectprpstmt=$pdo->prepare("DELETE FROM tbl_cart WHERE cart_id=:cid"); //delete query for cart
	if($selectprpstmt->execute($_GET)){ //above query is executed with required data
		header('Location:listcartproducts.php?msg=Item deletion from cart successful'); //deletion successful message
	}
	else{
		$_GET['msg']='Deletion of cart item unsuccessful'; //if deletion is unsuccessful
	}
}
if(isset($_GET['msg'])){//if any 'msg' variable is set in URL
		echo '<h5>'.$_GET['msg'].'</h5>'; //echo its content
}

if(!isset($_GET['id'])){ //if no cart id is present in URL
		echo '<h5> No review selected for deletion </h5>'; //display required content
}
require '../footer.php'; //importing footer
?>
?>