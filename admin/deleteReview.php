<?php
session_start();//session is started for each user
require '../pdo/pdo.php';//importing pdo
require '../functions/functions.php';//importing functions from functions file
require '../header.php';//importing header
if(!isset($_SESSION['sessionID'])){//if session is not set
	header("Location:../loginpage.php");//header to login page
}

if(isset($_SESSION['sessionID'])){//if session is set
	checkAdmin();//admin privilege is checked
}

if(isset($_GET['id'])){//if id variable is set in url
	$selectprpstmt=$pdo->prepare("DELETE FROM tbl_reviews WHERE review_id=:id");//delete query to delete reviews
	if($selectprpstmt->execute($_GET)){//if query is executed successfully
		header('Location:listReview.php?msg=Review deletion successful');//redirected to review list with message
	}
	else{
		$_GET['msg']='Deletion of review unsuccessful'; //if not, error message is shown
	}
}

if(isset($_GET['msg'])){//if message variable is set inurl
		echo '<h5>'.$_GET['msg'].'</h5>';//assigned message is displayed
}

if(!isset($_GET['id'])){//if no id is set for deletion of product
		echo '<h5> No review selected for deletion </h5>';//error message is shown
}

require '../footer.php';//importing footer 

?>