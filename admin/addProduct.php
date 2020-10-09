<?php
	session_start();//session for each user is started
	require '../pdo/pdo.php';//importing pdo
	require '../functions/functions.php';//importing functions from functions file
	if(!isset($_SESSION['sessionID'])){//if user is not logged in
		header("Location:../loginpage.php");//redirect to login page
	}

	if(isset($_SESSION['sessionID'])){//if user is logged in
		checkAdmin();//check for admin
	}

	if(isset($_POST['add'])){//if add product form is submitted
		addProduct();//function is called
	}
?>
<?php
	require '../header.php';//importing header
	require 'adminPanel.php';//adminpanel is displayed
?>
<section></section>
<main>
	<?php
		if(isset($_GET['text'])){//if text variable is set in URL
			echo '<h5>'.$_GET['text'].'<h5>';//the contents of variable is displayed
		}
	?>
<h2 class="addproduct">Add Product</h2>
<!-- enctype is defined for upload of image -->
<form action="addProduct.php" method="POST" enctype="multipart/form-data">
	<!-- input for title of product -->
	<label for="title">Title :</label> <input type="text" name="title" id="title" placeholder="Eg: Sony Camera" required />
	<!-- input for price of product -->
	<label for="price">Price :</label> <input type="number" name="price" id="price" placeholder="Eg: 400" required/>
	<!-- input for manufacturer of product -->
	<label for="manufacturer">Manufacturer :</label> <input type="text" name="manufacturer" id="price" placeholder="Eg: Sony" required="" />
	<!-- input for description of product -->
	<label for="description">Description :</label><textarea name="description" id="description" placeholder="Type a description" required=""></textarea>
	<!-- input for category of product -->
	<label for="categoryname">Category name:</label>
	<!-- dropdown of available categories -->
	<select name="categoryname" id="categoryname">
		<?php
			$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_categories"); //quering all data from tbl_categories
			$selectprpstmt->execute();//execution of query
			foreach ($selectprpstmt as $row) {//data is assigned to row variable in each iteration
				echo '<option value="'.$row['category_id'].'">'.$row['category_name'].'</option>';//options are shown
				}
		?>
	</select>
	<!-- input for selecting if featured or not -->
	<label for="featured">Featured :</label>
	<!-- select drop down for featured -->
	<select name="featured" id="featured">
		<option value="no">no</option>
		<option value="yes">yes</option>
	</select>
	<label>Upload image:</label>
	<!-- input for image -->
	<input type="file" name="photo"/>
	<!-- submit button of form -->
	<input type="submit" name="add" value="Add"/>
</form>
</main>
<aside></aside>
<?php
	require '../footer.php';//importing footer
?>