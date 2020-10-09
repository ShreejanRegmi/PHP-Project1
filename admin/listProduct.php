<?php
	session_start();//session is started for each user
	require '../pdo/pdo.php';//pdo is imported
	require '../functions/functions.php';//importing functions from functions file
	if(!isset($_SESSION['sessionID'])){//if user is not logged in
		header("Location:../loginpage.php");//redirect to login page
	}

	if(isset($_SESSION['sessionID'])){//if user is logged in
		checkAdmin();//check for admin
	}
	require 'generateTable.php';//importing table generator class
	require '../header.php';//importing header
	require 'adminPanel.php';//displays admin panel
?>
<section></section>
<main>
	<?php
		if(isset($_GET['msg'])){//if message variable is set inurl
			echo '<h5>'.$_GET['msg'].'</h5>';//assigned message is displayed
		}
	?>
	<h2>Product List</h2>
	<?php
	$tableobject= new GenerateTable();//creation of new table object
	$selectprpstmt= $pdo->prepare("SELECT p.product_id,p.title,p.price,p.manufacturer,p.description,p.is_featured,p.date_added, p.image, u.firstname, c.category_name  #selection of required columns
	 FROM tbl_products p JOIN tbl_categories c  #inner join of categories and products table
	 ON p.category_id=c.category_id #rows with only matching foreign keys are returned
	 JOIN tbl_users u #inner join third table users
	 ON p.user_id=u.user_id"); //rows with only matching foreign keys are returned
	$selectprpstmt->execute();//above query is executed

	$tableobject->setTableHeadings(['ID' ,'Title', 'Price (£)', 'Manufacturer', 'Description', 'Featured' , 'Added on', 'Image', 'Added by','Category', 'Function']);//sets the table headings
	foreach ($selectprpstmt as $row) {//loops through each row output from query
	$additionalcode='<td><a href="editProduct.php?id='.$row['product_id'].'">Edit</a>&nbsp;<a href="deleteProduct.php?id='.$row['product_id'].'">Delete</a></td>';//sets additional code
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