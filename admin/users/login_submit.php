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

		$check = mysql_query("SELECT username, password FROM users WHERE username = '$username'")or die(mysql_error());
		$info = mysql_fetch_array($check);

		//Gives error if user dosen't exist
		$user_rows = mysql_num_rows($check);
		if ($user_rows == 0) {
			echo "no_user";
			exit();
		}
		
		$_POST['password'] = stripslashes($_POST['password']);

		//gives error if the password is wrong
		if ($_POST['password'] != $info['password']) {
			echo "wrong_password";
			exit();
		}
		else {
			// if login is ok then we add a cookie
			$username = stripslashes($_POST['username']);
			setcookie(cw_username, $_POST['username'], time() + 3600, "/", ".criticalwire.com");
			setcookie(cw_password, $_POST['password'], time() + 3600, "/", ".criticalwire.com");
			
			echo "authenticated";
		}
?>