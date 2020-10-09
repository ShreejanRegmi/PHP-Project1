<!-- start of code for admin panel -->
<div class="adminpanel">
<h2>Admin Panel</h2>
<img src="<?php if(getSiteBaseUrl()=='http://localhost/assignment/admin/'){ echo '../';}  ?>images/admin_icon.png"/><!-- admin icon -->
<ul>
	<li><b>Products</b>
		<ul>
			<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/'){ echo 'admin/';}  ?>listProduct.php">List/Modify Products</a></li> <!-- link for listing/editing product -->
			<!-- link for adding product -->
			<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/'){ echo 'admin/';}  ?>addProduct.php">Add Product</a>
		</ul>
	</li>
	<li><b>Categories</b>
		<ul>
			<!-- link for listing/editing categorys -->
			<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/'){ echo 'admin/';}  ?>listCategory.php">List/Modify Categories</a></li>
			<!-- link for adding category -->
			<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/'){ echo 'admin/';}  ?>addCategory.php">Add Category</a>
		</ul>
	</li>
	<li><b>Users</b>
		<ul>
			<!-- link for listing/editing users -->
			<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/'){ echo 'admin/';}  ?>listUsers.php">List/Modify Users</a></li>
			<!-- link for add user -->
			<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/admin/'){ echo '../';}  ?>registeruser.php">Add User</a>
		</ul>
	</li>
	<li><b>Reviews</b>
		<ul>
			<!-- link for listing/approving reviews -->
			<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/'){ echo 'admin/';}  ?>listReview.php">List/Approve Reviews</a></li>
		</ul>
	</li>
	<li><b>Orders</b>
		<ul>
			<!-- link for shipping orders -->
			<li><a href="<?php if(getSiteBaseUrl()=='http://localhost/assignment/'){ echo 'admin/';}  ?>listOrder.php">Ship Pending Products</a></li>
		</ul>
	</li>
</ul>
</div>