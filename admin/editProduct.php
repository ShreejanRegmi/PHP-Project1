<?php
session_start();//session is started for each user
	require '../pdo/pdo.php';//pdo is imported
	require '../functions/functions.php';//importing functions from functions file
	require 'generateForm.php';//form generator class is imported
	if(!isset($_SESSION['sessionID'])){//if user is not logged in
		header("Location:../loginpage.php");//redirect to login page
	}

	if(isset($_SESSION['sessionID'])){//if user if logged in
		checkAdmin();//check for admin
	}

	if(isset($_POST['update'])){//if update form is submitted
		$filetarget="../images/".basename($_FILES['photo']['name']) ;//path to store image
		$productstmt=$pdo->prepare("UPDATE tbl_products SET title=:title, price=:price, manufacturer=:manufacturer, description=:description, category_id=:categoryname, is_featured=:featured, image=:photo WHERE product_id=:id");//update query for a specified product
		$credentials=[
			'title'=>$_POST['title'], //value is set for title
			'price'=>$_POST['price'],//value is set for price
			'manufacturer'=>$_POST['manufacturer'],//value is set for manufacturer
			'description'=>$_POST['description'], //value is set for description
			'categoryname'=>$_POST['categoryname'],//value is set for categoryname
			'featured'=>$_POST['featured'],//value is set for featured column
			'photo'=>$_FILES['photo']['name'],//name of image is set in database
			'id'=>$_POST['id']//value is set for product id
		];

		if(move_uploaded_file($_FILES['photo']['tmp_name'], $filetarget)){//if the image is moved to the specified folder
			echo '<h5>Product added successfully</h5>';//success message
		}
		else{
			header('Location:listProduct.php?msg= Image not uploaded');//error message
		}
		if($productstmt->execute($credentials)){//if the query is executed successfully
			header('Location:listProduct.php?msg= Product updated successfully');//success message
		}
		else{
			$_GET['text']='Product information not updated';//error message
		}
	}
	
	
	require '../header.php';//importing header
	require 'adminPanel.php';//shows admin panel
	
	if(isset($_GET['id'])){//if id variable is set in url
	$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_products WHERE product_id=:id");//quering tbl_products with restriction to product id
	$selectprpstmt->execute($_GET);//execution of above query with required data
	$product=$selectprpstmt->fetch();//assigning data from above query to product variable
}
?>
<section></section>
<main>
	<?php
		if(isset($_GET['text'])){//if text variable is set in url
			echo '<h5>'.$_GET['text'].'</h5>';//echo the content
		}
	?>
<h2>Edit Product</h2>
<?php
	$categorystmt=$pdo->prepare("SELECT * FROM tbl_categories");//quering all data from tbl_categories
	$categorystmt->execute();//execution of above query
	$formobject= new FormGenerator();//creation of form generator object
	$formobject->setMethodEnc('POST', 'multipart/form-data');//assigning enctype and method for from
	$formobject->addText('Title :', 'title', $product['title']);//adding input text type for title
	$formobject->addText('Price :', 'price', $product['price']);//adding input type text for price
	$formobject->addText('Manufacturer :', 'manufacturer', $product['manufacturer']);//adding input type text for manufacturer
	$formobject->addTextArea('Description :', 'description', $product['description']);//adding input type textarea for descripition
	$formobject->addSelect('Category name:', 'categoryname');//select drop down for selecting category
	foreach ($categorystmt as $row) {//value is assigned to row variable in each iteration
		$formobject->addSelectValue($row);//method of formobject is called with argument
	}
	$formobject->closeSelect();//closing of select tag
	$formobject->addSelect('Featured :', 'featured');//select drop down for selecting category
	$formobject->addSelectDirectValue(['no', 'yes']);//setting the options for select featured
	$formobject->closeSelect();//closing of select tag
	$formobject->addImage('Upload Image :', 'photo');//input for file type for image
	$formobject->addHidden('id', $product['product_id']);//hidden input for id
	$formobject->addSubmit('update', 'Update');//submit button for form
	echo $formobject->getHTML();//echoes entire html code for form
?>
 </main>
 <aside></aside>
<?php
	require '../footer.php';//importing footer
?>