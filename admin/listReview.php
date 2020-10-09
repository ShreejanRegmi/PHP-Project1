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
		if(isset($_GET['text'])){//if text variable is set inurl
			echo '<h5>'.$_GET['text'].'</h5>';//assigned text is displayed
		}
	?>
	<h2>Reviews List</h2>
	<?php
	$tableobject= new GenerateTable();//creation of new table object
	$selectprpstmt=$pdo->prepare("SELECT r.review_id, r.review_text, r.review_date, u.firstname, u.lastname, p.title 
		FROM tbl_reviews r  #selection of required columns
		JOIN tbl_users u #inner join of reviews and users table
		ON r.user_id=u.user_id #rows with only matching foreign keys are returned
		JOIN tbl_products p  #inner join third table products
		ON r.product_id=p.product_id  #rows with only matching foreign keys are returned
		WHERE r.review_status='unapproved' #only reviews that are unapproved are displayed
		ORDER BY r.review_id"); //order by review id (small to largest)
	$selectprpstmt->execute();//above query is executed
	$tableobject->setTableHeadings(['ID', 'Review', 'Date posted', 'Firstname', 'Lastname', 'Product', 'Status']);//sets the table headings
	foreach ($selectprpstmt as $row) {//loops through each row output from query
		$additionalcode='<td><a href="approveReview.php?id='.$row['review_id'].'">Approve</a>&nbsp;<a href="deleteReview.php?id='.$row['review_id'].'">Delete</a></td>';//sets additional code
		$tableobject->addRowRequirement($additionalcode);//method of the object is called with argument
		$tableobject->addTablerow($row);//adds table data in table
	}
	echo $tableobject->getTableHTML();//echoes entire table html
	?>
</main>
<aside></aside>
<?php
	require '../footer.php';//imports footer
?>