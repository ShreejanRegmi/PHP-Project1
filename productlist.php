<?php
session_start(); // for start of individual user session
require 'pdo/pdo.php'; //importing the code for pdo
require 'functions/functions.php'; //importing the functions in functions file
require 'header.php'; //importing header from header file

//if product type is not set in the url redirect back to index page
if(!isset($_GET['id'])){
	header("Location:index.php?msg=No product type has been chosen");
}

if(isset($_SESSION['sessionID']) && booleanAdmin()==true){ //checks if session is set and the user is admin
	require 'admin/adminPanel.php'; //imports the panel for admin
}
$categorylist=$pdo->prepare("SELECT * FROM tbl_categories WHERE category_id=:id"); //quering tbl_categories with restriction to categoryid
$categorylist->execute($_GET);//executing the statement above with required data
$category=$categorylist->fetch();//assigning the row output from above code to category variable
?>
<section></section>
<main>
	<form class="rating" action="" method="POST"> <!-- form created to submit values to either sort by date or rating -->
		<input type="submit" name="sort_date" value="Sort by date">	 <!-- acts as button to sort by date -->
		<input type="submit" name="sort_rate" value="Sort by rating"> <!-- acts as button to sort by rate -->
	</form>
	
<h2><?php echo $category['category_name']; ?> list</h2> <!-- echoes category name on top -->

<ul class="products">
<?php
	if(isset($_POST['sort_date'])){ //if sort by date button is clicked
		unset($_POST['sort_rate']); //unset the value in sort_rate index of POST
		$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_products WHERE category_id=:category_id ORDER BY date_added DESC"); //quering tbl_products with restriction to category id and data is ordered by date added 		
	}
	else if(isset($_POST['sort_rate'])){ //if sort by rate button is clicked
		unset($_POST['sort_date']); //unset value in sort_date index of POST
		$selectprpstmt=$pdo->prepare("SELECT p.product_id, p.title, p.description, p.price,p.category_id #select rows to show
										FROM tbl_products p  
										LEFT JOIN tbl_reviews r #left join is used to show even the products that don't have ratings
										ON p.product_id=r.product_id #foreign key math restriction
										GROUP BY p.product_id #grouping by product id
										HAVING p.category_id=:category_id #restriction in category id
										ORDER BY AVG(r.rating) DESC #sort by average ratings of that product in descending order
										");

	}
	else{
		$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_products WHERE category_id=:category_id ORDER BY date_added DESC"); //default case if none of the buttons are clicked
	}
	$credentials=[
		'category_id'=>$_GET['id'] //setting the required value
	];
	$selectprpstmt->execute($credentials); //executing the statement with required data
	foreach($selectprpstmt as $row){ //assigning one row data to row variable in each iteration
	echo    '<li>';
	echo	'<h3><a href="productpage.php?id='.$row['product_id'].'">'.$row['title'].'</a></h3>'; //shows product title with hyperlink
	echo	'<p>'.$row['description'].'</p>'; //shows product description
	echo	'<div class="price">£'.$row['price'].'</div>'; //shows product price
	echo	'</li>';
	 }
?>

</ul>
<hr/>
</main>
<?php
 require 'aside.php'; //importing sidebar for featured content
 require 'footer.php'; //importing sidebar for footer
?>