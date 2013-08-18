<? 
/***************************************************************************
 *                               newsletters.php
 *                            -------------------
 *   begin                : Tuseday, March 14, 2006
 *   copyright            : (C) 2006 Fast Track Sites
 *   email                : sales@fasttracksites.com
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

if ($_SESSION['user_level'] == ADMIN || $_SESSION['user_level'] == MOD) {
	//==================================================
	// Handle editing, adding, and deleting of newsletters
	//==================================================	
	if ($actual_action == "newnewsletter") {
		if (isset($_POST['submit'])) {
			$sql = "INSERT INTO `" . DBTABLEPREFIX . "newsletters` (`title`, `content`) VALUES ('" . keeptasafe($_POST['newslettertitle']) . "', '" . keeptasafe($_POST['newslettercontent']) . "')";
			$result = mysql_query($sql);
			
			if ($result) {
				$content = "
							<center>Your newsletter has been added, and you are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"1;url=" . $menuvar['NEWSLETTERS'] . "\">";
			}
			else {
				$content = "
							<center>There was an error while creating your newsletter. You are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"5;url=" . $menuvar['NEWSLETTERS'] . "\">";						
			}
		}
		else {
			$content .= "
					<div class=\"roundedBox\">
						<form name=\"newnewsletterform\" id=\"newnewsletterform\" action=\"" . $menuvar['NEWSLETTERS'] . "&action=newnewsletter&style=" . $actual_style . "\" method=\"post\">
							<table class=\"contentBox\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">
								<tr>
									<td class=\"title1\" colspan=\"2\">New Newsletter</td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Title:</strong></td><td><input name=\"newslettertitle\" type=\"text\" size=\"60\" /></td>
								</tr>
								<tr class=\"row1\">
									<td colspan=\"2\">
										<textarea id=\"newslettercontent\" name=\"newslettercontent\" class=\"wysiwygbox\" rows=\"10\" cols=\"58\"></textarea>
									</td>
								</tr>
							</table>
							<br />
							<center><input type=\"submit\" name=\"submit\" class=\"button\" value=\"Create Newsletter\" /> <input type=\"button\" name=\"preview\" class=\"button\" value=\"Preview Newsletter\" onclick=\"ajaxShowNewsletterPreview('newslettercontent', 'updateMe'); return false;\" /></center>
							<script type=\"text/javascript\">
								tinyMCE.init({
									// General options
									mode : \"textareas\",
									theme : \"advanced\",
									plugins : \"safari,pagebreak,style,layer,table,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template\",

									// Theme options
									theme_advanced_buttons1 : \"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect\",
									theme_advanced_buttons2 : \"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor\",
									theme_advanced_buttons3 : \"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen\",
									theme_advanced_buttons4 : \"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak\",
									theme_advanced_toolbar_location : \"top\",
									theme_advanced_toolbar_align : \"left\",
									theme_advanced_statusbar_location : \"bottom\",
									theme_advanced_resizing : true,

									// Drop lists for link/image/media/template dialogs
									template_external_list_url : \"lists/template_list.js\",
									external_link_list_url : \"lists/link_list.js\",
									external_image_list_url : \"lists/image_list.js\",
									media_external_list_url : \"lists/media_list.js\"
								});
							</script>
						</form>
						<br /><br />
						<div id=\"updateMe\"></div>
					</div>";
		}
	}	
	elseif ($actual_action == "editnewsletter" && isset($actual_id)) {
		if (isset($_POST['submit'])) {
			$sql = "UPDATE `" . DBTABLEPREFIX . "newsletters` SET title = '" . keeptasafe($_POST['newslettertitle']) . "', content = '" . keeptasafe($_POST['newslettercontent']) . "' WHERE id = '" . $actual_id . "'";
			$result = mysql_query($sql);
			
			if ($result) {
				$content = "
							<center>Your newsletter has been updated, and you are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"1;url=" . $menuvar['NEWSLETTERS'] . "\">";
			}
			else {
				$content = "
							<center>There was an error while updating your newsletter. You are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"5;url=" . $menuvar['NEWSLETTERS'] . "\">";						
			}
		}
		else {
			$sql = "SELECT * FROM `" . DBTABLEPREFIX . "newsletters` WHERE id = '" . $actual_id . "' LIMIT 1";
			$result = mysql_query($sql);
			
			if (mysql_num_rows($result) == 0) {
				$content = "
							<center>There was an error while accessing the newsletter you are trying to update. You are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"5;url=" . $menuvar['NEWSLETTERS'] . "\">";	
			}
			else {
				$row = mysql_fetch_array($result);

				$content .= "
						<div class=\"roundedBox\">
							<form name=\"newnewsletterform\" id=\"newnewsletterform\" action=\"" . $menuvar['NEWSLETTERS'] . "&action=editnewsletter&id=" . $row['id'] . "\" method=\"post\">
								<table class=\"contentBox\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">
									<tr>
										<td class=\"title1\" colspan=\"2\">Edit Newsletter</td>
									</tr>
									<tr class=\"row2\">
										<td><strong>Title:</strong></td><td><input name=\"newslettertitle\" type=\"text\" size=\"60\" value=\"" . $row['title'] . "\" /></td>
									</tr>
									<tr class=\"row1\">
										<td colspan=\"2\">
											<textarea id=\"newslettercontent\" name=\"newslettercontent\" class=\"wysiwygbox\" rows=\"10\" cols=\"58\">" . $row['content'] . "</textarea>
										</td>
									</tr>
								</table>								
							<br />
							<center><input type=\"submit\" name=\"submit\" class=\"button\" value=\"Update Newsletter\" /> <input type=\"button\" name=\"preview\" class=\"button\" value=\"Preview Newsletter\" onclick=\"ajaxShowNewsletterPreview('newslettercontent', 'updateMe'); return false;\" /></center>
							<script type=\"text/javascript\">
								tinyMCE.init({
									// General options
									mode : \"textareas\",
									theme : \"advanced\",
									plugins : \"safari,pagebreak,style,layer,table,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template\",

									// Theme options
									theme_advanced_buttons1 : \"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect\",
									theme_advanced_buttons2 : \"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor\",
									theme_advanced_buttons3 : \"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen\",
									theme_advanced_buttons4 : \"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak\",
									theme_advanced_toolbar_location : \"top\",
									theme_advanced_toolbar_align : \"left\",
									theme_advanced_statusbar_location : \"bottom\",
									theme_advanced_resizing : true,

									// Drop lists for link/image/media/template dialogs
									template_external_list_url : \"lists/template_list.js\",
									external_link_list_url : \"lists/link_list.js\",
									external_image_list_url : \"lists/image_list.js\",
									media_external_list_url : \"lists/media_list.js\"
								});
							</script>
						</form>
						<br /><br />
						<div id=\"updateMe\"></div>
					</div>";							
			}			
		}
	}
	else {		
		//==================================================
		// Print out our newsletters table
		//==================================================
		$sql = "SELECT * FROM `" . DBTABLEPREFIX . "newsletters` ORDER BY id DESC";
		$result = mysql_query($sql);
		
		$x = 1; //reset the variable we use for our row colors	
		
		$content .= "
					<div class=\"roundedBox\">
						<table class=\"contentBox\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">
							<tr>
								<td class=\"title1\" colspan=\"2\">
									<div style=\"float: right;\"><a href=\"" . $menuvar['NEWSLETTERS'] . "&action=newnewsletter\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/add.png\" alt=\"Add a newsletter\" /></a></div>
									Current Newsletters
								</td>
							</tr>							
							<tr class=\"title2\">
								<td><strong>Newsletter Title</strong></td><td></td>
							</tr>";
							
		// Print out or list of newsletters
		if (!$result || mysql_num_rows($result) == 0) {
			$content .=	"
								<tr class=\"row1\">
									<td colspan=\"2\">There are no newletters in the system currently, please add on.</td>
								</tr>";
		}
		else {
			while ($row = mysql_fetch_array($result)) {
				$content .=	"
								<tr id=\"" . $row['id'] . "_row\" class=\"row" . $x . "\">
									<td>" . $row['title'] . "</td>
									<td>
										<center><a href=\"" . $menuvar['NEWSLETTERS'] . "&action=editnewsletter&id=" . $row['id'] . "\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/check.png\" alt=\"Edit\" /></a> <a href=\"#\" onclick=\"ajaxDeleteNotifier('" . $row['id'] . "NewsletterSpinner', 'ajax.php?action=deleteitem&table=newsletters&id=" . $row['id'] . "', 'newsletter', '" . $row['id'] . "_row');\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/delete.png\" alt=\"Delete\" /></a><span id=\"" . $row['id'] . "NewsletterSpinner\" style=\"display: none;\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/indicator.gif\" alt=\"spinner\" /></span></center>
									</td>
								</tr>";
				$x = ($x==2) ? 1 : 2;
			}
			mysql_free_result($result);
		}
	
		$content .=	"
							</table>
						</div>";
	}
	$page->setTemplateVar('PageContent', $content);
}
else {
	$page->setTemplateVar('PageContent', "\nYou Are Not Authorized To Access This Area. Please Refrain From Trying To Do So Again.");
}
?>