<?php
//start of php code 
session_start(); //session of the logged in user is started until destroyed
session_unset(); //the variables set in session for the user is unset
session_destroy();// the session of the logged in user is destroyed
header("Location:loginpage.php"); //the user is redirected to login page
//end of php code
?>