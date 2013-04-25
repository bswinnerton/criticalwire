<?php
	include("../include/functions.php");
	db_connect();

  //Determine the area on both single post and multiple post display and display area in the navbar
  $area = determine_area();
  $current_page = $area;

	//Set correct title before header is called
	if(isset($_GET['id'])) {
	  $id = $_GET['id'];
	  $query = mysql_query("SELECT title, allow_comments FROM posts WHERE deleted!=1 AND id = '$id'");
	  $result = mysql_fetch_array($query);
	  $title = $result['title'];
	  mysql_close();
	};
	if(isset($_GET['act'])) $current_title = $title." | CriticalWire ".ucwords($area); 
	else $current_title = &${$area.'_title'};
	
	//Set description based on config.php and in the future metadata before header is called
	$current_description = &${$area.'_description'};
	
	//Set keywords based on a sql search based on id
	$keywords = determine_keywords();
	
	//Verify current user for comment settings
	$current_user = $_COOKIE['cw_username'];
	
	//Check to see if comments are allowed
	$allow_comments = $result['allow_comments'];

	//BBCode stuff
	require_once("../include/parser.php");
	$parser = new parser;
	
	//Header information
	include("../include/header.php");
?>

  <div id="row1">

	<?php
		/* To view only one post */
		if($_GET['act'] == "view") {
			echo "<div id=\"generalarea\">\n";
			$query = mysql_query("SELECT id, title, date_FORMAT(date_posted, '%M %e, %Y') AS date, author, keywords, content, categories, area FROM posts WHERE deleted!=1 AND id = '$id'");
			$result = mysql_fetch_array($query);
			
			//table mappings
			$id = $result['id'];
			$title = $result['title'];
			$date = $result['date'];
			$author = $result['author'];
			$parsed_content = nl2br($parser->p($result['content']));
			$keywords = $result['keywords'];
			$categories = strtolower($result['categories']);
			$row_area = strtolower($result['area']);

			//print the article starting with the title
			if(check_user_level() == 0 || check_user_level() == 1) { //title if user is logged in with special priveleges
				echo "<h2 id=\"singlepost\">$title - <a href=\"/admin/posts/edit.php?id=$id\">Edit</a></h2><hr />\n";
			}
			else { //title for the average user
				echo "<h2 id=\"singlepost\">$title</h2><hr />\n";
			};
			echo "<p class=\"posted_on\">by: <a class=\"author\" href=\"#\">$author</a> on $date</p><p class=\"posted_in\"> | Posted in: <a href=\"/$row_area/\">".ucwords($row_area)."</a> > <a href=\"/posts/$categories/\">".ucwords($categories)."</a></p><br /><br />\n<p>$parsed_content</p><br /><br /><br /><p class=\"keywords\">Keywords: $keywords</p><br /><br />\n";
			comment_list();
			comment_write();
	  }
		  
		/* To view multiple posts */  
		else {
			//set maximum posts per page from config.php
			if ($area == "none") $maxpp = $noarea_maxpp;
			else $maxpp = ${$area.'_maxpp'};
			
			/* Constructor -- determine the current page and set the limits, category, and date */
			$p = determine_page();
			$limits = ($p - 1) * $maxpp;
			$cat = $_GET['cat'];
			$days = $_GET['days'];
			
			//show right navigation column
			area_sort_bar();
			
			echo "<div id=\"area_column1_1\">";
		  
			/* Select the articles from database */
			//if category and area are passed from previous link
			if($area != "none" && isset($cat) && !isset($days)) {
				//pull from the database
				$query = mysql_query("SELECT id, title, author, content, categories, area, date_FORMAT(date_posted, '%M %e, %Y') AS date FROM posts WHERE deleted!=1 AND area = '$area' AND categories = '$cat' ORDER BY id DESC LIMIT $limits,$maxpp") or die(mysql_error());
				//set the total rows in the table
				$totalrows = mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE deleted!=1 AND categories = '$cat' AND area = '$area'"),0);
				//set the total number of pages (calculated result), math stuff...
				$totalpages = ceil($totalrows / $maxpp);		  
			}
			//if category and area are passed from previous link with a days parameter set
			else if($area != "none" && isset($cat) && isset($days)) {
				//pull from the database
				$query = mysql_query("SELECT id, title, author, content, categories, area, date_FORMAT(date_posted, '%M %e, %Y') AS date FROM posts WHERE deleted!=1 AND area = '$area' AND categories = '$cat' AND date_posted BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW() ORDER BY id DESC LIMIT $limits,$maxpp") or die(mysql_error());
				//set the total rows in the table
				$totalrows = mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE deleted!=1 AND categories = '$cat' AND area = '$area' AND date_posted BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW()"),0);
				//set the total number of pages (calculated result), math stuff...
				$totalpages = ceil($totalrows / $maxpp);		  
			}
			//if referred by category links on homepage
			else if($area == "none" && isset($cat) && !isset($days)) {
				//pull from the database
				$query = mysql_query("SELECT id, title, author, content, categories, area, date_FORMAT(date_posted, '%M %e, %Y') AS date FROM posts WHERE deleted!=1 AND categories = '$cat' ORDER BY id DESC LIMIT $limits,$maxpp") or die(mysql_error());
				//set the total rows in the table
				$totalrows = mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE deleted!=1 AND categories = '$cat' "),0);
				//set the total number of pages (calculated result), math stuff...
				$totalpages = ceil($totalrows / $maxpp);
			}
			//if referred by category links on homepage with days parameter set
			else if($area == "none" && isset($cat) && isset($days)) {
				//pull from the database
				$query = mysql_query("SELECT id, title, author, content, categories, area, date_FORMAT(date_posted, '%M %e, %Y') AS date FROM posts WHERE deleted!=1 AND categories = '$cat' AND date_posted BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW() ORDER BY id DESC LIMIT $limits,$maxpp") or die(mysql_error());
				//set the total rows in the table
				$totalrows = mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE deleted!=1 AND categories = '$cat' AND date_posted BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW()"),0);
				//set the total number of pages (calculated result), math stuff...
				$totalpages = ceil($totalrows / $maxpp);
			}
			//if area is set and no category was passed with days parameter is set
			else if($area != "none" && isset($days)) {
				//pull from the database
				$query = mysql_query("SELECT id, title, author, content, categories, area, date_FORMAT(date_posted, '%M %e, %Y') AS date FROM posts WHERE deleted!=1 AND area = '$area' AND date_posted BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW() ORDER BY id DESC LIMIT $limits,$maxpp") or die(mysql_error());
				//the total rows in the table
				$totalrows = mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE deleted!=1 AND area = '$area' AND date_posted BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW()"),0);
				//the total number of pages (calculated result), math stuff...
				$totalpages = ceil($totalrows / $maxpp);	
			}
			//if no area or category is passed but days parameter is set
			else if($area == "none" && !isset($cat) && isset($days)) {
				$area = "posts";
				//pull from the database
				$query = mysql_query("SELECT id, title, author, content, categories, area, date_FORMAT(date_posted, '%M %e, %Y') AS date FROM posts WHERE deleted!=1 AND date_posted BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW() ORDER BY id DESC LIMIT $limits,$maxpp") or die(mysql_error());
				//the total rows in the table
				$totalrows = mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE deleted!=1 AND date_posted BETWEEN DATE_SUB(NOW(), INTERVAL $days DAY) AND NOW()"),0);
				//the total number of pages (calculated result), math stuff...
				$totalpages = ceil($totalrows / $maxpp);
			}
			//if just area was passed
			else {
				//pull from the database
				$query = mysql_query("SELECT id, title, author, content, categories, area, date_FORMAT(date_posted, '%M %e, %Y') AS date FROM posts WHERE deleted!=1 AND area = '$area' ORDER BY id DESC LIMIT $limits,$maxpp") or die(mysql_error());
				//the total rows in the table
				$totalrows = mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE deleted!=1 AND area = '$area'"),0);
				//the total number of pages (calculated result), math stuff...
				$totalpages = ceil($totalrows / $maxpp);	
			};
			
			//table mappings
			while($result = mysql_fetch_array($query)) {
				$id = $result['id'];
				$title = $result['title'];
				$date = $result['date'];
				$author = $result['author'];
				$parsed_content = nl2br($parser->p($result['content']));
				$categories = strtolower($result['categories']);
				$row_area = strtolower($result['area']);
				
				//print the article starting with the title
				if(check_user_level() == 0 || check_user_level() == 1) { //title if user is logged in with special priveleges
					echo "<h2><a href=\"/posts/".$id."/".title_to_underscore($title)."\">".$title."</a> - <a href=\"/admin/posts/edit.php?id=$id\">Edit</a></h2><hr />\n";
				}
				else { //title for the average user
					echo "<h2><a href=\"/posts/".$id."/".title_to_underscore($title)."\">".$title."</a></h2><hr />\n";
				};
				echo "<p class=\"posted_on\">by: <a class=\"author\" href=\"#\">$author</a> on $date</p><p class=\"posted_in\"> | Posted in: <a href=\"/$row_area/\">".ucwords($row_area)."</a> > <a href=\"/posts/$categories/\">".ucwords($categories)."</a></p><br /><br />\n<p>$parsed_content</p>\n<br /><br /><br />";
			};
			
			//some preventative measures
			if($totalrows == 0) echo "There's no articles here yet, duh.";
			else if($totalrows < $maxpp) echo "</div>"; //end of area_column1_1
			else if($totalrows != 0) {
				echo "<br /><center><p>Page: ";
				
				//pagination links based on URL
				for($i = 1; $i <= $totalpages; $i++) {
					//if category is set
					if(isset($cat) && !isset($days)) {
						if($i == 1) {echo "<a href='/$area/".strtolower($cat)."'>$i</a>";}
						else {echo " | <a href='/$area/".strtolower($cat)."/page$i'>$i</a>";};
					}
					//if category is set with days parameter
					else if(isset($cat) && isset($days)) {
						if($i == 1) {echo "<a href='/$area/".strtolower($cat)."/".$days."days'>$i</a>";}
						else {echo " | <a href='/$area/".strtolower($cat)."/".$days."days/page$i'>$i</a>";};
					}
					//if just area is set with days parameter
					else if(!isset($cat) && isset($days)) {
						if($i == 1) {echo "<a href='/$area/".$days."days'>$i</a>";}
						else {echo " | <a href='/$area/".$days."days/page$i'>$i</a>";};
					}
					//if just date is set
					else if($area == "none" && !isset($cat) && isset($days)) {
						if($i == 1) {echo "<a href='/posts/".$days."days'>$i</a>";}
						else {echo " | <a href='/posts/".$days."days/page$i'>$i</a>";};
					}
					//if just area is set
					else {
						if($i == 1) {echo "<a href='/$area/'>$i</a>";}
						else {echo " | <a href='/$area/page$i'>$i</a>";};
					};
				};
				echo "</p></center><br /></div>";
			}
		};
	?>
	
</div>


<?php	
	include("../include/footer.php");
?>