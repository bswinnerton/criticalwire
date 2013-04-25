<?php
  //Set correct title & meta description
  $current_title = &$home_title;
  $current_description = &$home_description;
  $current_page = 'home';                     /* Proper uses: home, blog, news, reviews, websolutions, aboutus */
  
  //Header information
  $area = "home";
  include("include/header.php");
  
  //BBCode stuff
  require_once("include/parser.php");
  $parser = new parser;
  
  //Connect to database
  db_connect();
?>

<div id="row1">
  <div id="column1_1">
    <h1>The Loop</h1>
    <center>
    <a href="http://www.flickr.com/photos/bswinnerton/4004875003/" target="_blank"><img src="media/images/bear.jpg" width="100%" alt="Yeah, I'm a bear." /></a>
    <p>f/16 15sec - <a href="http://www.flickr.com/photos/bswinnerton">flickr</a></p>
    </center><br />
    
    <?php
      $query = "SELECT id, title, content FROM posts WHERE theloop=1 AND deleted!=1 ORDER BY date_posted DESC LIMIT 0, $theloop_limit";  					        // Select table blog only when category says technology and disclude_categories is not set to 1 and sort by date 
      $result = mysql_query($query) or die(mysql_error());																																								                // Create new variable called result and insert query 
      while ($row = mysql_fetch_assoc($result)) {																																													                // While loop to return everything in the column 
        $postid = $row['id'];
        $parsed_content = nl2br($parser->p($row['content']));
        echo "<h2><a href=\"/posts/".$postid."/".title_to_underscore($row['title'])."\">".$row['title']."</a></h2>\n"."<p>".$parsed_content."</p><br />";		// Return content and use css formatting 
        echo "<br /><br />";																																																							                // Drop down a few lines after every post
      };
    ?>
    
    <p><a href="#">Stay in the loop </a></p>
  </div>

  <div id="column1_2">
    <h1>Welcome!</h1>
    <p>Welcome to the new CriticalWire.com, designed and maintained mostly by Brooks Swinnerton. CriticalWire was first created so I could expand my knowledge about websites and although the site has seen many faces in the past few years, today its my latest thoughts on technology, music, and photography. I also offer some web services to those who are interested in having a website hosted. Please feel free to contact me with any bugs on the page (or more commonly, misspellings).</p> 
    <br /><br />
    <p>CriticalWire.com offers a variety of web hosting solutions to meet the needs of your business, or personal needs. We will place your website on one of our dependable servers and if you would like we can even design your site!</p>
    <br /><br />
    <p><b>Hosting Package 1</b> ---- $4.99 per month, 1 GB of space for data, ISPConfig Control Panel, FTP Access (5 users), Awstats Statistics Software, 5 E-mail Accounts, phpMyAdmin for managing MySQL</p>
    <br /><br />
    <p><b>Hosting Package 2</b> ---- $9.99 per month, 3 GB of space for data, 1 Free Domain, ISPConfig Control Panel, FTP Access (10 users), Awstats Statistics Software, 25 E-mail Accounts, phpMyAdmin for managing MySQL</p>
    <br /><br />
    <p><b>Hosting Package 3</b> ---- $29.99 per month, 20 GB of space for data, 1 Free Domain, ISPConfig Control Panel, FTP Access (Unlimited users), Awstats Statistics Software, 50 E-Mail Accounts, phpMyAdmin for managing MySQL</p>
    <br /><br />
    <p>All packages can be customized to fit your needs and specific pricing is available. Please contact me at websolutions@criticalwire.com</p>
  </div>
</div>

<div id="row2">
  <div id="column2_1">
    <div class="categories"><a href="/posts/technology/">Technology</a></div>
    <hr />
    
    <?php
    $query = "(SELECT id, title, content, author FROM posts WHERE categories LIKE '%Technology%' AND disclude_categories!=1 AND deleted!=1) ORDER BY date_posted DESC LIMIT 0, $technology_limit";  //Select table blog only when category says technology and disclude_categories is not set to 1 and sort by date
    $result = mysql_query($query) or die(mysql_error());																																																									//Create new variable called result and insert query
    while ($row = mysql_fetch_assoc($result)) {																																																														//While loop to return everything in the column
      $postid = $row['id'];
      $parsed_content = nl2br($parser->p($row['content']));
      $parsed_content = limit_words($parsed_content, 74);
      echo "<h2><a href=\"/posts/".$postid."/".title_to_underscore($row['title'])."\">",$row['title'],"</a></h2>","<p>","by: ",$row['author'],"<br /><br />",$parsed_content,"</p><br />";		//Return title, author and content and use css formatting
      echo "<br /><br />";																																																																							//Drop down a few lines after every post
    };
    ?>
    
  </div>
  <div id="column2_3">
    <div class="categories"><a href="/posts/photography/">Photography</a></div>
    <hr />
    
    <?php
    mysql_connect($host,$user,$pass) or die("ERROR:".mysql_error());
    mysql_select_db($database) or die("ERROR DB:".mysql_error());
    $query = "(SELECT id, title, content, author FROM posts WHERE categories LIKE '%Photography%' AND disclude_categories!=1 AND deleted!=1) ORDER BY date_posted DESC LIMIT 0, $photography_limit";
    $result = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
      $postid = $row['id'];
      $parsed_content = nl2br($parser->p($row['content']));
		  $parsed_content = limit_words($parsed_content, 74);
      echo "<h2><a href=\"/posts/".$postid."/".title_to_underscore($row['title'])."\">",$row['title'],"</a></h2>","<p>","by: ",$row['author'],"<br /><br />",$parsed_content,"</p><br />";
      echo "<br /><br />";
    };
    ?>
    
  </div>
  <div id="column2_2">
    <div class="categories"><a href="/posts/music/">Music</a></div>
    <hr />
    <?php 
    mysql_connect($host,$user,$pass) or die("ERROR:".mysql_error());
    mysql_select_db($database) or die("ERROR DB:".mysql_error());
    $query = "(SELECT id, title, content, author FROM posts WHERE categories LIKE '%Music%' AND disclude_categories!=1 AND deleted!=1) ORDER BY date_posted DESC LIMIT 0, $music_limit";
    $result = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
      $postid = $row['id'];
      $parsed_content = nl2br($parser->p($row['content']));
		  $parsed_content = limit_words($parsed_content, 74);
      echo "<h2><a href=\"/posts/".$postid."/".title_to_underscore($row['title'])."\">",$row['title'],"</a></h2>","<p>","by: ",$row['author'],"<br /><br />",$parsed_content,"</p><br />";
      echo "<br /><br />";
    };
    ?>
  </div>
</div>

<?php
  include("include/footer.php");
?>