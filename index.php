<?php
session_start();//for start of each user's session
require 'pdo/pdo.php';//importing code for pdo
require 'functions/functions.php';//importing functions from functions.php file
require 'header.php';//imports code for header

if(isset($_SESSION['sessionID']) && booleanAdmin()==true){//if sesson is set and the user is admin
	require 'admin/adminPanel.php';//includes panel of admin
}
?>
		<section></section>
		<main>			
			<h1>Welcome to Ed's Electronics</h1>
			<p>We stock a large variety of electrical goods including phones, tvs, computers and games. Everything comes with at least a one year guarantee and free next day delivery.</p>
			<hr/>
			<?php
				if(!isset($_SESSION['sessionID'])){//if no user is logged in
			?>
					<p><i>You are not logged in please login by locating the login link in the header, or by clicking <a class="here" href="loginpage.php"><b>here</b></a></i></p> <!-- displayes message to log in -->
				<?php
			}
			?>
			<?php
			//checks if there is variable in URL
				if(isset($_GET['msg'])){//start of if condition		
					echo '<b>'.$_GET['msg'].'</b>';//the message is echoed in bold
				}//closing of if condition and php code
			?>
			<hr/>

			<h3>Search Product:<h3>
			<form action="searchproduct.php" method="POST"> <!-- form for searching of product linked to another php page through POST-->
				<input type="text" name="searchquery"/>	 <!-- input for search -->
				<input type="submit" name="search" value="Search"/>	<!-- submit button for form -->
			</form>
			<hr/>
			<ul class="products">
			<h2>All Products: </h2>
			<?php 
				$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_products");//returns all rows from tbl_products with all columns
				$selectprpstmt->execute();//executes the above statement
				foreach ($selectprpstmt as $product) {//one row from tbl_products is assigned to product variable in each iteration
					echo'<li>'; 
					echo '<h3><a href="productpage.php?id='.$product['product_id'].'">'.$product['title'].'</a></h3>'; //sets a link in product title
					echo '<img style="width:200px; height:150px;" src="images/'.$product['image'].'"/>';//displays the image of product
					echo '<p>'.$product['description'].'</p>';//displays product description
					echo '<div class="price">£'.$product['price'].'</div>';//displays product price
					echo '</li>';
				}
			?>
		</main>
<?php
	require 'aside.php';//imports code for sidebar that contains featured product
	require 'footer.php';//imports code for footer
?>