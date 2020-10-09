<?php
session_start();//session of each user is started
require 'pdo/pdo.php';//importing the pdo variable from pdo file
require 'functions/functions.php';//importing functions from functions file
require 'header.php';//importing header from header file

if(!isset($_GET['id'])){ //checks if product id is defined in the URL through GET
	header("Location:index.php?msg=No product selected"); //if no, user is redirected to homepage
}

if(isset($_POST['post'])){ //checks if form is submitted for posting review
	if(!isset($_SESSION['sessionID'])){//checks if user is logged in
		header("Location:loginpage.php?msg=You need to log in to add a review");//if not, redirected to login page
	}
	$selectprpstmt=$pdo->prepare("INSERT INTO tbl_reviews(review_text, review_date, user_id, product_id, review_status, rating) VALUES (:reviewtext, CURRENT_TIMESTAMP,:user_id, :product_id, :review_status, :rating)"); //inserting values to defined row in tbl_reviews. current_timestamp inserts the date and time of addition of post 
	$credentials=[
		'reviewtext'=>$_POST['reviewtext'], //setting value from review text POST
		'user_id'=>$_SESSION['sessionID'],	//setting value from session ID POST
		'product_id'=>$_GET['id'],			//setting value from id got from URL
		'review_status'=>'unapproved',		//setting default value unapproved to review_status
		'rating'=>$_POST['rating']			//setting value from rating POST
	];
	if($selectprpstmt->execute($credentials)){ //if the statement is executed successfully
		echo '<p>Review posted. Awaiting moderation</p>'; //message is displayed
	}
	else{
		echo '<p>Review not posted</p>'; //if not, error message is displayed
	}
}
if(isset($_SESSION['sessionID']) && booleanAdmin()==true){ //checks if session is set and user is admin
	require 'admin/adminPanel.php'; //if yes, admin panel is imported
}

?>
<section></section>
<main>
<?php
	$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_products WHERE product_id=:id"); //quering tbl_produts with product id restriction
	$credentials=[
		'id'=>$_GET['id'] //setting value from URL variable 'id'
	];
	$selectprpstmt->execute($credentials); //executing the above query with value to variables 
	$row=$selectprpstmt->fetch(); //assigning the row output from above query as data to row variable
//if condition stats for showing message
	if(isset($_GET['msg'])){ //if value for msg variable is set in URL
		echo '<h5>'.$_GET['msg'].'</h5>'; //the message is displayed
	}
?>
<h2>Product Page</h2>

	<h3 style ="color:green;"><?php echo $row['title'] ?></h3> <!-- title of product is displayed -->
		<div id="image"> 
		<img src="images/<?php echo $row['image'];  ?>"/> <!-- code to display the image. image name got from database -->
		</div>
		<h4>Product details</h4>
			<p><?php echo $row['description'] ?></p> <!-- displays the product's description -->
		<br/>
		<br/>
		<form action="addtocart.php" method="POST"> <!-- form to add product to cart -->
			<label>Quantity :</label>
			<input style="width: 70px; height: 20px;" type="number" name="quantity" id="quantity" value="1"/>
			<input type="hidden" name="pid" value="<?php echo $row['product_id'] ?>" /> <!-- hidden input for product id -->
			<input type="submit" name="s-quantity" value="Add to cart" /> <!-- submit button for form -->
		</form>
		<h4>Product reviews</h4>
			<ul class="reviews">
				<?php
					//first select query to get the rows of the selected product list
					//quering all data from tbl_reviews with restriction to product id and review status
					$reviewgetstmt=$pdo->prepare("SELECT * FROM tbl_reviews WHERE product_id=:id AND review_status='approved'");
					$credentials=[
						'id'=>$_GET['id'] //setting value from URL variable id
					];
					$reviewgetstmt->execute($credentials);//executes the above query with required data 
					$link="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";//gets the current URL link 
					 // reference: http://chillyfacts.com/dynamic-facebook-share-button-php
					foreach ($reviewgetstmt as $review) {
						//for each review row got, firstname and lastname is got to show them in reviewers name
						//quering tbl_users with restriction to userid
						$usergetstmt=$pdo->prepare("SELECT user_id, firstname, lastname, email FROM tbl_users WHERE user_id=:user_id");
						$userid=[
							'user_id'=>$review['user_id'] //assigning value to required variable
						];
				   		$usergetstmt->execute($userid);//executing the query with required variables
				   		$user=$usergetstmt->fetch();	//assigning data of query output to user variable
				   		//and with echo in a loop, each review and user details is shown 
				   		echo '<li>';
						echo '<p>'.$review['review_text'].'</p>'; //echoes review text
						echo '<div class="details">'; 
						echo '<a href="userreview.php?id='.$user['user_id'].'"><strong>'.$user['firstname'].' '.$user['lastname'].'</strong></a>  
							<em>'.$user['email'].'</em>'; //user's firstname, lastname and email id is shown with link to his profile
						echo '<em>'.$review['review_date'].'</em>'; //review date is shown
						echo '<strong>Rating: '.$review['rating'].'/5</strong>'; //posted rating is shown
						echo '<iframe src="https://www.facebook.com/plugins/share_button.php?href='.$link.'&layout=button_count&size=small&mobile_iframe=true&width=88&height=20&appId" width="88" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>'; //facebook share button link
						echo '</div>'; 
						echo '</li>';
					}
				?>
			</ul>

			<h2>Add a review</h2>
			<form action="" method="POST"> 
				<label for="reviewtext">Review: </label>
				<textarea name="reviewtext" id="reviewtext" placeholder="Type a review.." required></textarea> <!-- textarea to type the review -->
				<label for="rating">Rate the product (upon 5) :</label>
				<select name="rating"> <!-- select drop down for user rating -->
					<option value="1">1</option><!-- option 1 -->
					<option value="2">2</option><!-- option 2 -->
					<option value="3">3</option><!-- option 3 -->
					<option value="4">4</option><!-- option 4 -->
					<option value="5">5</option><!-- option 5 -->
				</select>
				<input type="submit" name="post" value="Post"/> <!-- submit button for form -->
			</form>
</main>			
<?php
require 'aside.php'; //importing the code of sidebar for featured products
require 'footer.php'; //importing the code for footer
?>