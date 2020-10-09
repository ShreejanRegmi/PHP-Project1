<?php
//following function is for getting the path of the file
//reference:http://blog.chapagain.com.np/php-how-to-get-main-or-base-url/
function getSiteBaseUrl() {
	//base folder and file name is stored
    $userCurrentPath = $_SERVER['PHP_SELF'];
    //arrary is stored for the basename and filename 
    $userPathInfo = pathinfo($userCurrentPath); 
    //for the project: localhost
    $userHostName = $_SERVER['HTTP_HOST'];
    //protocol is chosen. Here: http:// 
    $URLprotocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';   
    //returns full path of the directory of the file
    return $URLprotocol.$userHostName.$userPathInfo['dirname']."/";
}

//function is called when user should be registered
function registerUser(){
	global $pdo; //pdo is made global
	if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){//if the input email is not in email format
		$_GET['text']='Invalid email format'; //echo error message
		return;
	}
	if($_POST['password']!=$_POST['confirmpassword']){//if confirmation password does not match
		$_GET['text']='Confirmation password does not match'; //echo error message
		return;
	}
	//query for insertion into tbl_users for selected columns
	$selectprpstmt=$pdo->prepare("INSERT INTO tbl_users(firstname, lastname, email, username, password, user_type) VALUES (:firstname, :lastname, :email, :username, :password, :user_type)");	
		$credentials=[
			'firstname'=>$_POST['firstname'],//value for firstname
			'lastname'=>$_POST['lastname'],//value for lastname
			'email'=>$_POST['email'],//value for email
			'username'=>$_POST['username'],//value for username
			'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT),//hashed password is stored
			'user_type'=>'user'//defining default user type
		];
		if($selectprpstmt->execute($credentials)){ //if execution of above query is succesful
			$_GET['text']='Registered successfully'; //corresponding message is shown
		}
		else{
			$_GET['text']='Something wrong! Please try again with valid credentials OR the username should be unique'; //corresponding message is shown
		}
}

//below function is called when user needs to log in
function login(){
	global $pdo;//making pdo global
	$selectprpstmt= $pdo->prepare("SELECT * FROM tbl_users WHERE username=:username");//quering all data from tbl_users where username is matching
	$credentials=[
		'username'=>$_POST['username'] //username value is set
	];
	$selectprpstmt->execute($credentials); //execution of query
	if($selectprpstmt->rowCount()>0){ //if at least 1 row is returned
		$row=$selectprpstmt->fetch(); //data is assigned to row variable
		if(password_verify($_POST['password'], $row['password'])){ //matching of password is checked
			$_SESSION['sessionID']=$row['user_id']; //sessionID variable of session is set with current user's id
			header("Location:index.php"); //header to homepage
		}
		else{
			echo '<h5>Password is incorrect</h5>'; //error message is shown
			return;
		}
	}
	else{
		echo '<h5>Username is incorrect</h5>';//error message is shown
	}
}

//following function is called when product should be added
function addProduct(){
	global $pdo;//global pdo
	//start of code for image upload
	$filetarget="../images/".basename($_FILES['photo']['name']) ; //sets the path where the image should be uploaded 
	//end of code for image upload
	//query to insert into product table with selected values
	$selectprpstmt= $pdo->prepare("INSERT INTO tbl_products(title, price, manufacturer, description, is_featured, image, category_id, user_id) VALUES (:title, :price, :manufacturer, :description, :featured, :photo, :category_id,  :user_id)");
	$credentials=[
		'title'=>$_POST['title'], //setting the value for title
		'price'=>$_POST['price'],//setting the value for price
		'manufacturer'=>$_POST['manufacturer'],//setting the value for manufacturer
		'description'=>$_POST['description'],//setting the value for description
		'featured'=>$_POST['featured'],//setting the value for featured
		'category_id'=> $_POST['categoryname'],//setting the value for category name
		'user_id'=>$_SESSION['sessionID'],//setting the value for user id
		'photo'=>$_FILES['photo']['name']//filename of image is stored in database
	];
	if($selectprpstmt->execute($credentials)){//if execution of statement successful
		$_GET['text'] ='Product added successfully'; //corresponding message is shown
	}
	else{
		$_GET['text']='Insertion failed';//corresponding message is shown
	}
	if(move_uploaded_file($_FILES['photo']['tmp_name'], $filetarget)){ //if photo is added
		$_GET['text']='Product and image added successfully';//corresponding message is shown
	}
	else{
		$_GET['text']= 'Image not uploaded';//corresponding message is shown
	}

}

//following function is called when category should be added
function addCategory(){
	global $pdo;//pdo is made global
	$selectprpstmt=$pdo->prepare("INSERT INTO tbl_categories(category_name) VALUES (:category_name)");//insert query for categories
	$credentials=[
		'category_name'=>$_POST['categoryname']//value is set for category name
	];
	if($selectprpstmt->execute($credentials)){//if query execution is successful
		$_GET['text']='Category added successfully';//corresponding message is shown
	}
	else{
		$_GET['text']='Category addition failed';//corresponding message is shown
	}
}
//following function is called when a non-admin user should be redirected to his/her homepage
function checkAdmin(){
	global $pdo;//pdo is made global
	$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_users WHERE user_id=:sessionID");//quering users table
	$credentials=[
		'sessionID'=>$_SESSION['sessionID']//value is set for user id
	];
	$selectprpstmt->execute($credentials);//execution of query
	$row=$selectprpstmt->fetch();//data is assigned to row variable
	if($row['user_type']!='admin'){ //if user is not admin
	 	header("Location:../index.php?msg=You should have admin rights to view backend");//user is redirected back to their homepage
	 }
}
//following function is called when boolean value for checking of admin is required
function booleanAdmin(){
	global $pdo;//making pdo global
	$bool=false;//setting default flag
	$selectprpstmt=$pdo->prepare("SELECT * FROM tbl_users WHERE user_id=:sessionID");//quering tbl_users with restriction to user id
	$credentials=[
		'sessionID'=>$_SESSION['sessionID']//user id value is set
	];
	$selectprpstmt->execute($credentials); //query is executed
	$row=$selectprpstmt->fetch();//data is assigned to row variable
	if($row['user_type']=='admin'){ //if user is admin
	 	$bool=true;//true value assigned to bool
	 }	
	 return $bool;//bool is returned
}
?>	