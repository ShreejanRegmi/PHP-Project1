<?php
session_start();//session is started for each user
require '../pdo/pdo.php';//importing pdo
require '../functions/functions.php';//importing functions from functions file
require 'generateForm.php';//form generator class is imported
	
if(!isset($_SESSION['sessionID'])){//if user is not logged in
	header("Location:../loginpage.php");//redirect to login page
}

if(isset($_SESSION['sessionID'])){//if user if logged in
	checkAdmin();//check for admin
}

if(isset($_POST['update'])){//if update form is submitted
	$selectprpstmt=$pdo->prepare("UPDATE tbl_categories SET category_name=:categoryname WHERE category_id=:id");//run update query for designated category
	unset($_POST['update']);//unset update index of post array
	if($selectprpstmt->execute($_POST)){//if query is executed successfully
		header('Location:listCategory.php?msg= Category updated successfully');//show success message
	}
	else{
		$_GET['text']='Category not updated';//show error message
	}

}
require 'adminPanel.php';//imports admin panel
require '../header.php';//imports header

if(isset($_GET['id'])){//if id is set in URL
	$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_categories WHERE category_id=:id");//quering tbl_categories with id restriction
	$selectprpstmt->execute($_GET);//executes above query
	$category=$selectprpstmt->fetch();//data is assigned to category variable
}
?>
<section></section>
<main>
	<?php
		if(isset($_GET['text'])){//if text is assigned in url
			echo '<h5>'.$_GET['text'].'</h5>';//the text is displayed
		}
	?>
	<h2>Edit Category</h2>
	<?php
		$formobject = new FormGenerator();//creating form generator object
		$formobject->setMethod('POST');//method of form is set
		$formobject->addText('Category Name:', 'categoryname', $category['category_name']);//input type text is added with default value
		$formobject->addSubmit('update', 'Update');//submit button is added
		$formobject->addHidden('id', $category['category_id']);//hidden input is added
		echo $formobject->getHTML();//html of the form is echoed
	?>
</main>
<aside></aside>
<?php
	require '../footer.php';//importing footer
?>