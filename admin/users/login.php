<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="Description" content="<?php echo $current_description; ?>" />
  <title>Sign into CriticalWire</title>
  <link rel="stylesheet" href="/media/css/iframe.css" type="text/css" media="screen" />
  <!-- Fancybox stuff -->
	<link rel="stylesheet" href="/include/fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/include/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="/include/fancybox/jquery.fancybox-1.3.1.pack.js"></script>
	<script type="text/javascript" src="/media/js/md5.js"></script>
	<script type="text/javascript" src="/media/js/iframebox.js"></script>
  <!-- end Fancybox stuff -->
</head>

<body class="login">
	<div id="successful_login">You have been successfully logged in</div>
	<div class="loginbox">
		<form id="login_form" method="post" action="">
			<h1>Sign into your account</h1>
			<div id="no_fields">You didn't enter all the required fields</div>
			<div id="wrong_password">You entered an incorrect password</div>
			<div id="no_user">That user doesn't exist</div>
			<br />
			<label for="login_username">Username:</label><input type="text" name="username" id="login_username" maxlength="50" /><br />
			<label for="login_password">Password:</label><input type="password" name="password" id="login_password" maxlength="100" /><br />
			<div id="submitbutton"><input type="submit" name="login" value="Login" /></div>
		</form>
	</div>
	<div class="registertext">Don't have a username? Register <a id="register" href="/register/">here</a></div>
</body>
</html>