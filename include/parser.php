<?php
/*

||++++++++++ Application Name ++++++++++||
||-> Recruiting Parser

||++++++++ Application Version +++++++++||
||-> 1.0 Pre-Final #1 -dev

||+++++++++++ Creation Time ++++++++++++||
||-> Since August 2006

||+++++++++++ Initial Release ++++++++++||
||-> 10th July 2007

||+++++++++++ Latest Release +++++++++++||
||-> 21st January 2010

||+++++++++++++ Created By +++++++++++++||
||-> Nino Skopac

||++++++++++++ Base/Domain +++++++++++++||
||-> Recruiting Grounds - RecGr.com
||-> Recruiting Parser Base - BbcParser.recgr.com
||-> Development Grounds - Dev.recgr.com
||-> Discuss RePa and make it better - Forum-Grounds.com

||++++++++++++ Documentation +++++++++++||
||-> A big manual/documentation is available at
||   Recruiting Parser Base pages.
||-> http://bbcparser.recgr.com

||++++++++++++++ Licence ++++++++++++++||
||-> Recruiting Parser is a freeware, and even though you 
||   can edit its source code, you must (we will really like it)
||   post that change to Forum Grounds (more at Base).
||   Of course, you can use it in your applications, but keeping
||   all comments intact.

||++++++++++++++ Extras +++++++++++++++||
||-> Recruiting Parser has a few internal (built-in) extras.
||   External extras ran via file called 'parser_conf.ini' are
||   are available as of Recruiting Parser 1.0 Final.



|| -> -> ->    B R I E F   I N F O R M A T I O N    <- <- <- ||

 Recruiting Parser (RePa) is an Object Orientated Programming
 powered PHP application which transforms BBCode to (X)HTML.
 There is no any kind of storage required, altough there's a 
 file called 'parser_conf.ini' which is used for manipulating
 with Recruiting Parsers' extensions and add - onns.
 
 Requirements: the only thing you need is PHP 4.
 But, if you can, use PHP 5 instead, since it will work
 slighty faster. Recruiting Parser is not tested on PHP6.
 
 Implementation and usage: extremelly easy, you wouldn't believe.
 The function which powers this Application requires only one
 argument, although you can use them more (see below for more
 information).
 
 Major Features

    * over 25 case-insensitive different tags
    * incredibly easy set up
    * automatic correction for badly formated tags
    * protection against tags that would cause page crash
    * protection against spam-robots (mails get crypted)
    * deparse function - parse and deparse how many times you want
    * built-in updates - check if a newer version is available, whenever you want
    * open code
    * reprogrammable & extensible
	
	
|| -> -> ->    S I M P L E S T         U S A G E    <- <- <- ||
 
 >> we assume there's some text that needs parsing
 stored in variable called $text <<
 
 require_once('parser.php'); // path to Recruiting Parsers' file
 $parser = new parser; //  start up Recruiting Parsers
 
 $parsed = $parser->p($text); // p() is function which parses
 
 >> parsed text is now stored in $parsed, if you want
 to output simply output $parsed, thusly: <<
 
 echo $parsed;
 
 
 
 >> Tags Supported <<
 (case - insensitive)
 
 > Bold Text
   [b]Some Text[/b]
 
 > Italic Text
   [i]Some Text[/i]
 
 > Underline Text
   [u]Some Text[/i]
 
 > Highlighted Text
   [cool]Some Text[/cool]
 
 > Indent Text
   [indent]Some Text[/indent]
 
 > Speech or Lyrics Text
   [lyrics]Some Text[/lyrics]
 
 > Small Caps Decoration
   [smallcaps]Some Text[/smallcaps]
 
 > Bigger Text
   [big]Some Text[/big]
 
 > Smaller Text
   [small]Some Text[/small]
 
 > Monospaced Text (Teletype Output)
   [tt]Some Text[/tt]
 
 > Subscript Text
   [sub]Some Text[/sub]
 
 > Superscript Text
   [sup]Some Text[/sup]
 
 > Hyperlinks
   [url]http://www.recgr.com[/url]
     - or -
   [url=http://www.recgr.com]Recruiting Grounds[/url]
     - note: links don't have to be set up that well,
	   basic link format will be recognized and fixed
	   by Recruiting Parser -

 > Images
   [img]http://get.recgr.com/i/rgwallpaper.jpg[/img]
 
 > Email Links
   [email]demo@recgr.com[/email]
    - or -
   [email=demo@recgr.com]Demo User[/email]
     - note: RePa can crypt them so these addresses
	   become safe from spam robots. defaults to on,
	   but you can turn it off by putting 0 to 6th
	   argument. more in arguments chapter below -
	   
 > Text Font
   [font=Verdana]Some Verdana Text[/font]
   
 > Text Color
   [color=red]Some Red Text[/color]
    - or -
   [color=#FF0000]Some Red Text[/color]
   
 > PHP Highlight
   [php]some php code[/php]
     - note: RePa will once again fix and parse
	   not completely correct typed text -

 > Code Type
   [code]some html or similar code[/code]
 
 > List
   [list]Some List Property[/list]
 
 > List, with Order (Decimal numbers)
   [list=dec]Some Ordered Text[/list]
 
 
   --> XHTML Short Tags <--
   
   > Bull, &bull; 
     [bull /]
   
   > Copyright, &copy;
     [copyright /]
	 
   > Registered, &reg;
     [registered /]
   
   > Trademark, &trade;
     [tm /]
	 
	 
  *********** || YOU MUSTN'T EDIT THIS COMMENT, OTHERWISE PARSER WON'T EXECUTE || ***********

*/
define('SECURITY_CODE', __LINE__);
error_reporting(E_ALL ^ E_NOTICE);

/*if ($_SERVER['REQUEST_URI'] == '/index.php') {$ten = "\'</code></div><p>\'";}
else {$ten = "\'</code></div><p class=\"area\">\'";};*/

class parser {
	protected $codeline = SECURITY_CODE;
	// Searching Repository
	private $bbc = array(
		1 => '[u]',
		2 => '[/u]',
		3 => '[i]',
		4 => '[/i]',
		5 => '[b]',
		6 => '[/b]',
		7 => '[cool]',
		8 => '[/cool]',
		9 => '[code]',
		10 => '[/code]',
		11 => '[indent]',
		12 => '[/indent]',
		13 => '[lyrics]',
		14 => '[/lyrics]',
		15 => '[smallcaps]',
		16 => '[/smallcaps]',
		17 => '[big]',
		18 => '[/big]',
		19 => '[small]',
		20 => '[/small]',
		21 => '[tt]',
		22 => '[/tt]',
		23 => '[sub]',
		24 => '[/sub]',
		25 => '[sup]',
		26 => '[/sup]'
	);
	
	// Replacement Repository
	private $rep = array(
		1 => '<span style="text-decoration: underline;">',
		2 => '</span>',
		3 => '<em>',
		4 => '</em>',
		5 => '<strong>',
		6 => '</strong>',
		7 => '<span style="font-family: Verdana, Arial, Helvetica, sans-serif; letter-spacing: 2px; word-spacing: 3px; font-size: 13px; font-weight: bold; font-style: italic; color: #333399; font-variant: small-caps; height: 12px; padding-left: 9pt; padding-right: 6pt; vertical-align: middle; display: block;">',
		8 => '</span>',
		9 => '</p><div class="code" style="width: 80%; overflow: auto; text-align: left; border: 1px solid #CCCCCC; display: inline-block; padding-left: 10px;"><code style="white-space: pre;">',
		10 => '</code></div><p>',
		11 => '</p><blockquote>',
		12 => '</blockquote><p>',
		13 => '<span style="margin-left: 30px; font-style: italic; display: block;">',
		14 => '</span>',
		15 => '<span style="font-variant: small-caps;">',
		16 => '</span>',
		17 => '<span style="font-size: 22px;">',
		18 => '</span>',
		19 => '<span style="font-size: 10px;">',
		20 => '</span>',
		21 => '<tt>',
		22 => '</tt>',
		23 => '<sub>',
		24 => '</sub>',
		25 => '<sup>',
		26 => '</sup>'
	);
	
	// "Specials", XHTML-like BBC Repository
	private $xht = array(
		'[bull /]' => '<big>&bull;</big>',
		'[copyright /]' => '&copy;',
		'[registered /]' => '&reg;',
		'[tm /]' => '<big>&trade;</big>'
	);
	
	protected $rpVersion = '1.0.1';
	protected $rpAddr = 'www.bbcparser.recgr.com';
	
function __construct() {
/*	define('RUNS', 'NDg0');
	define('DOESNT_RUN', 'PGgxPkZhdGFsIEVycm9yPC9oMT4gCiBZb3UgZWRpdGVkIFBhcnNlcidzIGNvbW1lbnRzL2NyZWRpdHMsIHRoZSBhcHBsaWNhdGlvbiB3aWxsIG5vdyBleGl0IC4uLg=='); */
	
	function caselessPcre() {
		$extensions = get_loaded_extensions();
		$extensions = array_flip($extensions);
		$extensions = array_change_key_case($extensions, CASE_LOWER);
		$extensions = array_flip($extensions);
		
		if (in_array('pcre', $extensions)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	if ( (!(extension_loaded('pcre') && caselessPcre())) && (!isset($_GET['silentmode'])) ) {
		echo "<h1>Fatal Error</h1> \n\n";
		echo "You don't have the necessary prerequisites! You must install the PCRE libray!";
		echo "<br /><br /> \n";
		echo "If you think this check is <strong>wrong</strong>, just append <code>?silentmode</code> to your URL.";
		die();
	}
	
/*	if ($this->codeline != base64_decode(constant("RUNS"))) {
		echo base64_decode(constant('DOESNT_RUN')) . "\n";
		eval(base64_decode('ZGVmaW5lKCJIQVZFTlRfUlVOIiwgdHJ1ZSk7'));
		die();
	} */
	
}

public function protect($email) {
	// Protect Emails from robot-spamers
	// How does it work?
	// - it converts every character to its ordinal value
	// visitor won't see any difference
	
	$email = trim($email);
	$intEmail = "";
	$num = 0;
	
	while ($num < strlen($email)) {
	
		if (empty($intEmail)) {
			$intEmail = "&#".ord($email[$num]);
		} else {
			$intEmail .= "&#".ord($email[$num]);
		}
	
	$num++;
	}
	return $intEmail;
}

public function alterArray($array, $operation = '') {
	switch ($operation) {
		case 'lower':
			foreach ($array as $op1Num => $op1Data) {
				$array[$op1Num] = strtolower($op1Data);
			}
			break;
		case 'clean':
			foreach ($array as $op2Num => $op2Data) {
				if ($op2Data == null || strlen($op2Data) < 1 || empty($op2Data)) {
					unset($array[$op2Num]);
				}
			}
		break;
		
		default:
			return $array;
	}
	
	return $array;
}

// Enhanced str_ireplace
function stir($seek, $replace, $subject) {

	if (function_exists('str_ireplace')) {
		return str_ireplace($seek, $replace, $subject);
	} else {
		$seek = preg_quote($seek, '#');
		return preg_replace("#".$seek."#i", $replace, $subject);
	}	
}

public function p($string, $toBr = 0, $justParse = 1, $protectMails = 1, $showFormattedTwice = 0, $onShutdown = "") {
// ARGUMENTS :
	# $string = the text you want to format
	
	# $toBr = convert newlines (\n) to <br /> (OPTIONAL) disabled by default
	
	# $justParse = disable it when you indent to print text directly on document. (OPTIONAL) enabled by default
			# in the current mode, it will save your parsed text in some variable (or other storage mode, up to you)
	
	# $protectMails = protect mails via protect() function (OPTIONAL) enabled by default
			# this function will significantly increase size of your text, but it will block mail-bots
	
	# $showFormattedTwice = shows formatted text once more, but in special look (OPTIONAL)
			# then you can also use a constant RP_BUFFER through documents to access that text
			
	# $onShutdown = put here some PHP code (with or without newlines) and it will be executed when script finishes with its work (OPTIONAL)
	
	// The Core
	
	$s = (string) $string;
	
	if (empty($s)) {
		echo "The resource (handle) you specified cannot be found. \n";
		echo "<br /> \n";
		echo "The script will now exit. \n";
		return;
	}
	if (PHP_VERSION <= 4) {
		self::__construct();
	}
	
	// remove the garbage
	// 30th Jan 2010 added Unicode support
	$s = htmlentities($s, ENT_QUOTES, 'UTF-8');
	
	// B a s i c	P a r s e	(M a i n)
	for ($b = 1; $b < count($this->bbc); $b++) {
		$bbcn = '#' . preg_quote($this->bbc[$b], '#') . "(.*)" . preg_quote($this->bbc[$b+1], '#') . '#Uis'; // needle
		$bbcr = $this->rep[$b] . "$1" . $this->rep[++$b]; // replacement
		$s = preg_replace($bbcn, $bbcr, $s);
	}
	
	foreach ($this->xht as $xhtBbc => $xhtHtml) {
		$s = $this->stir($xhtBbc, $xhtHtml, $s);
	}
	// fix invalid link format
	$s = preg_replace("#\[url\](www\..+)\[\/url\]#i", "[url=http://$1]$1[/url]", $s);
	$s = preg_replace("#\[url\=(www\..+)\](.*)\[\/url\]#i", "[url=http://$1]$2[/url]", $s);
	
	// it can't be [php].+ it must be [php]\n.+
	$s = preg_replace("#\[php\]([^\r\n])#i", "[php]\r\n$1", $s);
	// same but for [/php]
	$s = preg_replace("#([^\r\n])\[\/php\]#i", "$1\r\n[/php]", $s);
	
	// remove prepended <?php || <? || php closing tag
	$s = preg_replace("#\[php\](\r\n|(\r\n)+|)((\&lt\;\?php)|(\&lt\;\?))#i", "[php]", $s);
	$s = preg_replace("#(\?\&gt\;)(\r\n|(\r\n)+|)\[\/php\]#i", "[/php]", $s);
	
	// prepend <?php and php closing tag
	$s = preg_replace("#\[php\]#i", "[php]\n<?php", $s);
	$s = preg_replace("#\[\/php\]#i", "?>\n[/php]", $s);
	
	// P a r s e
	$s = preg_replace("#\[url\=(.*)\](.*)\[\/url\]#Ui", "<a href=\"$1\" target=\"_blank\">$2</a>", $s);
	$s = preg_replace("#\[url\](.*)\[\/url\]#Ui", "<a href=\"$1\" target=\"_blank\">$1</a>", $s);
	$s = preg_replace("#\[img\](.*)\[\/img\]#Ui", "<img src=\"$1\" width=\"100%\" alt=\"CriticalWire Image\" />", $s);
	$s = preg_replace("#\[img\=(.*)x(.*)\](.*)\[\/img\]#Ui", "<img width=\"$1\" height=\"$2\" src=\"$3\" alt=\"CriticalWire Image\" />", $s);
	$s = preg_replace("#\[email\=(.*)\](.*)\[\/email\]#Ui", "<a href=\"mailto: $1\">$2</a>", $s);
	$s = preg_replace("#\[email\](.*)\[\/email\]#Ui", "<a href=\"mailto: $1\">$1</a>", $s);
	$s = preg_replace("#\[font\=(.*)\](.*)\[\/font\]#Ui", "<span style=\"font-family: $1;\">$2</span>", $s);
	$s = preg_replace("#\[color\=(\#[0-9A-F]{0,6}|[A-z]+)\](.*)\[\/color\]#Ui", "<span style=\"color: $1;\">$2</span>", $s);
	
	// [php]...[/php] parse
	$s = preg_replace("#\[php\][\n\r|\n](.*)[\n\r|\n]\[\/php\]#Uise", "'<div style=\"width: 80%; overflow: auto; text-align: left; border: 1px solid #CCCCCC; display: block; padding-left: 20px;\">'.highlight_string(html_entity_decode('\\1', ENT_QUOTES), 1).'</div>'", $s);
	// <span> for PHP5, <font> for PHP4
	$s = preg_replace("#\<\/(span|font)\>\[\/php\]#i", "</$1>\n</$1>\n</code><div style=\"display: block;\">", $s);
	// [youtube] code added 30th Jan 2010
	$s = preg_replace("#\[youtube\](.*)\[\/youtube\]#Ui", "<object type=\"application/x-shockwave-flash\" style=\"width:450px; height:366px;\" data=\"http://www.youtube.com/v/$1\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\" /></object>", $s);
	
	
	if (PHP_VERSION >= 5) {
		$highlight_string_type = 'span';
	} else {
		$highlight_string_type = 'font';
	}
	
	$s = preg_replace("#\[php\]\<#i", "</div><code><$highlight_string_type style=\"color: #000000;\">\n<", $s);
	
	// [list]...[/list] parse
	if (preg_match("#\[list\](.*?)\[\/list\]#is", $s)) {
	
		preg_match_all("#\[list\](.*?)\[\/list\]#is", $s, $list);
		$list = $list[1];
		$backupList = $list;
		
		// now seperate lines
		
		foreach ($list as $listNum => $lt) {
			$lt = explode("\n", $lt);
			unset($lt[0], $lt[count($lt)]); // get rid of first/last arrays
			
			foreach ($lt as $ltaNum => $lta) {
				$lta = str_replace("\n", '', $lta);
				$lt[$ltaNum] = '<li>'.$lta.'</li>';
			}
			
			$lt = implode("", $lt);
			$list[$listNum] = '<ul style="list-style-type: square;">' . "\n" . $lt . "\n" . '</ul>';
			
			// replace...
			foreach ($backupList as $backupListNum => $bla) {
				$s = str_replace($bla, $list[$backupListNum], $s);
			}
		}
		$s = $this->stir('[list]<ul', '<ul', $s);
		$s = $this->stir('</ul>[/list]', '</ul>', $s);
	}
	
	// [list=xxx]...[/list] parse
	if (preg_match("#\[list\=([A-z]{1,})\](.*?)\[\/list\]#is", $s)) {
	
		preg_match_all("#\[list\=([A-z]{1,})\](.*)\[\/list\]#Uis", $s, $listd);
		$listd = $listd[2];
		$backupListd = $listd;
		
		foreach ($listd as $listdNum => $ltd) {
			$ltd = explode("\n", $ltd);
			unset($ltd[0], $ltd[count($ltd)]);
			
			foreach ($ltd as $ltdNum => $ltda) {
				$ltda = str_replace("\n", '', $ltda);
				$ltd[$ltdNum] = '<li>'.$ltda.'</li>';
			}
			
			$ltd = implode("", $ltd);
			$listd[$listdNum] = '<ol style="list-style-type: decimal;">' . "\n" . $ltd . "\n" . '</ol>';
			
			foreach ($backupListd as $backupListdNum => $blda) {
				$s = str_replace($blda, $listd[$backupListdNum], $s);
			}
		}

		$s = preg_replace("#\[list\=([A-z]{1,})\]<ol#i", '<ol', $s);
		$s = $this->stir('</ol>[/list]', '</ol>', $s);
	}
	
	// clean empty LISTs
	$s = preg_replace("#\<li\>([\r\n])\<\/li\>#", '', $s);
	
	// fix line formats (neccessary for deparse process)
	$s = $this->stir('</li><li>', "</li>\n<li>", $s);
	
	// E x t r a s
	
	if ($protectMails != 0) {
		
		$mails = preg_match_all("#\<a href\=\"mailto\: (.*)\"\>#Ui", $s, $mailsFound);
		$correctMails = $mailsFound[1];
		
		foreach ($correctMails as $mailNum => $mailContent) {
			$protected = $this->protect($correctMails[$mailNum]);
			$currMail = $correctMails[$mailNum];
			$currMail = str_replace('#', '\#', $currMail);
			
			$s = preg_replace("#\<a href\=\"mailto\: $currMail\"\>#i", "<a href=\"mailto: $protected\">", $s);
		}
		
		$simplemPattern = "#\<a href\=\"mailto\: (.*)\"\>(.*)\@(.*)\<\/a\>#Ui"; // * simplem = simple Mail
		$simplemProtect = preg_match_all($simplemPattern, $s, $simplemFound);
		$simplemImportant = $simplemFound[1];
		$smCount = count($simplemImportant);
		
		for ($csm = 0; $csm < $smCount; $csm++) {
			$this_simplem = $simplemImportant[$csm];
			
			$smExp = explode('&', $this_simplem);
			
			// clean up that array
			foreach ($smExp as $smArNum => $smEntries) {
				$remove = array('#', ';');
				$smExp[$smArNum] = str_replace($remove, NULL, $smExp[$smArNum]);
				
				if (empty($smExp[$smArNum])) {
					unset($smExp[$smArNum]);
				}
			}
			
			foreach ($smExp as $numsNum => $asciiStuff) {
				$smExp[$numsNum] = sprintf('%c', $asciiStuff);
			}
			
			foreach ($smExp as $nonalphanumericNum => $nonAlphanumeric) {
				// quotemeta() nor preg_quote() is not sufficient here
				if ($smExp[$nonalphanumericNum] == '#') {
					$smExp[$nonalphanumericNum] = '\#';
				}
				elseif (!preg_match("#[A-z0-9]#", $smExp[$nonalphanumericNum])) {
					$smExp[$nonalphanumericNum] = '\\'.$smExp[$nonalphanumericNum];
				}
			}
			
			$smExp = implode("", $smExp);
			
			$this_simplem = str_replace('#', '\#', $this_simplem);
			$this_simplem = str_replace('&', '\&', $this_simplem);
			
			$this_replace = str_replace(array('\#', '\&'), array('#', '&'), $this_simplem);
			
			$s = preg_replace("#\<a href\=\"mailto\: $this_simplem\"\>$smExp\<\/a\>#i", "<a href=\"mailto: $this_replace\">$this_replace</a>", $s);
		}
		
	}
	
	if ($toBr != 0) {
		// this following line cleans up rubbish made by previous
		// search & replace actions
		$s = str_replace('<br />', NULL, $s);
		$s = nl2br($s);
		
		// now remove <br /> within [code]...[/code] and [list]...[/list] and [list=*]...[/list]
		// and after that around them too
		// this will REALLY enhance parsed text, especially when viewed through Opera
		$lineBreaks = array(
		0 => array('<code style="white-space: pre;">', '</code>'),
		1 => array('<ul style="list-style-type: square;">', '</ul>'),
		2 => array('<ol style="list-style-type: decimal;">', '</ol>'));
		
		foreach ($lineBreaks as $lbArray) {
			$lb1 = $lbArray[0];
			$lb2 = $lbArray[1];
			$lb1Quoted = preg_quote($lb1, '#');
			$lb2Quoted = preg_quote($lb2, '#');
			$lbNeedle = "#" . $lb1Quoted . "(.+?)" . $lb2Quoted . "#sie";
			
			$s = preg_replace($lbNeedle, "'" . $lb1 . "'.str_replace('<br />', '', str_replace('\\\"', '\"', '$1')).'".$lb2."'", $s);
			
			$s = preg_replace("#\<br \/\>(\r\n)" . $lb1Quoted . "#i", "\n" . $lb1, $s);
			$s = preg_replace("#" . $lb2Quoted . "\<br \/\>#i", $lb2, $s);
			$s = preg_replace("#" . $lb2Quoted . "(\r\n)\<br \/\>#i", $lb2, $s);
			
		}
		
		// some other tags, works in most cases but it's faster
		$s = str_replace('</blockquote><br />', '</blockquote>' . "\n", $s);
		$s = str_replace('<br />' . "\r\n" . '<blockquote>', "\n" . '<blockquote>', $s);
		
	} else {
		// or simply clean!
		$s = str_replace('<br />', NULL, $s);
	}
	
	if ($showFormattedTwice != 0) {
		define('RP_INTERNAL_BUFFER_FOR_TWICE', $s);
		function showFormattedTwice($just_return = 0) {
		
			$layout = array(
			1 => '<div style="border: 3px dashed #003399; display: block; background-color: #F7F7F7; padding-top: 15px; padding-bottom: 15px; padding-left: 25px; padding-right: 25px;">',
			2 => '</div>'
			);
			
			$show = "\n\n" . $layout[1] . "\n\n" . RP_INTERNAL_BUFFER_FOR_TWICE . "\n\n" . $layout[2] . "\n\n";
			
			if ($just_return == 0) {
				echo $show;
			} else {
				return define('RP_BUFFER', $show);
			}
			
		}
		showFormattedTwice(1);
		register_shutdown_function('showFormattedTwice');
	}
	
	// Output
	if ($justParse == 0) {
		echo $s;
	} else {
		return $s;
	}
	
	@eval($onShutdown);
} // p()...

public function deparse($string, $removeBr = 1, $return = 1) {
	
	// DEPARSE CORE
	// This one returns PARSED text to UNPARSED, ORIGINAL text
	// However, it probably won't be ORIGINAL, but it will have the SAME MEANING
	// Example:
	// Before parsing: [email]my@email.com[/email]
	// After parsing/deparsing: [email=my@email.com]my@email.com[/email]
	
	$s = (string) $string;
	
	// D e p a r s e
	// #1 Basic BBcode	
	$bbc = $this->bbc;
	$rep = $this->rep;
	
	for ($i = 1; $i <= count($bbc); $i++) {
		$s = preg_replace("#" . preg_quote($rep[$i], '#') . "(.*)" . preg_quote($rep[$i+1], '#') . "#Uis", 
		$bbc[$i] . "$1" . $bbc[$i+1], $s);
		$i += 1;
	}
	
	foreach ($this->xht as $xhtNum => $xhtCode) {
		$s = $this->stir($xhtCode, $xhtNum, $s);
	}
	
	
	// #3 Advanced BBCode
	$adv = array(
	"[email=$1]$2[/email]" => "\<a href\=\"mailto\: (.*)\"\>(.*)\<\/a\>",
	"[url=$1]$2[/url]" => "\<a href\=\"(.*)\" target\=\"_blank\"\>(.*)\<\/a\>",
	"[img]$1[/img]" => "\<img src\=\"(.*)\" alt\=\"CriticalWire Image\" border\=\"0\" \/\>",
	"[font=$1]$2[/font]" => "\<span style\=\"font\-family\: (.*)\;\"\>(.*)\<\/span\>",
	"[color=$1]$2[/color]" => "\<span style\=\"color\: (.*)\;\"\>(.*)\<\/span\>",
	"[youtube]$1[/youtube]" => "\<object width\=\"425\" height\=\"350\"\>\<embed src\=\"http://www.youtube.com/v/(.*)\" type\=\"application/x-shockwave-flash\" width\=\"425\" height\=\"350\"\>\<\/embed\>\<\/object\>",
	);
	
	// go go go
	foreach ($adv as $adv1 => $adv2) {
		$adv2 = "#".$adv2."#Ui";
		$s = preg_replace($adv2, $adv1, $s);
	}
	
	// now check if eMails were crypted, if so we need to recover them
	if (preg_match("#\[email\=\&\#[0-9]+#i", $s)) {
		
		preg_match_all("#\[email\=(.*)\]#Ui", $s, $mails);
		$mails = $mails[1];
		$mails = array_unique($mails); // crypted
		$recoveredMails = array(); // un-crypted, recovered
		
		foreach ($mails as $cry) {
			$cry = preg_split("#[^0-9]#", $cry);
			$cry = $this->alterArray($cry, 'clean');
			$recovered = '';
			
			foreach ($cry as $nums) {
				$nums = chr($nums);
				$recovered .= $nums;
			}
			
			$recoveredMails[] = $recovered;
		}
		$mails = array_values($mails);
		
		for ($i = 0; $i < count($mails); $i++) {
			$mails[$i] = preg_quote($mails[$i], '#');
			$recMaQuote = preg_quote($recoveredMails[$i], '#');
			
			$s = preg_replace("#\[email\=$mails[$i]\]#i", "[email=$recoveredMails[$i]]", $s);
			$s = preg_replace("#\[email\=$recMaQuote\]$mails[$i]\[\/email\]#", "[email=$recoveredMails[$i]]$recoveredMails[$i][/email]", $s);
		}
		
	}
	
	$s = preg_replace(
	"#\<div style\=\"width\: 80\%\; overflow\: auto\; text\-align\: left\; border\: 1px solid \#CCCCCC\; display\: block\; padding\-left\: 20px\;\"\>(.*)\<\/div\>#Uis",
	"[php]$1[/php]", $s);
	
	if (preg_match("#\[php\](.*?)\[\/php\]#is", $s)) {
		// 1) Collect all [php]...[/php] entries
		// 2) Clean them, keep PHP only
		// 3) Return them clean
		
		preg_match_all("#\[php\](.*)\[\/php\]#Uis", $s, $php);
		$php = $php[1];
		$backupPhp = $php;
		
		foreach ($php as $phpArrayNum => $pc) {
			// *pc stands for PHP Code
			
			$pc = strip_tags($pc);
			$php[$phpArrayNum] = $pc;
			
		}
		
		for ($i = 0; $i < count($php); $i++) {
			$s = $this->stir($backupPhp[$i], $php[$i], $s);
		}
		
		// and finally remove php tags to prevent multiple start/ends tags
		$st = preg_quote('&lt;?php');
		$et = preg_quote('?&gt;');
		$s = preg_replace("#(\[php\])[\r\n]$st#i", "$1", $s);
		$s = preg_replace("#{$et}[\r\n]+(\[\/php\])#i", "$1", $s);
		
	}
	
	// [list]...[/list] && [list={1,}]...[/list]
	$l = array('\<ul style\="list-style-type\: square;"\>', '\</ul\>', '\<ol style\="list-style-type\: decimal;"\>', '\</ol\>');
	$lo = array('<ul style="list-style-type: square;">', '</ul>', '<ol style="list-style-type: decimal;">', '</ol>');
	$o = array('[list]', '[/list]', '[list=dec]');
	
	$s = preg_replace("#" . $l[0] . "(.+?)" . $l[1] . "#sie", "'" . $lo[0] . "'.str_replace(array('<li>', '</li>'), '', '$1').'".$lo[1]."'", $s);
	$s = preg_replace("#" . $l[0] . "(.+?)" . $l[1] . "#si", $o[0] . "$1" . $o[1], $s);
	
	$s = preg_replace("#" . $l[2] . "(.+?)" . $l[3] . "#sie", "'" . $lo[2] . "'.str_replace(array('<li>', '</li>'), '', '$1').'".$lo[3]."'", $s);
	$s = preg_replace("#" . $l[2] . "(.+?)" . $l[3] . "#si", $o[2] . "$1" . $o[1], $s);
	
	
	// get back the garbage 
	$s = html_entity_decode($s, ENT_QUOTES, 'UTF-8');
	
	if ($removeBr > 0) {
		$s = str_replace('<br />', '', $s);
	}
	if ($return > 0) {
		return $s;
	} else {
		echo $s;
	}
	
}

public function security($string) {
	// Recruiting Parser CHECKING TOOL
	// A part of RP Core, no need to include any of RP modules.
	
	// Each function has its own variables, so this (and every other) variable won't interfere
	// with RP's main function - p() .
	$s = (string) $string;
	set_time_limit(300);
	
	if ( (!strpos($s, '[')) || (!strpos($s, ']')) ) {
		// passes
		return true;
	}
	
	// Phase #1 - load all present [*] in array
	preg_match_all("#\[(/{0,1})[A-z]+\]#U", $s, $bbc);
	unset($bbc[1]);
	$bbc = $bbc[0];
	
	// Phase #2 - lowercase all found tags (for caseless searching)
	$bbc = $this->alterArray($bbc, 'lower');
	
	// Phase #3 - filter these which isn't a BBCode
	foreach ($bbc as $num => $ent) {
		if (!in_array($ent, $this->bbc)) {
			unset($bbc[$num]);
		}
	}
	
	// Phase #4 - determine if tag is opneing or closing
	$o = 0; // opening tag
	$c = 0; // closing tag
	
	foreach ($bbc as $tag) {
		if (strpos($tag, '/') === false) {
			// opening tag
			$o++;
		} else {
			// closing tag
			$c++;
		}
	}
	
	
	// Phase #5 - final phase, determine if there's same amount
	// of [/*] and [[^/]*] (and return so)
	
	if ($o == $c) {
		// passes
		return true;
	} else {
		// fails
		return false;
	}
	
}
/*public function update() {
	// Recruiting Parser UPDATING TOOL
	// A part of RP Core, no need to include any of RP modules.
	
	error_reporting(0);
	set_time_limit(0);
	ob_implicit_flush(1);
	
	$ver = $this->rpVersion;
	$url = $this->rpAddr;
	
	// Open RP gates at bbcparser.recgr.com
	$f = @fsockopen($url, 80, $errno, $errstr, 10);
	
	if ($f === false) {
		// try it again
		$verdana = '<span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;">';
		$cverd = '</span>'; // close Verdana
		
		echo "<p style=\"font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif;\"><strong>Connection failure</strong> - but 
		Recruiting Parser will try 3 more times:</p> \n\n";
		sleep(5);
		
		for ($call = 1; $call < 4; $call++) {
			// 1, 2, 3  NOT 1, 2, 3, 4 - it would be <= 4 then
			if ($f !== false) {
				break;
			} else {
				echo "<p>$verdana try #$call (<span style=\"color: #CE0000;\">failure</span>) $cverd </p> \n";
				if ($call < 3) {
					sleep(5);
				}
			}
			if ($call == 3) {
				echo "<p style=\"font-size: 11px; font-weight: bold; font-family: Verdana, Arial, sans-serif;\">CONNECTION WAS NOT ESTABLISHED !</p> \n\n";
			}
		}
	}
	if ($f === false) {
		$gt = '<span style="font-family: Arial, Verdana, sans-serif; font-size: 9px;">&gt;</span> ';
		// still FALSE? then break.
		echo "<h1 style=\"font-family: 'Arial Black', Arial, Helvetica, sans-serif; letter-spacing: 5px;\">Error</h1> \n\n";
		echo "Checking for a new version failed! <br /> \n";
		echo "Your current version of Recruiting Parser is <strong>$ver</strong>, but RP couldn't connect
		to <em>$url</em> and check if this is the latest version. <br /> \n";
		echo "To do it manually, please go to <em>http://$url</em>. <br /> <br /> \n";
		echo "<strong style=\"font-variant: small-caps; letter-spacing: 1px; font-family: Verdana, Arial, sans-serif;\">
		Possible Reasons Why Recruiting Parser Couldn't Connect to $url :</strong>
		<br /> \n";
		echo $gt . "you are not connected to Internet <br />\n";
		echo $gt . "you are not permitted to access to connect to remote location, probably because of Firewall <br/>\n";
		echo $gt . "<em>$url</em> is currently down <br />\n";
		if ($errstr != "") {
			echo $gt . $errstr . "<small><em>&nbsp;&nbsp;&nbsp;(error No. <strong>".$errno."</strong>)</em></small> \n";
		}
		echo '<p style="font-size: small; font-style: italic; margin-left: 55px;">the script will now exit...</p>' . "\n\n";
		
	} else {
		
		// so let exchange data with RECGR
		$http_host = $_SERVER['HTTP_HOST'];
		$php_version = constant('PHP_VERSION');
		$protocol = $_SERVER['SERVER_PROTOCOL'];
		
		if (!preg_match("#^http\/[\d]$#i", $protocol)) {
			$protocol = 'HTTP/1.1';
		}
		
		$header = "";
		$header .= "GET / $protocol\r\n";
		$header .= "Host: $url\r\n";
		$header .= "User-Agent: Recruiting Parser/$ver\r\n";
		$header .= "Client-Host: $http_host\r\n";
		$header .= "Client-Php: $php_version\r\n";
		$header .= "Connection: Close\r\n\r\n";
		
		fputs($f, $header);
		stream_set_timeout($f, 10);
		
		// prevent infinite loop etc (si = socket info)
		$si = stream_get_meta_data($f);
		
		if ($si['timed_out'] === true) {
			echo '<span style="color: #FF3333;">TIMED OUT: you should retry the update.</span>' . "\n";
			die();
		} elseif ($si['eof'] === true) {
			echo "Data received from $url is empty. Please try later. \n";
			die();
		}
		
		ob_start();
		while (!feof($f)) {
			echo fgets($f);
		}
		$infoTransferred = ob_get_contents();
		ob_end_clean();
		
		$ifPrepare = preg_match("#\[data\](.*)\[\/data\]#s", $infoTransferred, $foundNonPrepared);
		echo $foundNonPrepared[1];
		unset($infoTransferred, $foundNonPrepared);
		
		fclose($f);
	}
	
}*/

function __destruct() {
	if (defined("HAVENT_RUN")) return;
/*	if ( (!defined("RUNS")) || ($this->codeline != base64_decode(constant("RUNS"))) ) {
		echo base64_decode(constant("DOESNT_RUN"));
		die();
	}*/
} // __destruct()...
} // parser...



		/*
		
		>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<
		>>> END OF RECRUITING PARSER APPLICATION <<<
		>>> Thanks for using. For any questions  <<<
		>>> merely visit:                        <<<
		>>>      http://bbcparser.recgr.com      <<<
		>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<
		
		*/

?>