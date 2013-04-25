<?php
	//Set correct title & meta description
	$current_title = &$submitted_title;
	$current_description = &$submitted_description;
	$current_page = 'home';				//Proper uses: home, blog, news, reviews, websolutions, aboutus
	
	//Header information
	include("../../include/header.php");
	
	
	//Set variables from form data on edit/index.php
	$date = date('Y-m-d H:i:s');
	$author = mysql_real_escape_string($_POST['author']);
	$title = mysql_real_escape_string($_POST['title']);
	$area_select = $_POST['area_select'];
	$disclude_categories = $_POST['disclude_categories'];
	$theloop = $_POST['theloop'];
	$keywords = mysql_real_escape_string($_POST['keywords']);
	$content = mysql_real_escape_string($_POST['content']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$category_check = $_POST['categories'];
	$allow_comments = $_POST['allow_comments'];
  
	$categories = checkbox_to_string();
	checkbox_to_bool();
	
	db_submit();
	
	
	//Footer information
	include("../../include/footer.php");

?>