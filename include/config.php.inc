<?php

//sql data
$host = "localhost";
$database = "criticalwire";
$user = "criticalwire";
$pass = "";

//number of blogs entries allowed in categories of front page
$technology_limit = 3;
$music_limit = 3;
$photography_limit = 3;
$theloop_limit = 2;

$blog_maxpp = 7;
$news_maxpp = 7;
$reviews_maxpp = 7;
$noarea_maxpp = 7;

//home specific stuff
$home_title = "CriticalWire";
$home_description = "CriticalWire is a place for you to follow the latest technological, musical and photography trends.";

//news specific stuff
$news_title = "CriticalWire News";
$news_description = "CriticalWire news for updates to the site as well as technology related news.";

//blog specific stuff
$blog_title = "CriticalWire Blog";
$blog_description = "CriticalWire blog for tips, tricks and how-to's of the latest technology.";

//websolutions specific stuff
$websolutions_title = "CriticalWire Web Solutions";
$websolutions_description = "Web Solutions from CriticalWire to provide you with hosting and design.";

//reviews specific stuff
$reviews_title = "CriticalWire Reviews";
$reviews_description = "CriticalWire reviews for the latest technology reviews.";

//contact us specific stuff
$aboutus_title = "About CriticalWire";
$aboutus_description = "About CriticalWire, and how you can contact us.";

//search specific stuff
$search_title = "Search CriticalWire";
$search_description = "Search the CriticalWire website";

//admin specific stuff
$admin_title = "Edit CriticalWire";
$admin_description = "";

//submit specific stuff
$submitted_title = "CriticalWire: Your content has been submitted";
$submitted_description = "";

//user specific stuff
$usermang_title = "Manage Users";
$usermang_description = "";

//privacy policy specific stuff
$privacy_title = "CriticalWire Privacy Policy";
$privacy_description = "CriticalWire's privacy policy";

//ip stuff
$ip = $_SERVER['REMOTE_ADDR'];
$hostaddress = gethostbyaddr($ip);
$browser = $_SERVER['HTTP_USER_AGENT'];
$referred = $_SERVER['HTTP_REFERER'];

?>
