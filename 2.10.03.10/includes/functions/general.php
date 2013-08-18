<?php 
/***************************************************************************
 *                               gneral.php
 *                            -------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2005 Paden Clayton - Fast Track Sites
 *   email                : sales@fasttacksites.com
 *
 *
 ***************************************************************************/

/***************************************************************************
Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of the <organization> nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 ***************************************************************************/

	//==================================================
	// Strips Dangerous tags out of input boxes 
	//==================================================
	function keepsafe($makesafe) {
		$makesafe=strip_tags($makesafe); // strip away any dangerous tags
		$makesafe=str_replace(" ","",$makesafe); // remove spaces from variables
		$makesafe=str_replace("%20","",$makesafe); // remove escaped spaces
		$makesafe = trim(preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', '"&#".ord($0).";"', $makesafe)); //encodes all ascii items above #127
	
	    // Stripslashes
	    if (get_magic_quotes_gpc()) {
	        $makesafe = stripslashes($makesafe);
	    }
	    // Quote if not integer
	    if (!is_numeric($makesafe)) {
	        $makesafe = mysql_real_escape_string($makesafe);
	    }
	    return $makesafe;
	}
	
	//==================================================
	// Strips Dangerous tags out of textareas 
	//==================================================
	function keeptasafe($makesafe) {
		$makesafe = trim(preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', '"&#".ord($0).";"', $makesafe)); //encodes all ascii items above #127
		
	    // Stripslashes
	    if (get_magic_quotes_gpc()) {
	        $makesafe = stripslashes($makesafe);
	    }
	    // Quote if not integer
	    if (!is_numeric($makesafe)) {
	        $makesafe = mysql_real_escape_string($makesafe);
	    }
	    return $makesafe;
	}
	
	//==================================================
	// Strips Dangerous tags out of get and post values
	//==================================================
	function parseurl($makesafe) {
		$makesafe=strip_tags($makesafe); // strip away any dangerous tags
		$makesafe=str_replace(" ","",$makesafe); // remove spaces from variables
		$makesafe=str_replace("%20","",$makesafe); // remove escaped spaces
		$makesafe = trim(preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', '"&#".ord($0).";"', $makesafe)); //encodes all ascii items above #127
	
	    // Stripslashes
	    if (get_magic_quotes_gpc()) {
	        $makesafe = stripslashes($makesafe);
	    }
	    // Quote if not integer
	    if (!is_numeric($makesafe)) {
	        $makesafe = mysql_real_escape_string($makesafe);
	    }
	    return $makesafe;
	}
	
	//==================================================
	// Creates a date from a timestamp
	//==================================================
	function make_date($time) {
		$date = @gmdate('M d, Y', $time + (3600 * '-7.00')); // Makes date in the format of: Thursday July 5, 2006 3:30 pm
		return $date;
	}
	
	//==================================================
	// Returns the last item in an array
	//==================================================	
	function returnLastItem($array) {
		return $array[count($array) - 1];
	}
	
	//==================================================
	// Creates a string from the given 
	// array(exploded on .)
	//==================================================	
	function recreateArray($array) {
		global $array;
		for ($x = 0; $x < count($$array) - 1; $x++) {
			$returnVar = $returnVar .= "." . $array[$x];
		}
		return $returnVar;
	}
	
	//=================================================
	// BBCode Functions Generated from: 
	// http://bbcode.strefaphp.net/bbcode.php
	// A gigantic thanks goes out to the 
	// programmers there!!
	// 
	// Use the function like so: echo bbcode($string);
	//=================================================
	Function bbcode($str){
		// Makes < and > page friendly
		//$str=str_replace("&","&amp;",$str);
		$str=str_replace("<","&lt;",$str);
		$str=str_replace(">","&gt;",$str);
		
		// Link inside tags new window
		$str = preg_replace("#\[url\](.*?)?(.*?)\[/url\]#si", "<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</a>", $str);
		
		// Link inside first tag new window
		$str = preg_replace("#\[url=(.*?)?(.*?)\](.*?)\[/url\]#si", "<a href=\"\\2\" target=\"_blank\">\\3</a>", $str);
		
		// Link inside tags
		$str = preg_replace("#\[url2\](.*?)?(.*?)\[/url2\]#si", "<a href=\"\\1\\2\">\\1\\2</a>", $str);
		
		// Link inside first tag
		$str = preg_replace("#\[url2=(.*?)?(.*?)\](.*?)\[/url2\]#si", "<a href=\"\\2\">\\3</a>", $str);
		
		// Lightbox Image Link
		$str = preg_replace("#\[lightbox=(.*?)?(.*?)\](.*?)\[/lightbox\]#si", "<a href=\"\\2\" rel=\"lightbox\"><img src=\"\\3\" alt=\"lightbox image\" /></a>", $str);
		
		// Automatic links if no url tags used
		$str = preg_replace_callback("#([\n ])([a-z]+?)://([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]+)#si", "bbcode_autolink", $str);
		$str = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]*)?)#i", " <a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $str);
		$str = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)#i", "\\1<a href=\"mailto: \\2@\\3\">\\2_(at)_\\3</a>", $str);
		
		// PHP Code
		$str = preg_replace("#\[php\](.*?)\[/php]#si", "<div class=\"codetop\"><u><strong>&lt?PHP:</strong></u></div><div class=\"codemain\">\\1</div>", $str);
		
		// Bold
		$str = preg_replace("#\[b\](.*?)\[/b\]#si", "<strong>\\1</strong>", $str);
		
		// Italics
		$str = preg_replace("#\[i\](.*?)\[/i\]#si", "<em>\\1</em>", $str);
		
		// Underline
		$str = preg_replace("#\[u\](.*?)\[/u\]#si", "<u>\\1</u>", $str);
		
		// Alig text
		$str = preg_replace("#\[align=(left|center|right)\](.*?)\[/align\]#si", "<div align=\"\\1\">\\2</div>", $str); 
		
		// Font Color
		$str = preg_replace("#\[color=(.*?)\](.*?)\[/color\]#si", "<span style=\"color:\\1\">\\2</span>", $str);
		
		// Font Size
		$str = preg_replace("#\[size=(.*?)\](.*?)\[/size\]#si", "<span style=\"font-size:\\1\">\\2</span>", $str);
		
		// Image
		$str = preg_replace("#\[img\](.*?)\[/img\]#si", "<img src=\"\\1\" border=\"0\" alt=\"\" />", $str);
		
		// Uploaded image
		$str = preg_replace("#\[ftp_img\](.*?)\[/ftp_img\]#si", "<img src=\"img/\\1\" border=\"0\" alt=\"\" />", $str);
		
		// HR Line
		$str = preg_replace("#\[hr=(\d{1,2}|100)\]#si", "<hr class=\"linia\" width=\"\\1%\" />", $str);
		
		// Code
		$str = preg_replace("#\[code\](.*?)\[/code]#si", "<div class=\"codetop\"><u><strong>Code:</strong></u></div><div class=\"codemain\">\\1</div>", $str);
		
		// Code, Provide Author
		$str = preg_replace("#\[code=(.*?)\](.*?)\[/code]#si", "<div class=\"codetop\"><u><strong>Code \\1:</strong></u></div><div class=\"codemain\">\\2</div>", $str);
		
		// Quote
		$str = preg_replace("#\[quote\](.*?)\[/quote]#si", "<div class=\"quotetop\"><u><strong>Quote:</strong></u></div><div class=\"quotemain\">\\1</div>", $str);
		
		// Quote, Provide Author
		$str = preg_replace("#\[quote=(.*?)\](.*?)\[/quote]#si", "<div class=\"quotetop\"><u><strong>Quote \\1:</strong></u></div><div class=\"quotemain\">\\2</div>", $str);
		
		// Email
		$str = preg_replace("#\[email\]([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#i", "<a href=\"mailto:\\1@\\2\">\\1@\\2</a>", $str);
		
		// Email, Provide Author
		$str = preg_replace("#\[email=([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)?(.*?)\](.*?)\[/email\]#i", "<a href=\"mailto:\\1@\\2\">\\5</a>", $str);
		
		// YouTube
		$str = preg_replace("#\[youtube\]http://(?:www\.)?youtube.com/v/([0-9A-Za-z-_]{11})[^[]*\[/youtube\]#si", "<object width=\"425\" height=\"350\"><param name=\"movie\" value=\"http://www.youtube.com/v/\\1\"></param><param name=\"wmode\" value=\"transparent\"></param><embed src=\"http://www.youtube.com/v/\\1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"425\" height=\"350\"></embed></object>", $str);
		$str = preg_replace("#\[youtube\]http://(?:www\.)?youtube.com/watch\?v=([0-9A-Za-z-_]{11})[^[]*\[/youtube\]#si", "<object width=\"425\" height=\"350\"><param name=\"movie\" value=\"http://www.youtube.com/v/\\1\"></param><param name=\"wmode\" value=\"transparent\"></param><embed src=\"http://www.youtube.com/v/\\1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"425\" height=\"350\"></embed></object>", $str);
		
		// Google Video
		$str = preg_replace("#\[gvideo\]http://video.google.[A-Za-z0-9.]{2,5}/videoplay\?docid=([0-9A-Za-z-_]*)[^[]*\[/gvideo\]#si", "<object width=\"425\" height=\"350\"><param name=\"movie\" value=\"http://video.google.com/googleplayer.swf\?docId=\\1\"></param><param name=\"wmode\" value=\"transparent\"></param><embed src=\"http://video.google.com/googleplayer.swf\?docId=\\1\" type=\"application/x-shockwave-flash\" allowScriptAccess=\"sameDomain\" quality=\"best\" bgcolor=\"#ffffff\" scale=\"noScale\" salign=\"TL\"  FlashVars=\"playerMode=embedded\" wmode=\"transparent\" width=\"425\" height=\"350\"></embed></object>", $str);
		
		// Ordered Lists
		$str = preg_replace("#\[olist\](.*?)\[/olist\]#si", "<ol>\\1</ol>", $str);
		
		// Unordered Lists
		$str = preg_replace("#\[list\](.*?)\[/list\]#si", "<ul>\\1</ul>", $str);
		
		// List Items
		$str = preg_replace("#\[item\](.*?)\[/item\]#si", "<li>\\1</li>", $str);
		
		// change \n to <br />
		$str=nl2br($str);
		
		// return bbdecoded string
		return $str;
	}
	
	
	function bbcode_autolink($str) {
	$lnk=$str[3];
	if(strlen($lnk)>30){
	if(substr($lnk,0,3)=='www'){$l=9;}else{$l=5;}
	$lnk=substr($lnk,0,$l).'(...)'.substr($lnk,strlen($lnk)-8);}
	return ' <a href="'.$str[2].'://'.$str[3].'" target="_blank">'.$str[2].'://'.$lnk.'</a>';
	}
	
	//==================================================
	// Replacement for die()
	// Used to display msgs without displaying the board
	//==================================================
	function message_die($msg_text = '', $msg_title = '') {
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";
		include('includes/footer.php');
		exit;
	}
	
	//=========================================================
	// Check if this item should be selected
	//=========================================================
	function testSelected($testFor, $testAgainst) {
		if ($testFor == $testAgainst) { return " selected=\"selected\""; }
	}
	
	//=========================================================
	// Check if this item should be selected
	//=========================================================
	function testChecked($testFor, $testAgainst) {
		if ($testFor == $testAgainst) { return " checked"; }
	}
	
	//=========================================================
	// Gets a list of models based on a type string
	//=========================================================
	function createDropdown($type, $inputName, $currentSelection = "", $onChange = "", $className = "") {
		global $pns_config;
		
		$onChangeVar = ($onChange == "") ? "" : " onChange=\"" . $onChange . "\"";
		$classNameVar = ($className == "") ? "" : " class=\"" . $className . "\"";
		$dropdown = "<select name=\"" . $inputName . "\" id=\"" . $inputName . "\"" . $classNameVar . $onChangeVar . ">
						<option value=\"\">--Select One--</option>";
						
		if ($type == "contactcategories") {
			$sql = "SELECT * FROM `" . DBTABLEPREFIX . "contactcategories` ORDER BY name";
			$result = mysql_query($sql);
		
			if ($result && mysql_num_rows($result) > 0) {
				while ($row = mysql_fetch_array($result)) {
					$dropdown .= "<option value=\"" . $row['id'] . "\"" . testSelected($row['id'], $currentSelection) . ">" . $row['name'] . "</option>";
				}
				mysql_free_result($result);
			}
		}	
		if ($type == "contactcategoriesforsending") {
			$dropdown .= "<option value=\"allUsers\"" . testSelected("allUsers", $currentSelection) . ">All Users</option>";
		
			$sql = "SELECT * FROM `" . DBTABLEPREFIX . "contactcategories` ORDER BY name";
			$result = mysql_query($sql);
			
			if ($result && mysql_num_rows($result) > 0) {
				while ($row = mysql_fetch_array($result)) {
					$dropdown .= "<option value=\"" . $row['id'] . "\"" . testSelected($row['id'], $currentSelection) . ">" . $row['name'] . "</option>";
				}
				mysql_free_result($result);
			}
		}
		if ($type == "newsletters") {
			$sql = "SELECT id, title FROM `" . DBTABLEPREFIX . "newsletters` ORDER BY title";
			$result = mysql_query($sql);
					
			if ($result && mysql_num_rows($result) > 0) {
				while ($row = mysql_fetch_array($result)) {
					$dropdown .= "<option value=\"" . $row['id'] . "\"" . testSelected($row['id'], $currentSelection) . ">" . $row['title'] . "</option>";
				}
				mysql_free_result($result);
			}
		}
		if ($type == "users") {
			$sql = "SELECT id, email_address, users_first_name, users_last_name FROM `" . USERSDBTABLEPREFIX . "users` ORDER BY users_last_name";
			$result = mysql_query($sql);
					
			if ($result && mysql_num_rows($result) > 0) {
				while ($row = mysql_fetch_array($result)) {
					$dropdown .= "<option value=\"" . $row['id'] . "\"" . testSelected($row['id'], $currentSelection) . ">" . $row['users_last_name'] . ", " . $row['users_first_name'] . " (" . $row['email_address'] . ")</option>";
				}
				mysql_free_result($result);
			}
		}
		
		$dropdown .= "</select>";	
		
		return $dropdown;	
	}
		
	//=========================================================
	// Sends an email message using the supplied values
	//=========================================================
	function emailMessage($emailAddress, $subject, $message) {
		global $pns_config;
		
		$headers = "";
		
		// Additional headers
		//$headers .= "To: " . $emailAddress . "\n";
		$headers .= "From: " . $pns_config['ftspns_email_address'] . "\n";
		
		// To send HTML mail, the content-type header must be set
		$headers .= "MIME-Version: 1.0" . "\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		
		// Mail it
		$emailResult = mail($emailAddress, $subject, $message, $headers);
		
		if ($emailResult) {
			return 1;
		}
		else {
			return 0;
		}
	}

	//=========================================================
	// Allows us to get any remote file we need with post vars
	//=========================================================	
	function returnRemoteFilePost($host, $directory, $filename, $urlVariablesArray = array()) {
		$result = "";
	
		$urlVariables = array();    
		foreach($urlVariablesArray as $key=>$value) {
	        $urlVariables[] = $key . "=" . urlencode($value);
	    }  
		$urlVariables = implode('&', $urlVariables);

		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, "http://" . $host . "/" . $directory . "/" . $filename);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $urlVariables);
		
		//execute post
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		
		//close connection
		curl_close($ch);		
		
		return $result;
	}
	
	//==================================================
	// This function will notify user of updates and
	// other important information
	//
	// USAGE:
	// version_functions();
	// 
	// Removal or hinderance is a direct violation of 
	// the program license and is constituted as a 
	// breach of contract as is punishable by law.
	//
	// MODIFIED TO REMOVE CALLHOME AND VERSION CHECK
	//==================================================
	function version_functions($print_update_info) {
		include('_license.php');
		
		//=========================================================
		// Get all of the variables we need to pass to the 
		// call home script ready
		//=========================================================
		
			
		//=========================================================
		// Should we display advanced option?
		// Connection to the FTS server has to be made or the 
		// options will not be shown
		//=========================================================
		if ($print_update_info == "advancedOptions" || $print_update_info == "advancedOptionsText") {
			return true;
		}
			
		//=========================================================
		// Should we print out wether or not to update?
		//=========================================================
		if ($print_update_info == "yes") {
			//return "<div class=\"errorMessage\">Version check connection failed.</div>";
		}
	}

?>