<?php
session_start();//start of each user's session
require 'pdo/pdo.php'; //importing pdo
if(!isset($_SESSION['sessionID'])){ //if session is not set
	header('Location:loginpage.php'); //heads to login page
}
if(!isset($_GET['cid'])){ //if no variable named cid in URL
	header('Location:listcartproducts.php?msg= No cart chosen'); //heads to cart contents page
}
$selectcartstmt=$pdo->prepare("SELECT * FROM tbl_cart WHERE cart_id=:cid");//quering carts table with restriction to cart_id
$selectcartstmt->execute($_GET);//executing above query with required variables
$cart=$selectcartstmt->fetch();//assigning query data to cart variable

$insertprpstmt=$pdo->prepare("INSERT INTO tbl_order(user_id, product_id, shipped_address, quantity, shipped_status) VALUES (:user_id, :product_id, :shipped_address, :quantity, :shipped_status)"); //insert query in selected columns in order table
$credentials=[
	'user_id'=>$cart['user_id'], //value for user id
	'product_id'=>$cart['product_id'], //value for product id
	'shipped_address'=>$cart['shipped_address'], //value for shipping address
	'quantity'=>$cart['quantity'], //value for quantity
	'shipped_status'=>'not shipped' //value for shipped status
];
if($insertprpstmt->execute($credentials)){ //if query execution is successful
	$deletequery=$pdo->prepare("DELETE FROM tbl_cart WHERE cart_id=:cid"); //delete the row from cart 
	$credentials=[
		'cid'=>$cart['cart_id'] //value for cart id
	];
	$deletequery->execute($credentials); //execute query
	header('Location:listcartproducts.php?msg=Product ordered successfully'); //redirection to cart contents
}
else{
	header('Location:listcartproducts.php?msg=product ordering unsuccessful');//redirection to cart contents
}
?>