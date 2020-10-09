<!doctype html>
<html>
	<head>
		<title>Ed's Electronics</title>
		<meta charset="utf-8" />
		<!-- code for including css file. The links is added according to folder of file -->
		<link rel="stylesheet" href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/admin/'){ echo '../';}  ?>electronics.css" />
		
		<!--using font awesome css reference: https://fontawesome.com/icons/shopping-cart?style=solid -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	</head>
	<body>
		<header>
			<h1>Ed's Electronics</h1>
			<ul>
				<!-- echoes the link to homepage according to file's folder -->
				<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/admin/'){ echo '../';}  ?>index.php">Home</a></li>
				<li>Products
					<ul>
						<?php
						//code for pdo to connect to database
						$pdo = new PDO('mysql:dbname=csy2028b; host=localhost', 'root', '');
						//returns all rows from tbl_categories
						$selectprpstmt = $pdo->prepare("SELECT * FROM tbl_categories");
						$selectprpstmt->execute();//executes the above query
							foreach ($selectprpstmt as $row) { //assigns each row from above query to row variable
								 if(getSiteBaseUrl()=='http://localhost/assignment/admin/'){ //checking the folder path of the file
								 	//echoes the link to category in each category name if the file is in admin folder
								 	echo '<li><a href="../productlist.php?id='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
								 }
								 else{
								 	//echoes the link to category in each category name if the file is in main directory
									echo '<li><a href="productlist.php?id='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
								 }
							}
						?>
					</ul>
				</li>
				<li>
					<?php
					if(isset($_SESSION['sessionID'])){//checks if user is logged in
						if(getSiteBaseUrl()=='http://localhost/assignment/admin/'){//checking if the header containing file is in admin folder
							echo '<a href="../logout.php">Logout</a>';//logout link is displayed on the header for files in admin folder
						}
						else
							echo '<a href="logout.php">Logout</a>';//else, login link is displayed on the header
					}
					else{
						echo '<a href="loginpage.php">Login</a>';//logout link is displayed on header for files in main directory
					}
					?>
					<ul>
						<!-- if header containing file is in admin folder then ../ is added for path management -->
						<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/admin/'){ echo '../';}  ?>registeruser.php">Register</a></li>
					</ul>
				</li>
			</ul>
			<address>
				<p>We are open 9-5, 7 days a week. Call us on
					<strong>01604 11111</strong>
				</p>
				<!-- if header containing file is in admin folder then ../ is added for path management -->
				<a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/admin/'){ echo '../';}  ?>listcartproducts.php"><i class="fas fa-shopping-cart" style="font-size: 30px;"></i></a>
			</address>
		</header>