<?php
session_start();//session is started for each user
require '../pdo/pdo.php';//pdo is imported
require '../functions/functions.php';//importing functions from functions file
require 'generateForm.php';//form generator class is imported
require '../header.php';//importing header
require 'adminPanel.php';//importing admin panel


if(!isset($_SESSION['sessionID'])){//if user is not logged in
	header("Location:../loginpage.php");//redirect to login page
}

if(isset($_SESSION['sessionID'])){//if user if logged in
	checkAdmin();//check for admin
}


//code to update user's information
if(isset($_POST['update'])){//if update form is submitted
	if(password_verify($_POST['oldpassword'], $_POST['password'])){//if old password matches with old password
		$userupdate=$pdo->prepare("UPDATE tbl_users SET firstname=:firstname, lastname=:lastname, email=:email, username=:username, password=:password WHERE user_id=:id");//query to update specified user with provided values
		$credentials=[
			'firstname'=>$_POST['firstname'],//value is set for firstname
			'lastname'=>$_POST['lastname'],//value is set for lastname
			'email'=>$_POST['email'],//value is set for email
			'username'=>$_POST['username'],//value is set for username
			'password'=>password_hash($_POST['newpassword'], PASSWORD_DEFAULT),//new password is stored in hash code
			'id'=>$_POST['id']//value is set for user id
		];
		if($userupdate->execute($credentials)){//if the query is executed successfully
			header('Location:listUsers.php?msg= User edited successfully');//success message
		}
		else{
			$_GET['text']='User information not updated';//error message
		}
	}
	else{
		header('Location:listUsers.php?msg= Old password does not match');//error message
		
	}
}


//code to update user to admin or change admin to user
if(isset($_POST['assign'])){//if change user type form is submitted
	if($_GET['id']==$_SESSION['sessionID']){//if the user to be edited is the admin logged in himself
		header('Location:listUsers.php?msg=You cannot edit yourself while staying in session');//error message
	}
	else{
		$roleupdate=$pdo->prepare("UPDATE tbl_users SET user_type=:user_type WHERE user_id=:userid");//query to update the user's role
		$credentials=[
			'user_type'=>$_POST['user_type'],//value is set for user type
			'userid'=>$_POST['userid']//value is set for user id
		];
		if($roleupdate->execute($credentials)){//if the query is successfully executed
			header('Location:listUsers.php?msg= User edited successfully');//success message
		}
		else{
			$_GET['text']= 'User information not updated';//error message
		}
	}
	

}

if(isset($_GET['id'])){//if user id is set in url
	$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_users WHERE user_id=:id");//quering tbl_users with user id
	$selectprpstmt->execute($_GET);//execution of above query
	$user=$selectprpstmt->fetch();//data is assigned to user variable
}

?>
<section></section>
<main>
	<?php
		if(isset($_GET['text'])){//if text variable is set in url
			echo '<h5>'.$_GET['text'].'</h5>';//echo its contents
		}
	?>
<h2>Edit User's Information</h2>
<?php 
$formforrole= new FormGenerator();//creating new FormGenerator object
$formforrole->setMethod('POST');//setting the method of form
$formforrole->addSelect('User role:', 'user_type');//adding select drop down for user role
$formforrole->addSelectDirectValue(['user', 'admin']);//setting values that can be selected as options
$formforrole->closeSelect();//closing select tag
$formforrole->addHidden('userid', $user['user_id']);//adding hidden input
$formforrole->addSubmit('assign', 'Assign');//adding submit button
echo $formforrole->getHTML();//echoes entires HTML code for form
?>

<hr/>
<?php
	$formobject= new FormGenerator();//creating new FormGenerator object
	$formobject->setMethod('POST');//setting the method of form
	$formobject->addText('Firstname :', 'firstname', $user['firstname']);//adding input type text for firstname
	$formobject->addText('Lastname :', 'lastname', $user['lastname']);//adding input type text for lastname
	$formobject->addEmail('E-mail :', 'email', $user['email']);//adding input type email
	$formobject->addText('Username :', 'username', $user['username']);//adding input type text for username
	$formobject->addPassword('Old Password :', 'oldpassword');//adding input type password
	$formobject->addPassword('New Password :', 'newpassword');//adding input type password
	$formobject->addHidden('id', $user['user_id']);//adding input type hidden for user id
	$formobject->addHidden('password', $user['password']);//adding hidden input for password
	$formobject->addSubmit('update', 'Update');//adding input type text for firstname
	echo $formobject->getHTML();//echoes entires HTML code for form
?>
</main>
<aside></aside>
<?php
	require '../footer.php';//importing footer
?>