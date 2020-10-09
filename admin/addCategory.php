<?php
	session_start();//session for each user
	require '../pdo/pdo.php';//importing pdo
	require '../functions/functions.php';//importing functions
	if(!isset($_SESSION['sessionID'])){//if session is not set
		header("Location:../loginpage.php");///redirect to login page
	}
	if(isset($_SESSION['sessionID'])){//if user is logged in
		checkAdmin();//check for admin
	}

	if (isset($_POST['addcategory'])){//if add category from is submitted
		addCategory();//function to add category is called
	}

	require '../header.php';//header is imported
	require 'adminPanel.php';//admin panel is shown
?>
<section></section>
<main>
	<?php
		if(isset($_GET['text'])){//if text variable is set in URL
			echo '<h5>'.$_GET['text'].'<h5>';//display its contents
		}
	?>
<h2>Add Category</h2>
<!-- form for addition of category -->
<form action="" method="POST">
	<label for="categoryname">Category Name:</label><input type="text" name="categoryname" id="categoryname" required /><!--  input field for category name -->
	<!-- submit button for form -->
	<input type="submit" name="addcategory" value="Add" /> 
</form>
</main>
<aside></aside>
<?php
	require '../footer.php'; //importing footer
?>