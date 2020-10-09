<?php
session_start();//session is started for each user
require '../functions/functions.php';//importing functions from functions file
require '../header.php';//importing header
require 'adminPanel.php';//displays admin panel
require 'generateTable.php';//importing table generator class

if(!isset($_SESSION['sessionID'])){//if user is not logged in
	header('Location:../loginpage.php');//redirect to login page
}
if(isset($_SESSION['sessionID'])){//if user is logged in
		checkAdmin();//check for admin
}
?>
<section></section>
<main>
	<?php
		if(isset($_GET['text'])){//if text variable is set in url
			echo '<h5>'.$_GET['text'].'</h5>';//assigned text is displayed
		}
	?>
	<h2>Ship products in order</h2>
	<?php
		$tableobject=new GenerateTable();//creation of new table object
		$selectprpstmt=$pdo->prepare("SELECT o.order_id, p.title, o.shipped_address, o.quantity, p.price, u.firstname,u.lastname, o.shipped_status #selection of required columns
			FROM tbl_order o 
			JOIN tbl_products p #inner join of order and products table
			ON o.product_id=p.product_id #rows with only matching foreign keys are returned
			JOIN tbl_users u #inner join third table users
			ON o.user_id=u.user_id"); //rows with only matching foreign keys are returned
		$selectprpstmt->execute();//above query is executed

		$tableobject->setTableHeadings(['ID', 'Product', 'Shipped address', 'Quantity', 'Total price(£)' ,'Firstname', 'Lastname', 'Shipping Status','Action']);//sets the table headings
		foreach ($selectprpstmt as $row){//loops through each row output from query
			$row['price']=$row['price']*$row['quantity'];//calculates total price
			$additionalcode='';//sets default additional code
			if($row['shipped_status']=='not shipped'){//if shipped status is not shipped
				$additionalcode='<td><a href="approveOrder.php?odid='.$row['order_id'].'">Ship</a></td>';//display ship link	
			}
			$tableobject->addRowRequirement($additionalcode);//method of the object is called with argument
			$tableobject->addTableRow($row);//adds table data in table
		}
		echo $tableobject->getTableHTML();//echoes entire table html
	?>
</main>
<aside></aside>
<?php
	require '../footer.php';//imports footer
?>