<?php
  include("config.php");
  
  
  /* Used to convert the selected category checkboxes into a string */
  function checkbox_to_string() 
  {
    global $category_check, $category;
    if (!empty($category_check)) {
      foreach ($category_check as $category) {$source .= $category.", ";}
    };
    $categories = substr($source, 0, -2);
    return $categories;
  };
  
  
  /* Used to convert selected checkboxes to boolean characters (0|1) */
  function checkbox_to_bool() 
  {
    global $_POST, $theloop, $disclude_categories, $allow_comments;
    if (isset($_POST['disclude_categories'])) {$disclude_categories = '1';} else {$disclude_categories = '0';};
    if (isset($_POST['theloop'])) {$theloop = '1';} else {$theloop = '0';};
    if (isset($_POST['allow_comments'])) {$allow_comments = '1';} else {$allow_comments = '0';};
  };
  
  
  /* Connect to the SQL database */
  function db_connect() 
  {
    global $host, $user, $pass, $database;
    mysql_connect($host,$user,$pass) or die("ERROR:".mysql_error());
    mysql_select_db($database) or die("ERROR DB:".mysql_error());
  };
  
  
  /* Post content to SQL (remember to include header.php when you call this function) */
  function db_submit() 
  {
    global $date, $title, $author, $keywords, $content, $ip, $area_select, $categories, $disclude_categories, $theloop, $allow_comments;
    if (empty($author) || empty($content) || empty($categories) || empty($keywords)) {echo "<div id='row1'><div id='column1_1'><p>You must enter the author, keywords, content and categories. Click your back button to edit them</p></div></div>"; exit();}
    else {
      db_connect();
      //Insert variables into the correct field of the database
      mysql_query("INSERT INTO posts (`date_posted`, `title`, `keywords`, `author`, `content`, `ip_address`, `area`, `categories`, `disclude_categories`, `theloop`, `allow_comments`) VALUES ('$date', '$title', '$keywords', '$author', '$content', '$ip', '$area_select', '$categories','$disclude_categories', '$theloop', '$allow_comments')") or die(mysql_error());
      echo "<div id='row1'><div id='generalarea'><p>Your update was successful, s u s s e s s, f u l susessful.<br /><br />Want to go back <a href='../../'>home</a><br />or back to <a href='./'>edit</a>?</p></div></div>";
    }
  };
  
  
  /* Update content to SQL (remember to include header.php when you call this function) */
  function db_update() 
  {
    global $_POST, $id, $date, $title, $author, $keywords, $content, $ip, $area_select, $categories, $theloop, $disclude_categories, $allow_comments;
    if (isset($_POST['delete'])) {
      db_connect(); 
      mysql_query("UPDATE posts SET date_modified='$date', deleted='1', ip_address='$ip' WHERE id='$id'") or die(mysql_error()); 
      echo "<div id='row1'><div id='generalarea'><p>Your update was successful, s u s s e s s, f u l susessful.<br /><br />Want to go back <a href='../../'>home</a><br />or back to <a href='./'>edit</a>?</p></div></div>";
    };
    if (empty($author) || empty($content) || empty($categories) && !isset($_POST['delete'])) {
      echo "<div id='row1'><div id='generalarea'><p>You must enter the author, content and categories. Click your back button to edit them</p></div></div>"; exit();
    }
    else {
      if (isset($_POST['delete'])) exit();
      db_connect();
      //Update entry if delete is not selected
      mysql_query("UPDATE posts SET date_modified='$date', title='$title', keywords='$keywords', author='$author', content='$content', ip_address='$ip', area='$area_select', categories='$categories', theloop='$theloop', disclude_categories='$disclude_categories', allow_comments='$allow_comments' WHERE id='$id'") or die(mysql_error());
      echo "<div id='row1'><div id='generalarea'><p>Your update was successful, s u s s e s s, f u l susessful.<br /><br />Want to go back <a href='../../'>home</a><br />or back to <a href='./'>edit</a>?</p></div></div>";
    };
  };
  
  function logged_in() 
  {
    db_connect();
    //Checks if there is a login cookie
    if(isset($_COOKIE['cw_username'])) {
    
      //if there is, it logs you in and directs you to the members page
      $username = $_COOKIE['cw_username'];
      $password = $_COOKIE['cw_password'];
      $check = mysql_query("SELECT username, password FROM users WHERE username = '$username'")or die(mysql_error());
  
      $info = mysql_fetch_array($check);
      if ($password != $info['password']) {die('<div id="row1"><div id="generalarea"><p>Hmm, wrong cookie</p></div></div>');}
      if (isset($_POST['logout'])) {echo "<p><a class=\"iframe\" id=\"login\" href=\"/login\">Login</a></p>";}
      else {echo "<p>Logged in as: <a href=\"/portal/\">$username</a></p>";}
    }
    else {
		//set variable equal to the current page, then after logging in
		// redirect to that variable
		if(!strstr($_SERVER['REQUEST_URI'], "/admin") && !strstr($_SERVER['REQUEST_URI'], "/login") && !strstr($_SERVER['REQUEST_URI'], "/logout")) $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
      echo "<p><a class=\"iframe\" id=\"login\" href=\"/login/\">Login</a></p>";
    };
  };
  
  function check_user_level() 
  {
    $user_level = "3";
    db_connect();
    if(isset($_COOKIE['cw_username'])) {
    	$username = $_COOKIE['cw_username'];
    	$check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error());
    
    	$row = mysql_fetch_array($check);
    	$user_level = $row['user_level'];
    }
    return $user_level;
  };
  
  function show_users() 
  {
    if(check_user_level() == 0) {
      db_connect();
      $result = mysql_query("SELECT * FROM users")or die(mysql_error());
      echo "<br />
      <table>
        <tr>
          <td><b>Username</b></td>
          <td><b>Real Name</b></td>
          <td><b>Active</b></td>
          <td><b>Password</b></td>
          <td><b>User Level</b></td>
          <td><b>Update</b></td>
        </tr>";
      while($row = mysql_fetch_array($result)) {
        if ($row['active'] == 1) $checked = " checked"; else $checked = "";
        if ($row['user_level'] == 0) {$selected_administrator = " selected";} else if ($row['user_level'] == 1) {$selected_writer = " selected";} else {$selected_viewer = " selected";};
        echo "
        <tr>
          <td><input type=\"text\" name=\"username\" id=\"username\" maxlength=\"50\" value=\"".$row['username']."\" /></td>
          <td><input type=\"text\" name=\"realname\" id=\"realname\" maxlength=\"50\" value=\"".$row['real_name']."\" /></td>
          <td><input type=\"checkbox\" name=\"active\" id=\"active\" ".$checked." \></td>
          <td><input type=\"password\" name=\"password\" id=\"password\" maxlength=\"100\" value=\"".$row['password']."\" onclick=\"this.value=''\" /></td>
          <td><select name=\"user_level\"><option".$selected_administrator." value=\"Administrator\">Administrator</option><option".$selected_writer." value=\"Writer\">Writer</option><option".$selected_viewer." value=\"Viewer\">Viewer</option></select></td>
          <td><input type=\"hidden\" name=\"id\" value=\"".$row['user_id']."\" /><input type=\"submit\" name=\"update\" value=\"Update\" /></td>
        </tr>";
      };
      echo "</table>";
    };
  };
  
  function change_password_submit() 
  {
    $username = $_COOKIE['cw_username'];
    $oldpassword = md5($_POST['oldpassword']);
    $result = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
      $db_password = stripslashes($row['password']);
    };
    //This makes sure they did not leave any fields blank
    if (empty($_POST['oldpassword']) || empty($_POST['password']) || empty($_POST['password2'])) {
      die('<div id="row1"><div id="generalarea">You did not enter all of the required fields. Click back to continue</div></div>');
    }
    if ($oldpassword != $db_password) {
      die('<div id="row1"><div id="generalarea">Your old password did not match the one we have on file. Click back to continue</div></div>');
    }
    else {
      $password = md5($_POST['password']);
      if (!get_magic_quotes_gpc()) {
        $_POST['password'] = addslashes($_POST['password']);
      };
      mysql_query("UPDATE users SET password='$password' WHERE username='$username'") or die(mysql_error());
      setcookie(cw_password, "", time() - 3600*25, "/", ".criticalwire.com");
      setcookie(cw_password, $password, time() + 3600, "/", ".criticalwire.com");
      echo "<div id=\"row1\"><div id=\"generalarea\">Your password has been changed successfully</div></div>";
    };
  };
  
  function logout() 
  {
    echo "
    <form action=\"/logout\" method=\"post\">
      <input type=\"submit\" name=\"logout\" value=\"Logout\">
    </form>
    ";
  };
  
  function limit_words($string, $word_limit) 
  {
    global $row;
    $count = count(explode(' ', $string));
    $words = explode(' ', $string);
    if($count > $word_limit) {$append = "<br /><a href=\"/posts/".$row['id']."/".title_to_underscore($row['title'])."\">Read More..</a>";}
    else {$append = "";};
    $final = implode(' ', array_slice($words, 0, $word_limit));
    return $final.$append; 
  };
  
  function title_to_underscore($string)
  //You should rename this to string_to_underscore
  {
		$badtext = array('!', '?', '&', '$', ',', '.', '\\', '/', '(', ')', "'");
		$badtext_removed = str_replace($badtext, '', $string);
		$underscored = str_replace(' ', '_', $badtext_removed);
		$final = trim($underscored);
		return $final;
  };

  function area_sort_bar() 
  {
		$area = determine_area();
		$cat = $_GET['cat'];
		if($area != "none" && !isset($_GET['cat'])) {
		  $link = $area;
		  $linkdays = $area;
		}
		else if($area == "none" && isset($_GET['cat'])) {
		  $area = strtolower($cat);
		  $link = "posts";
		  $linkdays = "posts/".$area;
		}
		else if($area != "none" && isset($_GET['cat'])) {
		  $link = $area;
		  $linkdays = $area."/".strtolower($cat);
		};
		echo "<div id=\"area_column1_2\">
		<h2>Sort ".ucwords($area)." by:</h2>
		<br />
		<p><u>Category:</u></p>
		<ul>
		<li class=\"bullets\"><img src=\"/media/images/cw_technology.png\" alt=\"CriticalWire Technology\" style=\"border: none; vertical-align: middle;\" /><a href=\"/$link/technology/\">Technology</a></li>
		<li class=\"bullets\"><img src=\"/media/images/cw_music.png\" alt=\"CriticalWire Music\" style=\"border: none; vertical-align: middle;\" /><a href=\"/$link/music/\">Music</a></li>
		<li class=\"bullets\"><img src=\"/media/images/cw_photography.png\" alt=\"CriticalWire Photography\" style=\"border: none; vertical-align: middle;\" /><a href=\"/$link/photography/\">Photography</a></li>
		</ul><br />
		<p><u>View the past:</u></p>
		<ul>
		<li class=\"bullets\"><a href=\"/$linkdays/30days\">Month</a></li>
		<li class=\"bullets\"><a href=\"/$linkdays/60days\">Two Months</a></li>
		<li class=\"bullets\"><a href=\"/$linkdays/365days\">Entire Year</a></li>
		</ul>
		</div>";
  };
  
  function determine_area() 
  {
		if (isset($_GET['area'])) $area = $_GET['area'];
		else if ($_GET['area'] == "none") $area = "none";
		else if ($_SERVER['REQUEST_URI'] == '/blog/') $area = "blog";
		else if ($_SERVER['REQUEST_URI'] == '/news/') $area = "news";
		else if ($_SERVER['REQUEST_URI'] == '/reviews/') $area = "reviews";
		else {
			db_connect();
			$id = $_GET['id'];
			$query = mysql_query("SELECT area FROM posts WHERE deleted!=1 AND id ='$id'");
			$result = mysql_fetch_array($query);
			$area = strtolower($result['area']);
		}
		return $area;
  };
  
  function determine_page() 
  {
		global $maxpp;
		$id = $_GET['id'];
		$area = determine_area();
		$cat = $_GET['cat'];
		if (isset($_GET['p']) && $_GET['p'] != "none") $p = $_GET['p'];
		else if(empty($cat)) $p = 1;
		else if(empty($_GET['p'])) $p = 1;
		else if(empty($id)) $p = 1;
		else if($_GET['p'] == "none") {
			db_connect();
			$query = mysql_query("SELECT id FROM posts WHERE deleted!=1 AND id = '$id'");
			$result = mysql_fetch_array($query);
			$id = $result['id'];
			$totalres = mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE area = '$area'"),0);
			$totalpages = ceil($totalres / $maxpp);
			
			$p = ceil($totalres/$id);
		};
		return $p;
  };
  
  function determine_keywords()
  {
  	$id = $_GET['id'];
  	db_connect();
  	$query = mysql_query("SELECT keywords FROM posts WHERE deleted!=1 AND id = '$id'");
  	$result = mysql_fetch_array($query);
  	$keywords = $result['keywords'];
  	return $keywords;
  };
  
  function comment_write()
  {
		global $id, $allow_comments;
		db_connect();
		if($allow_comments == '1'){
			if(isset($_COOKIE['cw_username'])) {
				$username = $_COOKIE['cw_username'];
				$username_field = "<label for=\"username\">Username: </label><input type=\"text\" name=\"username\" id=\"username\" size=\"25\" value=\"$username\" readonly=\"readonly\" /><br />";
				echo "<h3>Comment on this article:</h3>";
				echo "<div class=\"commentbox\">
							<form action=\"/admin/comments/submit_comment.php\" method=\"post\" class=\"submitcomment\">
							$username_field
							<label for=\"comment\">Comment: </label><textarea rows=\"8\" cols=\"35\" name=\"comment\" id=\"comment\"></textarea><br />
							<input type=\"hidden\" name=\"postid\" id=\"postid\" value=\"$id\" />
							<input type=\"submit\" value=\"Submit\" class=\"submit\" />
							</form>
							</div><br /><br />";
			}
			else {
				$username_field = "<p style=\"font-size: 1em; margin-left: 28px\">Username: &nbsp;&nbsp;You must <a class=\"iframe\" id=\"login\" href=\"/login\">login</a>/<a class=\"iframe\" id=\"register\" href=\"/register\">register</a> to post</p><br />";
				echo "<h3>Comment on this article:</h3>";
				echo "<div class=\"commentbox\" style=\"height: 170px\">
						<form action=\"/admin/comments/submit_comment.php\" method=\"post\" class=\"submitcomment\">
						$username_field
						<label for=\"comment\">Comment: </label><textarea rows=\"8\" cols=\"35\" name=\"comment\" id=\"comment\" readonly=\"readonly\"></textarea><br />
						</form>
						</div><br /><br />";
			};
		}
		else echo "<hr /><h3>Comments aren't allowed on this article.</h3>";
	};
	
	function comment_list()
	{
		global $id, $act, $comment_id_selected, $current_user, $parser;
		db_connect();
		
		$query = mysql_query("SELECT comment_id, date_FORMAT(date_posted, '%M %e, %Y') AS date, user_id, comment FROM comments WHERE deleted!=1 AND post_id = '$id'");
		if(mysql_result(mysql_query("SELECT COUNT(comment_id) FROM comments WHERE deleted!=1 AND allow_comments=1 AND post_id = '$id'"),0) != 0)echo "<h2>Comments:</h2>";
		while($result = mysql_fetch_array($query)) {
			$date = $result['date'];
			$comment_id = $result['comment_id'];
			$user_id = $result['user_id'];
			$query_user = mysql_query("SELECT username FROM users WHERE active=1 AND user_id = '$user_id'");
			$result_user = mysql_fetch_array($query_user);
			$username = $result_user['username'];
			$parsed_comment = nl2br($parser->p($result['comment']));
			
			if((check_user_level() == 0 || check_user_level() == 1) || ($result_user['username'] == $current_user)) echo "<div class=\"commentbox\" style=\"height: auto\"><p><u>Posted by $username on $date</u></p><p style=\"float: right\"><a href=\"/admin/comments/edit.php?id=$id&comment_id=$comment_id&act=edit\">Edit</a> | <a href=\"/admin/comments/submit_comment_update.php?comment_id=$comment_id&act=delete\">Delete</a></p><br />\n";
			else echo "<div class=\"commentbox\" style=\"height: auto\"><p>Posted by $username on $date</p><br />\n";
			
			if($comment_id_selected == $comment_id) {
				if($act == "edit" && ((check_user_level() == 0 || check_user_level() == 1) || ($result_user['username'] == $current_user))) {
					echo "<form action=\"/admin/comments/submit_comment_update.php?act=edit&comment_id=$comment_id\" method=\"post\" class=\"submitcomment\">
								<textarea rows=\"8\" cols=\"35\" name=\"comment\" id=\"comment\">".$comment."</textarea><br />
								<input type=\"hidden\" name=\"comment_id\" id=\"comment_id\" value=\"$comment_id\" />
								<input type=\"submit\" value=\"Update\" class=\"submit\" /><br />
								</form></div><br />";
				}
				else echo "You do not have permission to edit that comment.";
			}
			else echo "<p>".$parsed_comment."</p></div><br />";
		}
	};
	
	function comment_edit()
	{
		global $id;
		db_connect();
		
	};
	
	function comment_delete()
	{
		global $id;
		db_connect();
		
	};
  
?>