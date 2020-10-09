<?php
session_start(); //for start of each user's session
require 'functions/functions.php'; //importing functions from functions file
require 'pdo/pdo.php'; //importing pdo from pdo file
require 'header.php'; //importing heaeder from header file
require 'admin/generateTable.php'; //imports GenerateTable class from generateTable php file
if(!isset($_SESSION['sessionID'])){ //if user not logged in
	header('Location:loginpage.php'); //user is redirected to loginpage
}
?>
<section></section>
<main style="margin-bottom: 23.3%;">
	<?php
		if(isset($_GET['msg'])){//if required variable is set in URL
			echo '<h5>'.$_GET['msg'].'</h5>';//the value in the variable is echoed
		}
	?>
	<h2>Products in cart</h2>
	<?php
		$tableobject=new GenerateTable();//creating a new table generator object
		$selectprpstmt=$pdo->prepare("SELECT c.cart_id, p.title, c.shipped_address, c.quantity, p.price #selecting rows to be projected
			FROM tbl_cart c JOIN tbl_products p #joining tables cart and products
			ON c.product_id=p.product_id #only matching foreign keys are selected
		 	AND c.user_id=:sessionID"); //query is restricted to user_id column
		$credentials=[
			'sessionID'=>$_SESSION['sessionID'] //setting required variables for array
		];
		$selectprpstmt->execute($credentials);//executing above query with required data
		
		$tableobject->setTableHeadings(['ID', 'Product', 'Shipping address', 'Quantity' , 'Total Price(£)','Available Action']); //setting the required headings of table
		foreach ($selectprpstmt as $row){ //setting the output of query in row variable in each iteration
			$row['price']=$row['price']*$row['quantity'];//to find the total price
			$additionalcode='<td><a href="cancelcart.php?cid='.$row['cart_id'].'">Cancel</a>&nbsp;<a href="invoice.php?cid='.$row['cart_id'].'">Proceed to checkout</a></td>'; //code for adding a new column called action
			$tableobject->addRowRequirement($additionalcode);//passing arguments
			$tableobject->addTableRow($row);//passing arguments to table generator
		}
		echo $tableobject->getTableHTML();//echoes the whole table HTML elements
	?>
	<br/>
	<br/>
	<h2>Products Ordered</h2>
	<?php
		$ordertableobject=new GenerateTable();//creating a new table generator object
		$selectorderstmt=$pdo->prepare("SELECT o.order_id, p.title, o.shipped_address, o.quantity, p.price, o.shipped_status #selecting rows to be projected
			FROM tbl_order o JOIN tbl_products p #joining tables order and products 
			ON o.product_id=p.product_id #only matching foreign keys are selected
		 	AND o.user_id=:sessionID"); //query is restricte to user id column
		$credentials=[
			'sessionID'=>$_SESSION['sessionID'] //setting required variable for array
		]; 
		$selectorderstmt->execute($credentials); //executing above query with required data
		$ordertableobject->setTableHeadings(['ID', 'Product', 'Shipping address', 'Quantity' , 'Total Price(£)','Shipped Status']); //setting the required headings of table
		foreach ($selectorderstmt as $row){ //setting the output of query in row variable
			$ordertableobject->addRowRequirement(''); //no arguments passed 
			$row['price']=$row['price']*$row['quantity']; //for finding the total price
			$ordertableobject->addTableRow($row);	//passing arguments to table generator
		}
		echo $ordertableobject->getTableHTML(); //echoes the whole table elements
	?>
</main>
<?php
	require 'aside.php'; //importing aside bar for featured products
	require 'footer.php'; //imoorting footer
?>