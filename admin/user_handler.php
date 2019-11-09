<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require ('../db.php');
session_start();


if(isset($_POST['user_name']) && $_POST['user_name'] == "admin" && isset($_POST['pass']) 
   	&& $_POST['pass'] == "123") {

	$name = $_POST['user_name'];
	$_SESSION['user'] = $name;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL='admin.php'\" />";

}elseif(isset($_POST['logout'])){
    unset($_SESSION['user']);
    session_destroy();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL='index.php'\" />";
}else{
	header("location:index.php?msg=failed");
	//echo "<meta http-equiv=\"refresh\" content=\"0;URL='index.php'\" />";
}