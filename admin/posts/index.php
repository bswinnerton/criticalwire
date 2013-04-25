<?php
	//Set correct title & meta description
	$current_title = &$admin_title;
	$current_description = &$admin_description;
	$current_page = 'home';                     //Proper uses: home, blog, news, reviews, websolutions, aboutus
	
	//Header information
	include("../../include/header.php");
	
	//connect to database
	db_connect();
?>


<div id="row1">
	<div id="generalarea">
		<form action="/admin/posts/edit.php">
			Did you want to edit something?: 
			<select class="dropdown" name="id" style="width: 500px">
		
				<?php
					//query the database
					$result = mysql_query("SELECT id, date_posted, title, area, categories, deleted FROM posts WHERE deleted!= 1 ORDER BY date_posted DESC") or die (mysql_error() );
					
					//fetch the array title 
					while($row = mysql_fetch_array($result)){
						echo "<option value=\"".$row['id']."\">".$row['area'].' - '.$row['categories'].' - '.'"'.$row['title'].'"'."</option>";
					}
				?>
			
			</select>
			<input type="submit" value="Edit" />
		</form>
		<hr /><br /><br />
		<form action="submit.php" method="post">
			Where does this belong? <select class="dropdown" name="area_select"><option value="Blog">Blog</option><option value="News">News</option><option value="Reviews">Reviews</option></select><br /><br />
	
			<label for="author">Author: </label><input type="text" name="author" id="author" size="25" value="" /><br />
			<label for="title">Title: </label><input type="text" name="title" id="title" size="60" value="" /><br />
			<label for="keywords">Keywords: </label><input type="text" name="keywords" id="keywords" size="101" value="" /><br />
			<label for="content">Content: </label><textarea rows="20" cols="100" name="content" id="content"></textarea><br />
			<u>Categories:</u><br />
			<label for="music">Music: </label><input type="checkbox" name="categories[]" id="music" value="Music" /><br />
			<label for="technology">Technology: </label><input type="checkbox" name="categories[]" id="technology" value="Technology" /><br />
			<label for="photography">Photography: </label><input type="checkbox" name="categories[]" id="photography" value="Photography" /><br /><br />
			<label for="disclude_categories">Disclude from categories: </label><input type="checkbox" name ="disclude_categories[]" id="disclude_categories" value="disclude_categories" /><br /><br /><br />
			<label for="theloop">Insert in The Loop: </label><input type="checkbox" name = "theloop[]" id="theloop" value="theloop" checked="checked" /><br /><br /><br />
			<label for="allow_comments">Allow Comments: </label><input type="checkbox" name = "allow_comments" id="allow_comments" value="allow_comments" checked="checked" /><br /><br />
	
			<input type="submit" value="Submit" /><br /><br /><br /><br />
		</form>
	</div>
</div>
		
		
<?php
	include("../../include/footer.php");
?>