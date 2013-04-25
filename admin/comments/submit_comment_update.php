<?php
	//Header information
	include("../../include/header.php");


	if(isset($_COOKIE['cw_username'])) {
		//Set variables from form data on comment fields
		$act = $_GET['act'];
		$date = date('Y-m-d H:i:s');
		$postid = $_POST['postid'];
		$username = strtolower($_POST['username']);
		$ip = $_SERVER['REMOTE_ADDR'];
		$comment_id = $_GET['comment_id'];
		$comment = mysql_real_escape_string($_POST['comment']);
		
		$query = mysql_query("SELECT user_id FROM users WHERE active=1 AND username = '$username'");
		$result = mysql_fetch_array($query);
		$userid = $result['user_id'];
		
		if($act == "edit") {
			mysql_query("UPDATE comments SET date_modified='$date', ip_address='$ip', comment='$comment' WHERE comment_id='$comment_id'") or die(mysql_error());
			echo "<div id='row1'><div id='generalarea'><p>Your comment submission was successful, s u s s e s s, f u l susessful.<br /><br />Want to go <a href=\"javascript:history.back(-1);\">back</a>?</p></div></div>";
		}
		else if($act == "delete") {
			mysql_query("UPDATE comments SET date_modified='$date', ip_address='$ip', deleted='1' WHERE comment_id='$comment_id'") or die(mysql_error());
			echo "<div id='row1'><div id='generalarea'><p>Your comment submission was successful, s u s s e s s, f u l susessful.<br /><br />Want to go <a href=\"javascript:history.back(-1);\">back</a>?</p></div></div>";
		};
	else {
		echo "You must be logged in to update a comment";
	};
	
	//Footer information
	include("../../include/footer.php");
?>