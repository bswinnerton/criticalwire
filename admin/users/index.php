<?php
  ob_start();
  
	//Set correct title
	$current_title = &$admin_title;
	$current_description = &$admin_description;
	$current_page = 'home';
	
	//Header information
	include("../../include/header.php");
	
  
  db_connect();

  //This code runs if the form has been submitted to reset password
  if (isset($_POST['changepassword'])) {
    change_password_submit();
  }
?>


<div id="row1">
  <div id="generalarea">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	    <label for="oldpassword">Old Password: </label><input type="password" name="oldpassword" id="oldpassword" maxlength="100"><br />
	    <label for="password">New Password: </label><input type="password" name="password" id="password" maxlength="100"><br />
	    <label for="password2">Confirm Password: </label><input type="password" name="password2" id="password2" maxlength="100"><br />
	    <input type="submit" name="changepassword" value="Change Password">
    </form>
    <?php show_users(); ?>
  </div>
</div>


<?php
	ob_flush();
	include("../../include/footer.php");
?>