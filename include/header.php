<?php
	session_start();
	require_once("functions.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="Keywords" content="<?php echo $keywords; ?>" />
  <meta name="Description" content="<?php echo $current_description; ?>" />
  <meta name="google-site-verification" content="eTeZir7cu-Alb6gbIs5tfOOaEwpeIO8REXISXatyY_c" />
  <title><?php echo $current_title; ?></title>
  <link rel="stylesheet" href="/media/css/reset.css" type="text/css" />
  <link rel="stylesheet" href="/media/css/style.css" type="text/css" media="screen" />
  <link rel="shortcut icon" href="/media/images/favicon.ico" type="image/x-icon"/>
  <!-- Fancybox stuff -->
	<link rel="stylesheet" href="/include/fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/include/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="/include/fancybox/jquery.fancybox-1.3.1.pack.js"></script>
	<script type="text/javascript" src="/media/js/iframebox.js"></script>
  <!-- end Fancybox stuff -->
</head>

<body id="<?php echo $area; ?>">
<div id="container"> <!-- container: ending is in footer.php -->
  <div id="banner">
    <div id="loggedin"><?php logged_in(); ?></div>
  </div>
  <div id="navcontainer"> 
    <div id="navlist_left">
      <ul id="navlist">
	      <li class="navlist_1"><a href="/" <?php if($current_page == 'home') { ?> class="navlist_current_1" <?php } ?>>Home</a></li> 
	      <li class="navlist_2"><a href="/blog/" <?php if($current_page == 'blog') { ?> class="navlist_current_2" <?php } ?>>Blog</a></li>
	      <li class="navlist_3"><a href="/news/" <?php if($current_page == 'news') { ?> class="navlist_current_3" <?php } ?>>News</a></li> 
	      <li class="navlist_4"><a href="/reviews/" <?php if($current_page == 'reviews') { ?> class="navlist_current_4" <?php } ?>>Reviews</a></li>
	      <li class="navlist_5"><a href="/websolutions/" <?php if($current_page == 'websolutions') { ?> class="navlist_current_5" <?php } ?>>Web Solutions</a></li>
	      <li class="navlist_6"><a href="/aboutus/" <?php if($current_page == 'aboutus') { ?> class="navlist_current_6" <?php } ?>>About Us</a></li>
	    </ul>
    </div>
    <div id="search">
      <form action="/search/search.php" id="cse-search-box">
	      <div>
		      <input type="hidden" name="cx" value="013605903457691891841:bted32mmqvm" />
		      <input type="hidden" name="cof" value="FORID:10" />
		      <input type="hidden" name="ie" value="UTF-8" />
		      <input type="text" name="q" size="31" value="Search" onclick="this.value=''" />
		      <input type="submit" name="sa" value="Go" />
	      </div>
      </form>
    </div>
  </div>

<?php
	//if on any page in admin directory
	if((strstr($_SERVER['REQUEST_URI'], "/admin") || strstr($_SERVER['REQUEST_URI'], "/portal/posts")) && !(strstr($_SERVER['REQUEST_URI'], "/admin/comments")) && !(strstr($_SERVER['REQUEST_URI'], "/login")) && !(strstr($_SERVER['REQUEST_URI'], "/register"))) {
		//and if not privledged user
		if(!(check_user_level() == 0 || check_user_level() == 1)) {
			//echo "<div id=\"row1\"><div id=\"generalarea\"><p>You are not logged in. Log in <a class=\"iframe\" id=\"login\" href=\"/login/\">here</a></p></div></div>";
			echo "<div id=\"row1\"><div id=\"generalarea\"><p>You don't have permission to access this feature.</p></div></div>";
			exit;
		}
	}
?>