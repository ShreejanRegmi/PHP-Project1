<?php
session_start(); //session starts for each logged in user
require 'functions/functions.php'; //importing function from functions file
require 'pdo/pdo.php'; //importing pdo 
require 'header.php'; //importing header
if(!isset($_SESSION['sessionID'])){//if session not set
	header('Location:loginpage.php'); //redirect ot login page
}

if(!isset($_GET['cid'])){//if no cart id is in URL
	header('Location:listcartproducts.php?msg= No cart chosen');//redirect to listing cartproducts with msg
}
$cart_id=$_GET['cid']; //the cart id
$selectprpstmt=$pdo->prepare("SELECT p.title, p.image, p.price, c.quantity, c.shipped_address, c.cart_id #selecting rows
							  FROM tbl_products p #from tablename
							  JOIN tbl_cart c #joining another table
							  ON c.product_id=p.product_id #only rows with matching foreign keys are selected
							  WHERE c.cart_id=:cid"); //restriction to particular cart id
$selectprpstmt->execute($_GET);//executing above query with required data
$order=$selectprpstmt->fetch(); //assigning the data of query to order variable
$total_price=$order['price']*$order['quantity']; //finding total price
?>
<section></section>
<main>
	<h2>Invoice Page</h2>
	<h3><?php echo $order['title'] ?></h3> <!-- title of product is shown -->
	<img src="images/<?php echo $order['image']; ?>"/> <!-- image is displayed -->
	<br/>
	<label>Quantity :</label> <strong><?php echo $order['quantity']; ?></strong><br/><br/> <!-- quantity of ordered items  -->
	<label>Shipping address :</label> <strong><?php echo $order['shipped_address']; ?></strong><br/><br/> <!-- shipping address is displayed -->
	<label>Total charge :£</label> <strong id="total_price"><?php echo $order['price']*$order['quantity']; ?></strong><br/><br/> <!-- total price is displayed -->
	<a href="addorder.php?cid=<?php echo $order['cart_id']; ?>"><button style="background-color: lightblue; width: 200px; height: 100px; border-radius: 10px; font-size: 25px;">Pay on delivery</button></a> <!-- pay on delivery button -->
	<br/>
	<br/>
	<label>Order by PayPal:</label>
	<br/><br/>
	<?php require 'paypal.php'; ?> <!-- importing paypal functionalities -->
</main>
<?php
require 'aside.php'; //importing side bar
require 'footer.php'; //importing footer