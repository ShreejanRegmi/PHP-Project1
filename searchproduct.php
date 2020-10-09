 <?php
session_start();//for start of each user's session
require 'functions/functions.php';//importing functions from functions.php
require 'header.php';//importing code for header
require 'pdo/pdo.php';//importing code for pdo
?>
<section></section>
<main style="margin-bottom: 4%; ">
	<h2>Search results of: <?php echo $_POST['searchquery']; ?> </h2> <!-- echoes search query -->
	<ul class="products">
<?php
	$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_products WHERE title LIKE :searchquery ORDER BY date_added DESC"); //query to return all rows from tbl_products where title matched query ordered by date added
	$credentials=[
		'searchquery'=>'%'.$_POST['searchquery'].'%' //% should be used both at the start and end of search query
	];
	$selectprpstmt->execute($credentials); //execute query with array of values passed
	if($selectprpstmt->rowCount()>0){ //checks if at least one row is returned
		foreach ($selectprpstmt as $row) { //assigns data of each iteration to row variable
		echo'<li>';
		echo '<h3><a href="productpage.php?id='.$row['product_id'].'">'.$row['title'].'</a></h3>';//echoes link to product page for each product
		echo '<p>'.$row['description'].'</p>';//displays the description of product
		echo '<div class="price">£'.$row['price'].'</div>';//displays the price of product
		echo '</li>';
	 	}
	}
	else{//if no product matched with query
		echo '<h4>No product matched with query</h4>';
	}
?>
	</ul>
</main>
<?php
require 'aside.php';//importing code for sidebar
require 'footer.php';//importing code for footer
?>