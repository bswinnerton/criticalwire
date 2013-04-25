<?php
	//Set correct title
	$current_title = &$admin_title;
	$current_description = &$admin_description;
	$current_page = 'home';
	
	//Header information
	include("../include/header.php");
?>


<div id="row1">
	<div id="generalarea">
		What would you like to administrate?
		<ul>
			<li><blockquote>-<a href="posts">Blog/News/Reviews Posts</a></blockquote></li>
			<li><blockquote>-<a href="users">Change Password / User Management</a></blockquote></li>
			<br />
			<?php logout(); ?>
		</ul>
	</div>
</div>

  
<?php
	include("../include/footer.php");
?>