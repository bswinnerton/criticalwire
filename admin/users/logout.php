<?php
	ob_start();

	//Set correct title
	$current_title = &$usermang_title;
	$current_description = &$usermang_description;
	$current_page = 'home';
	
	//Header information
	include("../../include/header.php");


	if(isset($_COOKIE['cw_username'])) {
		$username = $_COOKIE['cw_username'];
		$password = $_COOKIE['cw_password'];

		//this makes the time in the past to destroy the cookie
		setcookie(cw_username, "", time() - 3600*25, "/", ".criticalwire.com");
		setcookie(cw_password, "", time() - 3600*25, "/", ".criticalwire.com");
?>


		<div id="row1">
			<div id="generalarea">
				<p>You have been successfully logged out.</p>
			</div>
		</div>


<?php
	}
	else die("<div id=\"row1\"><div id=\"generalarea\"><p>You're not logged in</p></div></div>");
	
	ob_flush();
	include("../../include/footer.php");
?>