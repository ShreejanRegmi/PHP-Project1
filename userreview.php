<?php
session_start();//for start of each user's session
require 'functions/functions.php';//importing functions from functions.php
require 'header.php';//imports code for header
require 'pdo/pdo.php';//importing code for pdo

$usergetstmt=$pdo->prepare("SELECT * FROM tbl_users WHERE user_id=:id");//returns a row from tbl_users where a user id is matching
$usergetstmt->execute($_GET);//the above code is executed with the value got from URL
$user=$usergetstmt->fetch();//the data from the above code containing database output is stored in user variable

if(isset($_SESSION['sessionID']) && booleanAdmin()==true){//checks if user is logged in and it is admin
	require 'admin/adminPanel.php';//if yes, adminpanel is imported
}
?>
<section></section>
<main>
	<h2>Reviews by <?php echo $user['firstname'].' '.$user['lastname']; ?></h2> <!-- echoes the user's firstname and lastname -->
<ul class="products userreviews"> <!-- inherits css from products class -->
	
<?php
if(!isset($_GET['id'])){//checks if no id variable in sent in URL
	echo '<h2>No user selected</h5>'; //echoes text
}
else if(isset($_GET['id'])){//this condition is executed if id variable is set in URL
	#selects columns to be displayed in resulting output
	$selectprpstmt=$pdo->prepare("SELECT r.review_text, r.review_date, p.title, p.product_id 
		FROM tbl_reviews r JOIN tbl_products p 			#joining table reviews and products
		ON r.product_id=p.product_id  		#only returns data if foreign key is set
		AND r.user_id=:id   #only returns selected rows with selected selected user id 
		AND r.review_status='approved'"); #returns only those rows with approved status of reviews
	$selectprpstmt->execute($_GET);//executes the above query with variable get from URL
	foreach ($selectprpstmt as $row) {
	echo '<li>';
	echo '<h3>Product: <a href="productpage.php?id='.$row['product_id'].'">'.$row['title'].'</a></h3>'; //sets the link for each product
	echo '<p>'.$row['review_text'].'</p>'; //displays review text
	echo '<div>Date :'.$row['review_date'].'</div>'; //displays date added
	echo '</li>';
	}
}
?>
</ul>
</main>
<?php
	require 'aside.php'; //imports code for sidebar that contains featured product
	require 'footer.php'; //imports code for footer
?>

