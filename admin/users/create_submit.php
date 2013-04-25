<?php
include("../../include/functions.php");
	
	//Connect to database
	db_connect();

	//Checks if there is a login cookie
	if(isset($_COOKIE['cw_username'])) {
		//if there is, it logs you in and directs you to the members page
		$username = $_COOKIE['cw_username'];
		$password = $_COOKIE['cw_password'];
		$check = mysql_query("SELECT * FROM users WHERE username = '$username'") or die(mysql_error());
		$info = mysql_fetch_array($check);
		if ($password != $info['password']) die('<p>Hmm, delete your cookies</p>');
		else echo "You're already logged in";
	}
	
	$username = $_POST['username'];
	// checks it against the database
	if (!get_magic_quotes_gpc()) $username = addslashes($_POST['username']);
	
	$check = mysql_query("SELECT username FROM users WHERE username = '$username'")or die(mysql_error());
	$info = mysql_fetch_array($check);
	
	//Gives error if user dosen't exist
	$user_rows = mysql_num_rows($check);
	if ($user_rows != 0) {
		echo "user_taken";
		exit();
	}
	
	$date = date('Y-m-d H:i:s');
	$realname = $_POST['realname'];
	$username = $_POST['username'];
	$password = stripslashes($_POST['password']);
	$email = $_POST['email'];
	$ip = $_SERVER['REMOTE_ADDR'];

	// now we insert it into the database
	mysql_query("INSERT INTO users (`date_joined`, `real_name`, `username`, `password`, `email`, `ip_address`) VALUES ('$date', '$realname', '$username', '$password', '$email', '$ip')") or die(mysql_error());

	echo "OK";
?>