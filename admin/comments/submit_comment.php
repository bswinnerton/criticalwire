<?php
	//Header information
	include("../../include/header.php");
	
	if(isset($_COOKIE['cw_username'])) {
		//Set variables from form data on comment fields
		$date = date('Y-m-d H:i:s');
		$postid = $_POST['postid'];
		$username = strtolower($_POST['username']);
		$ip = $_SERVER['REMOTE_ADDR'];
		$comment = mysql_real_escape_string($_POST['comment']);
		
		$query = mysql_query("SELECT user_id FROM users WHERE active=1 AND username = '$username'");
		$result = mysql_fetch_array($query);
		$userid = $result['user_id'];
		
		mysql_query("INSERT INTO comments (`date_posted`, `post_id`, `user_id`, `ip_address`, `comment`) VALUES ('$date', '$postid', '$userid', '$ip', '$comment')") or die(mysql_error());
		echo "<div id='row1'><div id='generalarea'><p>Your comment submission was successful, s u s s e s s, f u l susessful.<br /><br />Want to go <a href=\"javascript:history.back(-1);\">back</a>?</p></div></div>";
	}
	else {
		echo "You must be logged in to post a comment";
	};

	
	//Footer information
	include("../../include/footer.php");
?>