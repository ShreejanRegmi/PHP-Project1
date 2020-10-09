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
	<h2>Category List</h2>
	
	<?php
		$tableobject= new GenerateTable();//creation of new table object
		$selectprpstmt= $pdo->prepare("SELECT * FROM tbl_categories");//projection of all columns from tbl_categories
		$selectprpstmt->execute();//above query is executed

		$tableobject->setTableHeadings(['category_id', 'category_name', 'Function']);//sets the table headings
		foreach ($selectprpstmt as $row) {//loops through each row output from query
			$additionalcode='<td><a href="editCategory.php?id='.$row['category_id'].'">Edit</a>&nbsp;<a href="deleteCategory.php?id='.$row['category_id'].'">Delete</a></td>';//addition code for function heading
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

