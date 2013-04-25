<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="Description" content="<?php echo $current_description; ?>" />
  <title>Register at CriticalWire</title>
  <link rel="stylesheet" href="/media/css/iframe.css" type="text/css" media="screen" />
  <!-- Fancybox stuff -->
	<link rel="stylesheet" href="/include/fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/include/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="/include/fancybox/jquery.fancybox-1.3.1.pack.js"></script>
	<script type="text/javascript" src="/media/js/md5.js"></script>
	<script type="text/javascript" src="/media/js/iframebox.js"></script>
  <!-- end Fancybox stuff -->
</head>

<body class="register">
	<div id="successful_login">Thank you, you are now registered. Login <a id="login" href="/login/">here</a></div>
	<div class="registerbox">
		<form id="register_form" method="post" action="">
			<h1>Register at CriticalWire</h1>
			<div id="no_fields">You didn't enter all the required fields</div>
			<div id="no_pass_match">Your passwords didn't match</div>
			<div id="user_taken">Sorry, that username is taken</div>
			<br />
			<label for="realname">Real Name: </label><input type="text" name="realname" id="realname" maxlength="50" /><br />
			<label for="email">Email: </label><input type="text" name="email" id="email" maxlength="50" /><br />
			<label for="username">Username: </label><input type="text" name="username" id="username" maxlength="50" /><br />
			<label for="password">Password: </label><input type="password" name="password" id="password" maxlength="100" /><br />
			<label for="password2">Confirm Password: </label><input type="password" name="password2" id="password2" maxlength="100" /><br />
			<div id="submitbutton"><input type="submit" name="submit" value="Register" /></div>
		</form>
	</div>
</body>
</html>