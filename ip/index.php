<?php
  $ip = $_SERVER['REMOTE_ADDR'];
  $hostaddress = gethostbyaddr($ip);
  $browser = $_SERVER['HTTP_USER_AGENT'];
  $referred = $_SERVER['HTTP_REFERER'];
  $server_ip = $_SERVER['SERVER_ADDR'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="Description" content="CriticalWire - What's your IP" />
    <meta keywords="IP address, IP, what is my ip, internet protocol" />
    <title>Your IP Address is: <?php echo $ip ?></title>
    <link rel="shortcut icon" href="../media/images/favicon.ico" type="image/x-icon"/>
  </head>

  <body>
    <center>
      <p style='font-size:xx-large'>
        <b>Your IP address: <?php echo $ip ?></b>
      </p>
    </center>
    <br /><br />
    <p style='font-size:medium'>
      <b>Host address:</b><br /><?php echo $hostaddress ?>
      <br /><br />
      <b>Display browser info</b>:<br /><?php echo $browser ?>
      <br /><br />
      <b>Where you came from (if you clicked on a link to get here):</b><br />
        <?php
          if ($referred == "") {echo "Page was directly requested";}
          else {echo $referred;}
        ?>
    </p>
  </body>
</html>
