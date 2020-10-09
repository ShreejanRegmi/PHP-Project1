<?php
session_start();//start of session for each user
require '../pdo/pdo.php';//importing pdo
require '../functions/functions.php';//importing functions from functions file
if(!isset($_SESSION['sessionID'])){//if user is not logged in
	header('Location:../loginpage.php');//redirect to loginpage
}
if(isset($_SESSION['sessionID'])){//is session is set
		checkAdmin();//check for admin
}
if(!isset($_GET['odid'])){//if odid variable is set in URL
	header('Location:listOrder.php?text= No products selected to be shipped');//redirect to listOrder.php
}

$selectprpstmt=$pdo->prepare("UPDATE tbl_order SET shipped_status='shipped' WHERE order_id=:odid");//query to update shipped status with restriction to order id
if($selectprpstmt->execute($_GET)){//if query is executed successfully 
	header('Location:listOrder.php?text=Item shipped successfully');//redirect to listOrder
}
else{
	header('Location:listOrder.php?text=Item not shipped');//redirect to listOrder with message
}
?>
