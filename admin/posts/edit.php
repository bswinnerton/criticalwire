<?php
	//Set correct title & meta description
	$current_title = &$admin_title;
	$current_description = &$admin_description;
	$current_page = 'home';                     											//Proper uses: home, blog, news, reviews, websolutions, aboutus
	
	//if new was selected from previous edit.php, redirect to index.php
	if(isset($_GET['new'])) {header('Location:index.php'); exit;}
	
	//Header information
	include("../../include/header.php");
	
	//connect to database
	db_connect();
	
	//set variable of selected dropdown from index.php
	$id = $_GET['id'];
?>

	
<div id="row1">
	<div id="generalarea">
		<form action="/admin/posts/edit.php" method="get">
			Did you want to edit something?: 
			<select class="dropdown" name="id" style="width: 500px">

				<?php
					//query the database
					$result = mysql_query("SELECT id, date_posted, title, area, categories, deleted FROM posts WHERE deleted!= 1 ORDER BY date_posted DESC") or die (mysql_error() );
					
					//fetch the array title 
					while($row = mysql_fetch_array($result)){
						if($id == $row['id']) $default = " selected"; //default option is the one selected from index.php
						else {$default = "";}
						echo "<option $default value=\"".$row['id']."\">".$row['area'].' - '.$row['categories'].' - '.'"'.$row['title'].'"'."</option>";
					}
				?>

			</select>
			<input type="submit" value="Edit" name="edit" />
			<input type="submit" value="New" name="new" />
		</form>
<hr /><br /><br />
	
<?php
	$result = mysql_query("SELECT id, date_posted, author, title, keywords, content, area, categories, theloop, allow_comments, deleted FROM posts WHERE id = '$id' ORDER BY date_posted DESC") or die (mysql_error());
	$row = mysql_fetch_array($result);
	
	$theloop = $row['theloop'];
	
	//if mysql table is 1, check the disclude_categories box
	if ($row['disclude_categories'] == '1')
		$checked_disclude_categories = "checked";
	else
		$checked_disclude_categories = "";
	
	//if mysql table is 1, check theloop box
	if ($row['theloop'] == '1')
		$checked_theloop = "checked";
	else
		$checked_theloop = "";
	
	//if mysql table has category music, technology, or photography check the corresponding box
	if (strpos($row['categories'], 'Music') === FALSE)
		$checked_music = "";
	else
		$checked_music = "checked";
	
	if (strpos($row['categories'], 'Technology') === FALSE)
		$checked_technology = "";
	else
		$checked_technology = "checked";
	
	if (strpos($row['categories'], 'Photography') === FALSE)
		$checked_photography = "";
	else
		$checked_photography = "checked";
	
	//if mysql table has blog, news, or reviews default the corresponding box
	if ($row['area'] == 'Blog')
		$row_blog = "selected";
	else
		$row_blog = "";
	
	if ($row['area'] == 'News')
		$row_news = "selected";
	else
		$row_news = "";
	
	if ($row['area'] == 'Reviews')
		$row_reviews = "selected";
	else
		$row_reviews = "";
		
	//check to see if comments are allowed	
	if ($row['allow_comments'] == '1')
		$checked_allow_comments = "checked";
	else
		$checked_allow_comments = "";
?>


		<form action="submit_update.php" method="post">
			Where does this belong? 
			<select class="dropdown" name="area_select">
				<option <?php echo $row_blog; ?> value="Blog">Blog</option>
				<option <?php echo $row_news; ?> value="News">News</option>
				<option <?php echo $row_reviews; ?> value="Reviews">Reviews</option>
			</select>
			<br /><br />
			<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
			<label for="author">Author: </label><input type="text" name="author" id="author" size="25" value="<?php echo $row['author']; ?>" /><br />
			<label for="title">Title: </label><input type="text" name="title" id="title" size="60" value="<?php echo $row['title']; ?>" /><br />
			<label for="keywords">Keywords: </label><input type="text" name="keywords" id="keywords" size="101" value="<?php echo $row['keywords']; ?>" /><br />
			<label for="content">Content: </label><textarea rows="20" cols="100" name="content" id="content"><?php echo $row['content']; ?></textarea><br />
			<u>Categories:</u><br />
			<label for="music">Music: </label><input type="checkbox" name="categories[]" id="music" value="Music" <?php echo $checked_music ?> /><br />
			<label for="technology">Technology: </label><input type="checkbox" name="categories[]" id="technology" value="Technology" <?php echo $checked_technology ?> /><br />
			<label for="photography">Photography: </label><input type="checkbox" name="categories[]" id="photography" value="Photography" <?php echo $checked_photography ?> /><br /><br />
			<label for="disclude_categories">Disclude from categories: </label><input type="checkbox" name ="disclude_categories[]" id="disclude_categories" value="disclude_categories" <?php echo $checked_disclude_categories ?> /><br /><br /><br />
			<label for="theloop">Insert in The Loop: </label><input type="checkbox" name = "theloop[]" id="theloop" value="theloop" <?php echo $checked_theloop ?> /><br /><br /><br />
			<label for="allow_comments">Allow Comments: </label><input type="checkbox" name = "allow_comments" id="allow_comments" value="allow_comments" <?php echo $checked_allow_comments ?> /><br /><br />
			
			<input type="submit" value="Update" name="update" />
			<input type="submit" value="Delete" name="delete" onclick="return confirm('Are you sure you want to delete this item?')" />
			<br /><br /><br /><br />
		</form>
	</div>
</div>


<?php
	include("../../include/footer.php");
?>