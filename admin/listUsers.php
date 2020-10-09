<?php
session_start();//session is started for each user
require '../pdo/pdo.php';//pdo is imported
require '../functions/functions.php';//importing functions from functions file
if(!isset($_SESSION['sessionID'])){//if user is not logged in
	header("Location:../loginpage.php");//redirect to login page
}

if(isset($_SESSION['sessionID'])){//if user if logged in
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
<h2>Users List</h2>
<?php
$tableobject= new GenerateTable();//creation of new table object
//projection of columns from tbl_users
$selectprpstmt=$pdo->prepare("SELECT user_id, firstname, lastname, email, username, user_type FROM tbl_users");
$selectprpstmt->execute();//above query is executed

$tableobject->setTableHeadings(['ID','Firstname', 'Lastname', 'Email', 'Username', 'Role', 'Function']);//sets the table headings
foreach ($selectprpstmt as $row) {//loops through each row output from query
	$additionalcode='<td><a href="editUsers.php?id='.$row['user_id'].'">Edit</a>&nbsp;<a href="deleteUsers.php?id='.$row['user_id'].'">Delete</a></td>';//addition code for function heading
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