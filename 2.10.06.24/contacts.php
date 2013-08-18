<? 
/***************************************************************************
 *                               contacts.php
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

if ($_SESSION['user_level'] == ADMIN) {
	//==================================================
	// Handle editing, adding, and deleting of contacts
	//==================================================	
	if ($actual_action == "newcontact") {
		if (isset($_POST['submit'])) {
			$sql = "INSERT INTO `" . DBTABLEPREFIX . "contacts` (`cat_id`, `first_name`, `last_name`, `street_1`, `street_2`, `city`, `state`, `zip`, `day_phone`, `day_phone_ext`, `night_phone`, `night_phone_ext`, `fax`, `email_address`, `website`) VALUES ('" . keepsafe($_POST['id']) . "', '" . keepsafe($_POST['first_name']) . "', '" . keeptasafe($_POST['last_name']) . "', '" . keeptasafe($_POST['street_1']) . "', '" . keeptasafe($_POST['street_2']) . "', '" . keeptasafe($_POST['city']) . "', '" . keepsafe($_POST['state']) . "', '" . keepsafe($_POST['zip']) . "', '" . keeptasafe($_POST['day_phone']) . "', '" . keepsafe($_POST['day_phone_ext']) . "', '" . keeptasafe($_POST['night_phone']) . "', '" . keepsafe($_POST['night_phone_ext']) . "', '" . keeptasafe($_POST['fax']) . "', '" . keepsafe($_POST['email_address']) . "', '" . keepsafe($_POST['website']) . "')";
			$result = mysql_query($sql);
				
			if ($result) {
				$content = "<center>Your new contact has been added, and you are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"1;url=" . $menuvar['CONTACTS'] . "\">";
			}
			else {
				$content = "<center>There was an error while creating your new contact. You are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"5;url=" . $menuvar['CONTACTS'] . "\">";						
			}
		}
		else {
			$content .= "
					<div class=\"roundedBox\">
						<form name=\"newcontactform\" action=\"" . $menuvar['CONTACTS'] . "&amp;action=newcontact\" method=\"post\">
							<table class=\"contentBox\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">
								<tr>
									<td class=\"title1\" colspan=\"2\">Add A New Contact</td>
								</tr>
								<tr class=\"row1\">
									<td><strong>First Name:</strong></td><td><input name=\"first_name\" type=\"text\" size=\"60\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Last Name:</strong></td><td><input name=\"last_name\" type=\"text\" size=\"60\" /></td>
								</tr>
								<tr class=\"row1\">
									<td><strong>Contact Category:</strong></td><td>" . createDropdown("contactcategories", "id", "", "") . "</td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Address:</strong></td>
									<td>
										<input name=\"street_1\" type=\"text\" size=\"60\" /><br />
										<input name=\"street_2\" type=\"text\" size=\"60\" />
									</td>
								</tr>
								<tr class=\"row1\">
									<td><strong>City:</strong></td><td><input name=\"city\" type=\"text\" size=\"60\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>State:</strong></td><td><input name=\"state\" type=\"text\" size=\"60\" /></td>
								</tr>
								<tr class=\"row1\">
									<td><strong>Zip Code:</strong></td><td><input name=\"zip\" type=\"text\" size=\"60\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Daytime Phone Number:</strong></td><td><input name=\"day_phone\" type=\"text\" size=\"60\" /> ext. <input name=\"day_phone_ext\" type=\"text\" size=\"10\" /></td>
								</tr>
								<tr class=\"row1\">
									<td><strong>Nighttime Phone Number:</strong></td><td><input name=\"night_phone\" type=\"text\" size=\"60\" /> ext. <input name=\"night_phone_ext\" type=\"text\" size=\"10\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Fax:</strong></td><td><input name=\"fax\" type=\"text\" size=\"60\" /></td>
								</tr>
								<tr class=\"row1\">
									<td><strong>Email Address:</strong></td><td><input name=\"email_address\" type=\"text\" size=\"60\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Website:</strong></td><td><input name=\"website\" type=\"text\" size=\"60\" /></td>
								</tr>
							</table>
							<br />
							<center><input type=\"submit\" name=\"submit\" class=\"button\" value=\"Add Contact\" /></center>
						</form>
					</div>";
		}
	}	
	elseif ($actual_action == "editcontact" && isset($actual_id)) {
		if (isset($_POST['submit'])) {
			$sql = "UPDATE `" . DBTABLEPREFIX . "contacts` SET cat_id = '" . keepsafe($_POST['id']) . "', first_name = '" . keepsafe($_POST['first_name']) . "', last_name = '" . keeptasafe($_POST['last_name']) . "', street_1 = '" . keeptasafe($_POST['street_1']) . "', street_2 = '" . keeptasafe($_POST['street_2']) . "', city = '" . keeptasafe($_POST['city']) . "', state = '" . keepsafe($_POST['state']) . "', zip = '" . keepsafe($_POST['zip']) . "', day_phone = '" . keeptasafe($_POST['day_phone']) . "', day_phone_ext = '" . keepsafe($_POST['day_phone_ext']) . "', night_phone = '" . keeptasafe($_POST['night_phone']) . "', night_phone_ext = '" . keepsafe($_POST['night_phone_ext']) . "', fax = '" . keeptasafe($_POST['fax']) . "', email_address = '" . keepsafe($_POST['email_address']) . "', website = '" . keepsafe($_POST['website']) . "' WHERE id = '" . $actual_id . "'";
			$result = mysql_query($sql);
			
			if ($result) {
				$content = "<center>Your contact's details have been updated, and you are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"1;url=" . $menuvar['CONTACTS'] . "\">";
			}
			else {
				$content = "<center>There was an error while updating your contact's details. You are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"5;url=" . $menuvar['CONTACTS'] . "\">";						
			}
		}
		else {
			$sql = "SELECT * FROM `" . DBTABLEPREFIX . "contacts` WHERE id = '" . $actual_id . "' LIMIT 1";
			$result = mysql_query($sql);
			
			if (mysql_num_rows($result) == 0) {
				$content = "<center>There was an error while accessing the contact's details you are trying to update. You are being redirected to the main page.</center>
							<meta http-equiv=\"refresh\" content=\"5;url=" . $menuvar['CONTACTS'] . "\">";	
			}
			else {
				$row = mysql_fetch_array($result);
				
				$content .= "
					<div class=\"roundedBox\">
						<form name=\"newpageform\" action=\"" . $menuvar['CONTACTS'] . "&amp;action=editcontact&amp;id=" . $row['id'] . "\" method=\"post\">
							<table class=\"contentBox\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">
								<tr>
									<td class=\"title1\" colspan=\"2\">Edit Contact's Details</td>
								</tr>
								<tr class=\"row1\">
									<td><strong>First Name:</strong></td><td><input name=\"first_name\" type=\"text\" size=\"60\" value=\"" . $row['first_name'] . "\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Last Name:</strong></td><td><input name=\"last_name\" type=\"text\" size=\"60\" value=\"" . $row['last_name'] . "\" /></td>
								</tr>
								<tr class=\"row1\">
									<td><strong>Contact Category:</strong></td><td>" . createDropdown("contactcategories", "id", $row['cat_id'], "") . "</td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Address:</strong></td>
									<td>
										<input name=\"street_1\" type=\"text\" size=\"60\" value=\"" . $row['street_1'] . "\" /><br />
										<input name=\"street_2\" type=\"text\" size=\"60\" value=\"" . $row['street_2'] . "\" />
									</td>
								</tr>
								<tr class=\"row1\">
									<td><strong>City:</strong></td><td><input name=\"city\" type=\"text\" size=\"60\" value=\"" . $row['city'] . "\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>State:</strong></td><td><input name=\"state\" type=\"text\" size=\"60\" value=\"" . $row['state'] . "\" /></td>
								</tr>
								<tr class=\"row1\">
									<td><strong>Zip Code:</strong></td><td><input name=\"zip\" type=\"text\" size=\"60\" value=\"" . $row['zip'] . "\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Daytime Phone Number:</strong></td><td><input name=\"day_phone\" type=\"text\" size=\"60\" value=\"" . $row['day_phone'] . "\" /> ext. <input name=\"day_phone_ext\" type=\"text\" size=\"10\" value=\"" . $row['day_phone_ext'] . "\" /></td>
								</tr>
								<tr class=\"row1\">
									<td><strong>Nighttime Phone Number:</strong></td><td><input name=\"night_phone\" type=\"text\" size=\"60\" value=\"" . $row['night_phone'] . "\" /> ext. <input name=\"night_phone_ext\" type=\"text\" size=\"10\" value=\"" . $row['night_phone_ext'] . "\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Fax:</strong></td><td><input name=\"fax\" type=\"text\" size=\"60\" value=\"" . $row['fax'] . "\" /></td>
								</tr>
								<tr class=\"row1\">
									<td><strong>Email Address:</strong></td><td><input name=\"email_address\" type=\"text\" size=\"60\" value=\"" . $row['email_address'] . "\" /></td>
								</tr>
								<tr class=\"row2\">
									<td><strong>Website:</strong></td><td><input name=\"website\" type=\"text\" size=\"60\" value=\"" . $row['website'] . "\" /></td>
								</tr>
							</table>
							<br />
							<center><input type=\"submit\" name=\"submit\" class=\"button\" value=\"Update Contact's Details\" /></center>
						</form>
					</div>";							
			}			
		}
	}
	else {	
		
		//==================================================
		// Print out our contacts table
		//==================================================
		$sql = "SELECT * FROM `" . DBTABLEPREFIX . "contacts` ORDER BY last_name ASC";
		$result = mysql_query($sql);
		
		$x = 1; //reset the variable we use for our row colors	
		
		$content = "
					<div class=\"roundedBox\">
						<table class=\"contentBox\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">
							<tr>
								<td class=\"title1\" colspan=\"4\">
									<div style=\"float: right;\"><a href=\"" . $menuvar['CONTACTS'] . "&amp;action=newcontact\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/add.png\" alt=\"Add a new contact\" /></a></div>
									Current Contacts
								</td>
							</tr>							
							<tr class=\"title2\">
								<td><strong>Full Name</strong></td><td><strong>Category</strong></td><td></td>
							</tr>";
							
		if (!$result || mysql_num_rows($result) == 0) {
			$content .=			"<tr class=\"row1\">
									<td colspan=\"4\">
										There are no contacts currently in the system. Please add one.
									</td>
								</tr>";
		}
		else {
			while ($row = mysql_fetch_array($result)) {
				$content .=			"<tr id=\"" . $row['id'] . "_row\" class=\"row" . $x . "\">
									<td>" . $row['last_name'] . ", " . $row['first_name'] . "</td>
									<td>" . returnContactCategoryNameByID($row['cat_id']) . "</td>
									<td>
										<center><a href=\"" . $menuvar['CONTACTS'] . "&amp;action=editcontact&amp;id=" . $row['id'] . "\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/check.png\" alt=\"Edit Contact Details\" /></a> <a style=\"cursor: pointer; cursor: hand;\" onclick=\"ajaxDeleteNotifier('" . $row['id'] . "ContactSpinner', 'ajax.php?action=deleteitem&table=contacts&id=" . $row['id'] . "', 'contact', '" . $row['id'] . "_row');\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/delete.png\" alt=\"Delete Contact\" /></a><span id=\"" . $row['id'] . "ContactSpinner\" style=\"display: none;\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/indicator.gif\" alt=\"spinner\" /></span></center>
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
	$page->setTemplateVar("PageContent", $content);
}
else {
	$page->setTemplateVar("PageContent", "\nYou Are Not Authorized To Access This Area. Please Refrain From Trying To Do So Again.");
}
?>