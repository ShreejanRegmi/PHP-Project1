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
	if($_GET['id']==$_SESSION['sessionID']){//if the user to be deleted is logged in
		header('Location:listUsers.php?msg=You cannot delete yourself');//show error messaege
	}
	else if($_GET['id']==1){//if the user to be deleted is the main admin
		header('Location:listUsers.php?msg= You cannot delete main admin');//error message is shown
	}
	else{//if everything is okay
		$selectedprpstmt=$pdo->prepare("DELETE FROM tbl_users WHERE user_id=:id");//delete query is run for a user
		if($selectedprpstmt->execute($_GET)){//if query is executed successfully
			header("Location:listUsers.php?msg=User deleted successfully");//redirected to users list with message
		}
		else{
			$_GET['msg']='Deletion of user unsuccessful';//if not, error message is shown
		}
	}
	
}

if(isset($_GET['msg'])){//if message variable is set inurl
	echo '<h5>'.$_GET['msg'].'</h5>';//assigned message is displayed
}

if(!isset($_GET['id'])){//if no id is set for deletion of product
	echo '<h5>No user selected for deletion</h5>';//error message is shown
}

?>