<?php
	include("../../include/functions.php");
	db_connect();

  //Determine the area on both single post and multiple post display and display area in the navbar
  $area = determine_area();
  $current_page = $area;

	//Set correct title before header is called
	if(isset($_GET['id'])) {
	  $id = $_GET['id'];
	  $query = mysql_query("SELECT title FROM posts WHERE deleted!=1 AND id = '$id'");
	  $result = mysql_fetch_array($query);
	  $title = $result['title'];
	  mysql_close();
	};
	$current_title = $title." | CriticalWire ".ucwords($area);
	
	$comment_id_selected = $_GET['comment_id'];
	$act = $_GET['act'];
	$current_user = $_COOKIE['cw_username'];

	//BBCode stuff
	require_once("../../include/parser.php");
	$parser = new parser;
	
	//Header information
	include("../../include/header.php");
?>

  <div id="row1">

	<?php
		echo "<div id=\"generalarea\">\n";
		$query = mysql_query("SELECT id, title, date_FORMAT(date_posted, '%M %e, %Y') AS date, author, content, categories, area FROM posts WHERE deleted!=1 AND id = '$id'");
		$result = mysql_fetch_array($query);
		
		//table mappings
		$id = $result['id'];
		$title = $result['title'];
		$date = $result['date'];
		$author = $result['author'];
		$parsed_content = nl2br($parser->p($result['content']));
		$categories = strtolower($result['categories']);
		$row_area = strtolower($result['area']);

		//print the article starting with the title
		if(check_user_level() == 0 || check_user_level() == 1) { //title if user is logged in with special priveleges
			echo "<h2>$title - <a href=\"/admin/posts/edit.php?id=$id\">Edit</a></h2><hr />\n";
		}
		else { //title for the average user
			echo "<h2>$title</h2><hr />\n";
		};
		echo "<p class=\"posted_on\">by: <a class=\"author\" href=\"#\">$author</a> on $date</p><p class=\"posted_in\"> | Posted in: <a href=\"/$row_area/\">".ucwords($row_area)."</a> > <a href=\"/posts/$categories/\">".ucwords($categories)."</a></p><br /><br />\n<p>$parsed_content</p><br /><br /><br /><br />\n";
		comment_list();
		comment_write();
?>
	
</div>


<?php	
	include("../../include/footer.php");
?>