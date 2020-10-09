<aside>
		<h1><a href="#">Featured Product</a></h1>
		<?php
			$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_products WHERE is_featured='yes'");//quering all data from tbl_products where products are featured
			$selectprpstmt->execute(); //executing above query
			foreach ($selectprpstmt as $row) { //each iteration value is assigned to row variable
				echo '<a style="color:white;" href="productpage.php?id='.$row['product_id'].'"><p><strong>'.$row['title'].'</strong></p>
				<p>'.$row['description'].'</p></a>';//displays the title with link, and description of product
			} 
		?>
</aside>
